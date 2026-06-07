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

        $jual_layak       = Penjualan::where('jenis_telur', 'layak')->sum('jumlah') * $bpk;
        $jual_tidak_layak = Penjualan::where('jenis_telur', 'tidak_layak')->sum('jumlah') * $bpk;

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

        // Validasi stok
        $query = Produksi::whereIn('status', ['final', 'approved']);
        if ($jumlahA > 0) {
            $stokLayak = $query->sum('telur_layak') - (Penjualan::where('jenis_telur', 'layak')->sum('jumlah') * $bpk);
            $stokLayakKg = $stokLayak / $bpk;
            if ($jumlahA > $stokLayakKg) {
                return back()->withErrors(['jumlah_a' => 'Stok Grade A tidak cukup! Sisa: ' . number_format($stokLayakKg, 2) . ' kg'])->withInput();
            }
        }
        if ($jumlahB > 0) {
            $stokTidakLayak = $query->sum('telur_tidak_layak') - (Penjualan::where('jenis_telur', 'tidak_layak')->sum('jumlah') * $bpk);
            $stokTidakLayakKg = $stokTidakLayak / $bpk;
            if ($jumlahB > $stokTidakLayakKg) {
                return back()->withErrors(['jumlah_b' => 'Stok Grade B tidak cukup! Sisa: ' . number_format($stokTidakLayakKg, 2) . ' kg'])->withInput();
            }
        }

        // Hitung total
        $totalA = $jumlahA * intval($request->harga_perkilo_a ?? 0);
        $totalB = $jumlahB * intval($request->harga_perkilo_b ?? 0);
        $grandTotal = $totalA + $totalB;

        // Status pembayaran
        $statusPembayaran = ($request->jenis_pembeli === 'Agen') ? ($request->status_pembayaran ?? 'lunas') : 'lunas';
        $dibayar   = $statusPembayaran === 'kasbon' ? floatval($request->dibayar ?? 0) : $grandTotal;
        $kekurangan = $statusPembayaran === 'kasbon' ? max(0, $grandTotal - $dibayar) : 0;

        // Upload bukti foto
        $buktiFoto = null;
        if ($request->hasFile('bukti_foto')) {
            $buktiFoto = $request->file('bukti_foto')->store('bukti_pembayaran', 'public');
        }

        // Buat record untuk Grade A jika ada
        if ($jumlahA > 0) {
            $dibayarA = ($jumlahA > 0 && $jumlahB > 0) ? round($dibayar * ($totalA / $grandTotal)) : $dibayar;
            $kekuranganA = $statusPembayaran === 'kasbon' ? max(0, $totalA - $dibayarA) : 0;

            Penjualan::create([
                'tanggal'           => $request->tanggal,
                'pembeli'           => $request->pembeli,
                'jenis_pembeli'     => $request->jenis_pembeli,
                'jenis_telur'       => 'layak',
                'jumlah'            => $jumlahA,
                'harga_perkilo'     => intval($request->harga_perkilo_a ?? 0),
                'total'             => $totalA,
                'status_pembayaran' => $statusPembayaran,
                'dibayar'           => $statusPembayaran === 'kasbon' ? $dibayarA : $totalA,
                'kekurangan'        => $kekuranganA,
                'bukti_foto'        => $buktiFoto,
            ]);
        }

        // Buat record untuk Grade B jika ada
        if ($jumlahB > 0) {
            $dibayarB = ($jumlahA > 0 && $jumlahB > 0) ? round($dibayar * ($totalB / $grandTotal)) : $dibayar;
            $kekuranganB = $statusPembayaran === 'kasbon' ? max(0, $totalB - $dibayarB) : 0;

            Penjualan::create([
                'tanggal'           => $request->tanggal,
                'pembeli'           => $request->pembeli,
                'jenis_pembeli'     => $request->jenis_pembeli,
                'jenis_telur'       => 'tidak_layak',
                'jumlah'            => $jumlahB,
                'harga_perkilo'     => intval($request->harga_perkilo_b ?? 0),
                'total'             => $totalB,
                'status_pembayaran' => $statusPembayaran,
                'dibayar'           => $statusPembayaran === 'kasbon' ? $dibayarB : $totalB,
                'kekurangan'        => $kekuranganB,
                'bukti_foto'        => $buktiFoto,
            ]);
        }

        if ($request->input('action') === 'cetak') {
            return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil dicatat.');
        }

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

        $tambah = $request->tambah_bayar;
        $penjualan->dibayar += $tambah;

        if ($penjualan->dibayar >= $penjualan->total) {
            $penjualan->dibayar           = $penjualan->total;
            $penjualan->status_pembayaran = 'lunas';
            $penjualan->kekurangan        = 0;
        } else {
            $penjualan->kekurangan = $penjualan->total - $penjualan->dibayar;
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

        return $pdf->stream('struk-penjualan-' . $penjualan->id . '.pdf');
    }
}
