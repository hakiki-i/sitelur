<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produksi;
use App\Models\Agen;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 25);
        $penjualan = Penjualan::orderByRaw("CASE WHEN is_po = 1 AND status_po = 'pending' THEN 0 ELSE 1 END ASC")
            ->orderByRaw("CASE WHEN is_po = 1 AND status_po = 'pending' THEN tanggal_ambil END ASC")
            ->orderBy('tanggal', 'desc')
            ->paginate($perPage)
            ->withQueryString();
        return view('penjualan.index', compact('penjualan', 'perPage'));
    }

    public function create()
    {
        $bpk = Pengaturan::butirPerKg();

        $telur_layak       = Produksi::stokLayak();
        $telur_tidak_layak = Produksi::stokTidakLayak();

        $stok_butir = $telur_layak + $telur_tidak_layak;
        $stok_kg    = floor($stok_butir / $bpk);

        $agens = Agen::all();

        return view('penjualan.create', compact(
            'stok_butir', 'stok_kg', 'telur_layak', 'telur_tidak_layak', 'agens', 'bpk'
        ));
    }

    public function store(Request $request)
    {
        $bpk = Pengaturan::butirPerKg();

        $request->validate([
            'tanggal'           => 'required|date',
            'pembeli'           => 'required',
            'jenis_pembeli'     => 'required',
            'jumlah_a'          => 'nullable|numeric|min:0',
            'jumlah_b'          => 'nullable|numeric|min:0',
            'harga_perkilo_a'   => 'nullable|integer|min:0',
            'harga_perkilo_b'   => 'nullable|integer|min:0',
            'status_pembayaran' => 'nullable|string',
            'dibayar'           => 'nullable|numeric',
            'bukti_foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_po'             => 'nullable|boolean',
            'tanggal_ambil'     => 'required_if:is_po,1|nullable|date',
        ]);

        $jumlahA = floatval($request->jumlah_a ?? 0);
        $jumlahB = floatval($request->jumlah_b ?? 0);

        if ($jumlahA <= 0 && $jumlahB <= 0) {
            return back()->withErrors(['jumlah_a' => 'Harap isi minimal satu jenis telur (Grade A atau Grade B)!'])->withInput();
        }

        $isPo = $request->boolean('is_po', false);

        // Validasi stok Grade A (hanya jika bukan PO)
        if (!$isPo && $jumlahA > 0) {
            $stokLayak = Produksi::stokLayak();
            $stokLayakKg = $stokLayak / $bpk;
            if ($jumlahA > $stokLayakKg) {
                return back()->withErrors(['jumlah_a' => 'Stok Grade A tidak cukup! Sisa: ' . number_format($stokLayakKg, 2) . ' kg'])->withInput();
            }
        }

        // Validasi stok Grade B (hanya jika bukan PO)
        if (!$isPo && $jumlahB > 0) {
            $stokTidakLayak = Produksi::stokTidakLayak();
            $stokBKg = $stokTidakLayak / $bpk;
            if ($jumlahB > $stokBKg) {
                return back()->withErrors(['jumlah_b' => 'Stok Grade B tidak cukup! Sisa: ' . number_format($stokBKg, 2) . ' kg'])->withInput();
            }
        }

        // Hitung total
        $hargaA  = intval($request->harga_perkilo_a ?? 0);
        $hargaB  = intval($request->harga_perkilo_b ?? 0);
        $totalA  = $jumlahA * $hargaA;
        $totalB  = $jumlahB * $hargaB;
        $grandTotal = $totalA + $totalB;

        // Tentukan jenis_telur
        if ($jumlahA > 0 && $jumlahB > 0) {
            $jenisTelur = 'keduanya';
        } elseif ($jumlahA > 0) {
            $jenisTelur = 'layak';
        } else {
            $jenisTelur = 'tidak_layak';
        }

        // Status pembayaran
        $statusPembayaran = ($request->jenis_pembeli === 'Agen' || $isPo) ? ($request->status_pembayaran ?? 'lunas') : 'lunas';
        $dibayar    = $statusPembayaran === 'kasbon' ? floatval($request->dibayar ?? 0) : $grandTotal;
        $kekurangan = $statusPembayaran === 'kasbon' ? max(0, $grandTotal - $dibayar) : 0;

        // Upload bukti foto
        $buktiFoto = null;
        if ($request->hasFile('bukti_foto')) {
            $buktiFoto = $request->file('bukti_foto')->store('bukti_pembayaran', 'public');
        }

        $penjualan = Penjualan::create([
            'tanggal'           => $request->tanggal,
            'pembeli'           => $request->pembeli,
            'jenis_pembeli'     => $request->jenis_pembeli,
            'jenis_telur'       => $jenisTelur,
            // Grade A (atau satu-satunya jika hanya B, maka ini 0)
            'jumlah'            => $jumlahA > 0 ? $jumlahA : $jumlahB,
            'harga_perkilo'     => $jumlahA > 0 ? $hargaA : $hargaB,
            'total'             => $jumlahA > 0 ? $totalA : $totalB,
            // Grade B (hanya terisi jika keduanya)
            'jumlah_b'          => $jenisTelur === 'keduanya' ? $jumlahB : 0,
            'harga_perkilo_b'   => $jenisTelur === 'keduanya' ? $hargaB : 0,
            'total_b'           => $jenisTelur === 'keduanya' ? $totalB : 0,
            // Grand total
            'status_pembayaran' => $statusPembayaran,
            'dibayar'           => $dibayar,
            'kekurangan'        => $kekurangan,
            'bukti_foto'        => $buktiFoto,
            'is_po'             => $isPo,
            'tanggal_ambil'     => $isPo ? $request->tanggal_ambil : null,
            'status_po'         => $isPo ? 'pending' : null,
        ]);

        return redirect()->route('penjualan.index')->with('success', 'Transaksi penjualan berhasil dicatat.');
    }

    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $agens = Agen::all();
        $bpk = Pengaturan::butirPerKg();

        $stok_layak = Produksi::stokLayak();
        $stok_tidak_layak = Produksi::stokTidakLayak();

        // Tentukan apakah transaksi ini mengurangi stok tersedia saat ini (penjualan langsung, PO diambil, atau PO pending terkunci)
        $mengurangi_stok = false;
        if ($penjualan->is_po == 0 || $penjualan->status_po === 'diambil') {
            $mengurangi_stok = true;
        } elseif ($penjualan->is_po == 1 && $penjualan->status_po === 'pending') {
            if ($penjualan->tanggal_ambil <= now()->addDays(2)->toDateString()) {
                $mengurangi_stok = true;
            }
        }

        if ($mengurangi_stok) {
            // Tambahkan kembali sisa alokasi transaksi ini agar bisa diedit
            if ($penjualan->jenis_telur === 'keduanya') {
                $stok_layak += $penjualan->jumlah * $bpk;
                $stok_tidak_layak += $penjualan->jumlah_b * $bpk;
            } elseif ($penjualan->jenis_telur === 'layak') {
                $stok_layak += $penjualan->jumlah * $bpk;
            } elseif ($penjualan->jenis_telur === 'tidak_layak') {
                $stok_tidak_layak += $penjualan->jumlah * $bpk;
            }
        }

        // Quantities
        $jumlah_a = ($penjualan->jenis_telur === 'layak' || $penjualan->jenis_telur === 'keduanya') ? $penjualan->jumlah : 0;
        $jumlah_b = ($penjualan->jenis_telur === 'keduanya') ? $penjualan->jumlah_b : ($penjualan->jenis_telur === 'tidak_layak' ? $penjualan->jumlah : 0);

        // Prices
        $harga_a = ($penjualan->jenis_telur === 'layak' || $penjualan->jenis_telur === 'keduanya') 
            ? $penjualan->harga_perkilo 
            : (\App\Models\HargaTelur::orderBy('created_at','desc')->value('harga_layak') ?? 0);

        $harga_b = ($penjualan->jenis_telur === 'keduanya') 
            ? $penjualan->harga_perkilo_b 
            : ($penjualan->jenis_telur === 'tidak_layak' 
                ? $penjualan->harga_perkilo 
                : (\App\Models\HargaTelur::orderBy('created_at','desc')->value('harga_tidak_layak') ?? 0));

        return view('penjualan.edit', compact(
            'penjualan', 'agens', 'bpk', 'stok_layak', 'stok_tidak_layak', 'jumlah_a', 'jumlah_b', 'harga_a', 'harga_b'
        ));
    }

    public function update(Request $request, $id)
    {
        $bpk = Pengaturan::butirPerKg();
        $penjualan = Penjualan::findOrFail($id);

        $request->validate([
            'tanggal'           => 'required|date',
            'pembeli'           => 'required',
            'jenis_pembeli'     => 'required',
            'jumlah_a'          => 'nullable|numeric|min:0',
            'jumlah_b'          => 'nullable|numeric|min:0',
            'harga_perkilo_a'   => 'nullable|integer|min:0',
            'harga_perkilo_b'   => 'nullable|integer|min:0',
            'status_pembayaran' => 'nullable|string',
            'dibayar'           => 'nullable|numeric',
            'bukti_foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_po'             => 'nullable|boolean',
            'tanggal_ambil'     => 'required_if:is_po,1|nullable|date',
        ]);

        $jumlahA = floatval($request->jumlah_a ?? 0);
        $jumlahB = floatval($request->jumlah_b ?? 0);

        if ($jumlahA <= 0 && $jumlahB <= 0) {
            return back()->withErrors(['jumlah_a' => 'Harap isi minimal satu jenis telur (Grade A atau Grade B)!'])->withInput();
        }

        $isPo = $request->boolean('is_po', false);

        // Validasi stok Grade A (hanya jika bukan PO)
        if (!$isPo && $jumlahA > 0) {
            $stok_layak_avail = Produksi::stokLayak();
            
            $mengurangi_stok = false;
            if ($penjualan->is_po == 0 || $penjualan->status_po === 'diambil') {
                $mengurangi_stok = true;
            } elseif ($penjualan->is_po == 1 && $penjualan->status_po === 'pending') {
                if ($penjualan->tanggal_ambil <= now()->addDays(2)->toDateString()) {
                    $mengurangi_stok = true;
                }
            }
            
            if ($mengurangi_stok) {
                if ($penjualan->jenis_telur === 'keduanya' || $penjualan->jenis_telur === 'layak') {
                    $stok_layak_avail += $penjualan->jumlah * $bpk;
                }
            }

            $stokLayakKg = $stok_layak_avail / $bpk;
            if ($jumlahA > $stokLayakKg) {
                return back()->withErrors(['jumlah_a' => 'Stok Grade A tidak cukup! Sisa: ' . number_format($stokLayakKg, 2) . ' kg'])->withInput();
            }
        }

        // Validasi stok Grade B (hanya jika bukan PO)
        if (!$isPo && $jumlahB > 0) {
            $stok_tidak_layak_avail = Produksi::stokTidakLayak();
            
            $mengurangi_stok = false;
            if ($penjualan->is_po == 0 || $penjualan->status_po === 'diambil') {
                $mengurangi_stok = true;
            } elseif ($penjualan->is_po == 1 && $penjualan->status_po === 'pending') {
                if ($penjualan->tanggal_ambil <= now()->addDays(2)->toDateString()) {
                    $mengurangi_stok = true;
                }
            }
            
            if ($mengurangi_stok) {
                if ($penjualan->jenis_telur === 'keduanya') {
                    $stok_tidak_layak_avail += $penjualan->jumlah_b * $bpk;
                } elseif ($penjualan->jenis_telur === 'tidak_layak') {
                    $stok_tidak_layak_avail += $penjualan->jumlah * $bpk;
                }
            }

            $stokBKg = $stok_tidak_layak_avail / $bpk;
            if ($jumlahB > $stokBKg) {
                return back()->withErrors(['jumlah_b' => 'Stok Grade B tidak cukup! Sisa: ' . number_format($stokBKg, 2) . ' kg'])->withInput();
            }
        }

        // Hitung total
        $hargaA  = intval($request->harga_perkilo_a ?? 0);
        $hargaB  = intval($request->harga_perkilo_b ?? 0);
        $totalA  = $jumlahA * $hargaA;
        $totalB  = $jumlahB * $hargaB;
        $grandTotal = $totalA + $totalB;

        // Tentukan jenis_telur
        if ($jumlahA > 0 && $jumlahB > 0) {
            $jenisTelur = 'keduanya';
        } elseif ($jumlahA > 0) {
            $jenisTelur = 'layak';
        } else {
            $jenisTelur = 'tidak_layak';
        }

        // Status pembayaran
        $statusPembayaran = ($request->jenis_pembeli === 'Agen' || $isPo) ? ($request->status_pembayaran ?? 'lunas') : 'lunas';
        $dibayar    = $statusPembayaran === 'kasbon' ? floatval($request->dibayar ?? 0) : $grandTotal;
        $kekurangan = $statusPembayaran === 'kasbon' ? max(0, $grandTotal - $dibayar) : 0;

        // Upload bukti foto
        $buktiFoto = $penjualan->bukti_foto;
        if ($request->hasFile('bukti_foto')) {
            if ($penjualan->bukti_foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($penjualan->bukti_foto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($penjualan->bukti_foto);
            }
            $buktiFoto = $request->file('bukti_foto')->store('bukti_pembayaran', 'public');
        }

        $penjualan->update([
            'tanggal'           => $request->tanggal,
            'pembeli'           => $request->pembeli,
            'jenis_pembeli'     => $request->jenis_pembeli,
            'jenis_telur'       => $jenisTelur,
            'jumlah'            => $jumlahA > 0 ? $jumlahA : $jumlahB,
            'harga_perkilo'     => $jumlahA > 0 ? $hargaA : $hargaB,
            'total'             => $jumlahA > 0 ? $totalA : $totalB,
            'jumlah_b'          => $jenisTelur === 'keduanya' ? $jumlahB : 0,
            'harga_perkilo_b'   => $jenisTelur === 'keduanya' ? $hargaB : 0,
            'total_b'           => $jenisTelur === 'keduanya' ? $totalB : 0,
            'status_pembayaran' => $statusPembayaran,
            'dibayar'           => $dibayar,
            'kekurangan'        => $kekurangan,
            'bukti_foto'        => $buktiFoto,
            'is_po'             => $isPo,
            'tanggal_ambil'     => $isPo ? $request->tanggal_ambil : null,
            'status_po'         => $isPo ? ($penjualan->status_po ?? 'pending') : null,
        ]);

        return redirect()->route('penjualan.index')->with('success', 'Transaksi penjualan berhasil diupdate.');
    }

    public function ambil($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        if (!$penjualan->is_po || $penjualan->status_po !== 'pending') {
            return back()->with('error', 'Transaksi ini bukan Pre-Order pending.');
        }

        $penjualan->status_po = 'diambil';
        $penjualan->save();

        return back()->with('success', 'Telur Pre-Order berhasil diambil. Stok telah terpotong otomatis.');
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        if ($penjualan->bukti_foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($penjualan->bukti_foto)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($penjualan->bukti_foto);
        }
        $penjualan->delete();
        return redirect()->route('penjualan.index')->with('success', 'Transaksi penjualan berhasil dihapus.');
    }

    public function bayar(Request $request, $id)
    {
        $request->validate([
            'tambah_bayar' => 'required|numeric|min:1'
        ]);

        $penjualan = Penjualan::findOrFail($id);
        $grandTotal = $penjualan->total + ($penjualan->total_b ?? 0);

        $tambah = $request->tambah_bayar;
        $penjualan->dibayar += $tambah;

        if ($penjualan->dibayar >= $grandTotal) {
            $penjualan->dibayar           = $grandTotal;
            $penjualan->status_pembayaran = 'lunas';
            $penjualan->kekurangan        = 0;
        } else {
            $penjualan->kekurangan = $grandTotal - $penjualan->dibayar;
        }

        $penjualan->save();

        return back()->with('success', 'Pembayaran kasbon berhasil ditambahkan sejumlah Rp ' . number_format($tambah, 0, ',', '.'));
    }

    public function print($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $invoice = 'INV-' . date('Ymd', strtotime($penjualan->tanggal)) . '-' . str_pad($penjualan->id, 4, '0', STR_PAD_LEFT);

        return view('penjualan.print', compact('penjualan', 'invoice'));
    }

    public function pdf($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('penjualan.pdf', compact('penjualan'));

        // 80mm width is 226.77 pt. Let's make height 320 pt.
        $pdf->setPaper([0, 0, 226.77, 320], 'portrait');

        return $pdf->stream('nota-penjualan-' . $penjualan->id . '.pdf');
    }
}
