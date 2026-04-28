<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HargaTelur;

class HargaTelurController extends Controller
{
    public function index()
    {
        $listHarga = HargaTelur::orderBy('tanggal', 'desc')->get();
        $latestHarga = HargaTelur::orderBy('created_at', 'desc')->first();
        return view('harga_telur.index', compact('listHarga', 'latestHarga'));
    }

    public function create() { abort(404); }
    public function edit($id) { abort(404); }
    public function update(Request $request, $id) { abort(404); }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'harga_layak' => 'nullable|integer|min:0',
            'harga_tidak_layak' => 'nullable|integer|min:0',
        ]);
        $tanggal = $request->input('tanggal');
        $last = HargaTelur::orderBy('tanggal', 'desc')->first();
        $harga_layak = $request->filled('harga_layak') ? $request->harga_layak : ($last ? $last->harga_layak : 0);
        $harga_tidak_layak = $request->filled('harga_tidak_layak') ? $request->harga_tidak_layak : ($last ? $last->harga_tidak_layak : 0);
        HargaTelur::create([
            'tanggal' => $tanggal,
            'harga_layak' => $harga_layak,
            'harga_tidak_layak' => $harga_tidak_layak,
        ]);
        return redirect()->route('harga_telur.index')->with('success', 'Data harga telur berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        HargaTelur::findOrFail($id)->delete();
        return redirect()->route('harga_telur.index')->with('success', 'Data harga telur berhasil dihapus.');
    }
}
