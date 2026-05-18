<?php

namespace App\Http\Controllers;

use App\Models\Agen;
use Illuminate\Http\Request;

class AgenController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 25);
        $agens = Agen::orderBy('nama_agen')->paginate($perPage)->withQueryString();
        
        $agens->getCollection()->transform(function ($agen) {
            $agen->total_hutang = \App\Models\Penjualan::where('jenis_pembeli', 'Agen')
                                    ->where('pembeli', $agen->nama_agen)
                                    ->sum('kekurangan');
            return $agen;
        });
        
        return view('agen.index', compact('agens', 'perPage'));
    }

    public function create()
    {
        return view('agen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_agen' => 'required',
        ]);

        Agen::create($request->all());
        return redirect()->route('agen.index')->with('success', 'Data Agen berhasil ditambahkan.');
    }

    public function edit(Agen $agen)
    {
        return view('agen.edit', compact('agen'));
    }

    public function update(Request $request, Agen $agen)
    {
        $request->validate([
            'nama_agen' => 'required',
        ]);

        $agen->update($request->all());
        return redirect()->route('agen.index')->with('success', 'Data Agen berhasil diupdate.');
    }

    public function destroy(Agen $agen)
    {
        $agen->delete();
        return redirect()->route('agen.index')->with('success', 'Data Agen berhasil dihapus.');
    }

    public function riwayat($id)
    {
        $agen = Agen::findOrFail($id);
        
        // Ambil riwayat pembelian berdasarkan nama_agen
        $riwayatPembelian = \App\Models\Penjualan::where('jenis_pembeli', 'Agen')
            ->where('pembeli', $agen->nama_agen)
            ->orderBy('tanggal', 'desc')
            ->get();
            
        return view('agen.riwayat', compact('agen', 'riwayatPembelian'));
    }
}
