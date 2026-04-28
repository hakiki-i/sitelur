<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produksi;
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
        // Hanya produksi dengan status 'final' atau 'approved' yang dihitung stok
        $query = Produksi::whereIn('status', ['final', 'approved']);
        // Total produksi
        $total_layak = $query->sum('telur_layak');
        $total_tidak_layak = $query->sum('telur_tidak_layak');

        // Total penjualan per jenis
        $jual_layak = Penjualan::where('jenis_telur', 'layak')->sum('jumlah') * 15;
        $jual_tidak_layak = Penjualan::where('jenis_telur', 'tidak_layak')->sum('jumlah') * 15;

        // Sisa stok per jenis
        $stok_layak = $total_layak - $jual_layak;
        $stok_tidak_layak = $total_tidak_layak - $jual_tidak_layak;

        // Stok total (butir dan kg)
        $stok_butir = $stok_layak + $stok_tidak_layak;
        $stok_kg = floor($stok_butir / 15);

        $telur_layak = $stok_layak;
        $telur_tidak_layak = $stok_tidak_layak;

        return view('penjualan.create', compact('stok_butir', 'stok_kg', 'telur_layak', 'telur_tidak_layak'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'pembeli' => 'required',
            'jumlah' => 'required|integer|min:1',
            'harga_perkilo' => 'required|integer|min:0',
            'bukti_foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data = $request->all();
        $data['total'] = $data['jumlah'] * $data['harga_perkilo'];

        // Konversi jumlah penjualan (kg) ke butir
        $jumlah_butir = $data['jumlah'] * 15;

        // Hitung stok produksi (butir) hanya dari status 'final' atau 'approved'
        $stok_produksi = Produksi::whereIn('status', ['final', 'approved'])->sum('jumlah') - (Penjualan::sum('jumlah') * 15);

        if ($jumlah_butir > $stok_produksi) {
            return back()->withErrors(['jumlah' => 'Stok produksi tidak cukup! Sisa stok: ' . $stok_produksi . ' butir (' . floor($stok_produksi/15) . ' kg)'])->withInput();
        }

        if ($request->hasFile('bukti_foto')) {
            $file = $request->file('bukti_foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/bukti_penjualan', $filename);
            $data['bukti_foto'] = $filename;
        }
        Penjualan::create($data);
        return redirect()->route('penjualan.index')->with('success', 'Transaksi penjualan berhasil dicatat. Penjualan ini mengurangi stok produksi sebanyak ' . $jumlah_butir . ' butir.');
    }

    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        return view('penjualan.edit', compact('penjualan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'pembeli' => 'required',
            'jumlah' => 'required|integer|min:1',
            'harga_perkilo' => 'required|integer|min:0',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data = $request->all();
        $data['total'] = $data['jumlah'] * $data['harga_perkilo'];
        $penjualan = Penjualan::findOrFail($id);
        if ($request->hasFile('bukti_foto')) {
            $file = $request->file('bukti_foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/bukti_penjualan', $filename);
            $data['bukti_foto'] = $filename;
        }
        $penjualan->update($data);
        return redirect()->route('penjualan.index')->with('success', 'Transaksi penjualan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        // Tidak perlu mengembalikan stok, cukup hapus data
        $penjualan->delete();
        return redirect()->route('penjualan.index')->with('success', 'Transaksi penjualan berhasil dihapus.');
    }
}
