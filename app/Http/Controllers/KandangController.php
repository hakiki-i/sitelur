<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use Illuminate\Http\Request;

class KandangController extends Controller
{
    // API: GET /api/kandang
    public function apiIndex()
    {
        $kandang = Kandang::all(['id', 'nama_kandang']);

        // Format response
        $result = $kandang->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama_kandang,
                'kapasitas' => $item->jumlah_ayam
            ];
        });

        return response()->json($result);
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