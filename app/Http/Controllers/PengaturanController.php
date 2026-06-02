<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $butirPerKg = Pengaturan::butirPerKg();
        return view('pengaturan.index', compact('butirPerKg'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'butir_per_kg' => 'required|integer|min:1|max:1000',
        ], [
            'butir_per_kg.required' => 'Nilai konversi butir/kg wajib diisi.',
            'butir_per_kg.integer'  => 'Nilai harus berupa angka bulat.',
            'butir_per_kg.min'      => 'Nilai minimal adalah 1.',
            'butir_per_kg.max'      => 'Nilai maksimal adalah 1000.',
        ]);

        Pengaturan::set('butir_per_kg', $request->butir_per_kg);

        return redirect()->back()->with('success', 'Pengaturan konversi telur berhasil disimpan. (1 kg = ' . $request->butir_per_kg . ' butir)');
    }
}
