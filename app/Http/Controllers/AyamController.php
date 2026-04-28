<?php

namespace App\Http\Controllers;

use App\Models\Ayam;
use App\Models\Kandang;
use Illuminate\Http\Request;

class AyamController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 25);
        $ayam = Ayam::with('kandang')->paginate($perPage);
        return view('ayam.index', compact('ayam', 'perPage'));
    }

    public function create()
    {
        // Ambil kandang yang belum pernah dipakai di tabel ayam
        $kandang = Kandang::whereDoesntHave('ayam')->get();
        return view('ayam.create', compact('kandang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'nama_ayam' => 'required',
            'tanggal_masuk' => 'required|date',
            'kandang_id' => 'required|exists:kandang,id',
        ]);
            $validated = $request->validate([
                'kandang_id' => 'required|exists:kandang,id',
                'jumlah_ayam' => 'required|integer|min:1',
                'tanggal_masuk' => 'required|date|before_or_equal:today',
            ]);

            // Ambil kapasitas kandang
            $kandang = \App\Models\Kandang::find($validated['kandang_id']);
            if ($kandang && $validated['jumlah_ayam'] > $kandang->jumlah_ayam) {
                return back()->withInput()->withErrors(['jumlah_ayam' => 'Jumlah ayam tidak boleh melebihi kapasitas kandang (' . $kandang->jumlah_ayam . ').']);
            }

            Ayam::create($validated);

            return redirect()->route('ayam.index')->with('success', 'Data ayam berhasil ditambahkan.');
        // dd($data); // debug: tampilkan data yang akan disimpan
        Ayam::create($data);
        return redirect()->route('ayam.index')->with('success', 'Data ayam berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $ayam = Ayam::findOrFail($id);
        // Ambil kandang yang belum pernah dipakai di tabel ayam, atau kandang yang sedang dipakai oleh ayam ini
        $kandang = Kandang::where(function($query) use ($ayam) {
            $query->whereDoesntHave('ayam')
                  ->orWhere('id', $ayam->kandang_id);
        })->get();
        return view('ayam.edit', compact('ayam', 'kandang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // 'nama_ayam' => 'required',
            'tanggal_masuk' => 'required|date',
            'kandang_id' => 'exists:kandang,id',
        ]);
            $validated = $request->validate([
                'kandang_id' => 'required|exists:kandang,id',
                'jumlah_ayam' => 'required|integer|min:1',
                'tanggal_masuk' => 'required|date|before_or_equal:today',
            ]);

            $kandang = \App\Models\Kandang::find($validated['kandang_id']);
            if ($kandang && $validated['jumlah_ayam'] > $kandang->jumlah_ayam) {
                return back()->withInput()->withErrors(['jumlah_ayam' => 'Jumlah ayam tidak boleh melebihi kapasitas kandang (' . $kandang->jumlah_ayam . ').']);
            }

            $ayam = Ayam::findOrFail($id);
            $ayam->update($validated);

            return redirect()->route('ayam.index')->with('success', 'Data ayam berhasil diupdate.');
        return redirect()->route('ayam.index')->with('success', 'Data ayam berhasil diupdate.');
    }

    public function destroy($id)
    {
        $ayam = Ayam::findOrFail($id);
        $ayam->delete();
        return redirect()->route('ayam.index')->with('success', 'Data ayam berhasil dihapus.');
    }
}
