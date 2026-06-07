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
        $penjualan = Penjualan::orderBy('tanggal', 'desc')->paginate($perPage)->withQueryString();
        return view('penjualan.index', compact('penjualan', 'perPage'));
    }

    public function create()
    {
        $bpk = Pengaturan::butirPerKg();

        $query = Produksi::whereIn('status', ['final', 'approved']);
        $total_layak = $query->sum('telur_layak');
        $total_tidak_layak = $query->sum('telur_tidak_layak');

        // Hitung total jumlah Grade A yang sudah terjual (dari record layak + keduanya)
        $jual_layak = Penjualan::whereIn('jenis_telur', ['layak', 'keduanya'])->sum('jumlah') * $bpk;
        // Hitung total jumlah Grade B yang sudah terjual (dari record tidak_layak + keduanya jumlah_b)
        $jual_tidak_layak = (Penjualan::where('jenis_telur', 'tidak_layak')->sum('jumlah')
                            + Penjualan::where('jenis_telur', 'keduanya')->sum('jumlah_b')) * $bpk;

        $stok_layak       = $total_layak - $jual_layak;
        $stok_tidak_layak = $total_tidak_layak - $jual_tidak_layak;

        $stok_butir = $stok_layak + $stok_tidak_layak;
        $stok_kg    = floor($stok_butir / $bpk);

        $telur_layak       = $stok_layak;
        $telur_tidak_layak = $stok_tidak_layak;

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
        ]);

        $jumlahA = floatval($request->jumlah_a ?? 0);
        $jumlahB = floatval($request->jumlah_b ?? 0);

        if ($jumlahA <= 0 && $jumlahB <= 0) {
            return back()->withErrors(['jumlah_a' => 'Harap isi minimal satu jenis telur (Grade A atau Grade B)!'])->withInput();
        }

        // Validasi stok Grade A
        $query = Produksi::whereIn('status', ['final', 'approved']);
        if ($jumlahA > 0) {
            $stokLayak = $query->sum('telur_layak')
                - (Penjualan::whereIn('jenis_telur', ['layak', 'keduanya'])->sum('jumlah') * $bpk);
            $stokLayakKg = $stokLayak / $bpk;
            if ($jumlahA > $stokLayakKg) {
                return back()->withErrors(['jumlah_a' => 'Stok Grade A tidak cukup! Sisa: ' . number_format($stokLayakKg, 2) . ' kg'])->withInput();
            }
        }

        // Validasi stok Grade B
        if ($jumlahB > 0) {
            $stokB = $query->sum('telur_tidak_layak')
                - ((Penjualan::where('jenis_telur', 'tidak_layak')->sum('jumlah')
                    + Penjualan::where('jenis_telur', 'keduanya')->sum('jumlah_b')) * $bpk);
            $stokBKg = $stokB / $bpk;
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
        $statusPembayaran = ($request->jenis_pembeli === 'Agen') ? ($request->status_pembayaran ?? 'lunas') : 'lunas';
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
        ]);

        return redirect()->route('penjualan.index')->with('success', 'Transaksi penjualan berhasil dicatat.');
    }

    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $agens = Agen::all();
        return view('penjualan.edit', compact('penjualan', 'agens'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal'          => 'required|date',
            'pembeli'          => 'required',
            'jenis_pembeli'    => 'required',
            'jumlah'           => 'required|numeric|min:0.1',
            'harga_perkilo'    => 'required|integer|min:0',
            'status_pembayaran'=> 'nullable|string',
            'dibayar'          => 'nullable|numeric',
            'bukti_foto'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $data['total'] = $data['jumlah'] * $data['harga_perkilo'];

        if (($data['status_pembayaran'] ?? 'lunas') === 'kasbon') {
            $data['dibayar']    = $data['dibayar'] ?? 0;
            $data['kekurangan'] = max(0, $data['total'] - $data['dibayar']);
        } else {
            $data['status_pembayaran'] = 'lunas';
            $data['dibayar']           = $data['total'];
            $data['kekurangan']        = 0;
        }

        $penjualan = Penjualan::findOrFail($id);

        if ($request->hasFile('bukti_foto')) {
            if ($penjualan->bukti_foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($penjualan->bukti_foto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($penjualan->bukti_foto);
            }
            $path = $request->file('bukti_foto')->store('bukti_pembayaran', 'public');
            $data['bukti_foto'] = $path;
        }

        $penjualan->update($data);

        return redirect()->route('penjualan.index')->with('success', 'Transaksi penjualan berhasil diupdate.');
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

