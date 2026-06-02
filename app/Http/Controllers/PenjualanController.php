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
            'tanggal'          => 'required|date',
            'pembeli'          => 'required',
            'jenis_pembeli'    => 'required',
            'jumlah'           => 'required|numeric|min:0.1',
            'harga_perkilo'    => 'required|integer|min:0',
            'jenis_telur'      => 'required',
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

        $jumlah_butir = $data['jumlah'] * $bpk;

        // Cek stok berdasarkan jenis telur
        $query = Produksi::whereIn('status', ['final', 'approved']);
        if ($data['jenis_telur'] == 'layak') {
            $stok_tersedia = $query->sum('telur_layak') - (Penjualan::where('jenis_telur', 'layak')->sum('jumlah') * $bpk);
        } else {
            $stok_tersedia = $query->sum('telur_tidak_layak') - (Penjualan::where('jenis_telur', 'tidak_layak')->sum('jumlah') * $bpk);
        }

        if ($jumlah_butir > $stok_tersedia) {
            $jenis_label = $data['jenis_telur'] == 'layak' ? 'layak' : 'tidak layak';
            return back()->withErrors([
                'jumlah' => 'Stok telur ' . $jenis_label . ' tidak cukup! Sisa stok: '
                    . $stok_tersedia . ' butir (' . number_format($stok_tersedia / $bpk, 2) . ' kg)'
            ])->withInput();
        }

        if ($request->hasFile('bukti_foto')) {
            $path = $request->file('bukti_foto')->store('bukti_pembayaran', 'public');
            $data['bukti_foto'] = $path;
        }

        $penjualan = Penjualan::create($data);

        if ($request->input('action') === 'cetak') {
            return redirect()->route('penjualan.print', $penjualan->id);
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
