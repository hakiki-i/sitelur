<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use Illuminate\Http\Request;

class KandangController extends Controller
{
    // API: GET /api/kandang

    public function apiIndex(Request $request)
    {
        $kandang = Kandang::all()->map(function($kandang) {
            $jumlah_ayam_terisi = \App\Models\Ayam::where('kandang_id', $kandang->id)->sum('jumlah_ayam');
            return [
                'id' => $kandang->id,
                'nama' => $kandang->nama_kandang,
                'kapasitas' => $kandang->jumlah_ayam, // kapasitas dari field jumlah_ayam di tabel kandang
                'jumlah_ayam' => $jumlah_ayam_terisi   // jumlah terisi dari tabel ayam
            ];
        });
        return response()->json($kandang);
    }

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 25);
        $kandang = Kandang::paginate($perPage);

        return view('kandang.index', compact('kandang', 'perPage'));
    }

    public function create()
    {
        return view('kandang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kandang' => 'required',
            'jumlah_ayam' => 'required|integer',
        ]);

        Kandang::create($request->all());

        return redirect()->route('kandang.index')
                         ->with('success', 'Data kandang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kandang = Kandang::findOrFail($id);
        return view('kandang.edit', compact('kandang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kandang' => 'required',
            'jumlah_ayam' => 'required|integer',
        ]);

        $kandang = Kandang::findOrFail($id);
        $kandang->update($request->all());

        return redirect()->route('kandang.index')
                         ->with('success', 'Data kandang berhasil diperbarui');
    }

    public function destroy($id)
    {
        Kandang::destroy($id);

        return redirect()->route('kandang.index')
                         ->with('success', 'Data kandang berhasil dihapus');
    }
}