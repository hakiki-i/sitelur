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
        $statusFilter = $request->input('status_produktif');
        $bulanFilter = $request->input('bulan_masuk'); // Format: YYYY-MM

        $ayamAll = Ayam::where('status', 'aktif')->with('kandang')->get();
        $countPuncak = 0;
        $countStabil = 0;
        $countTurun = 0;

        foreach ($ayamAll as $a) {
            $tanggal_masuk = \Carbon\Carbon::parse($a->tanggal_masuk);
            $now = \Carbon\Carbon::now();
            $totalDays = 140 + $tanggal_masuk->diffInDays($now);
            $umurMinggu = floor($totalDays / 7);
            
            if ($umurMinggu >= 20 && $umurMinggu <= 30) {
                $countPuncak++;
            } elseif ($umurMinggu >= 31 && $umurMinggu <= 79) {
                $countStabil++;
            } elseif ($umurMinggu >= 80) {
                $countTurun++;
            }
        }

        $ayamList = $ayamAll->filter(function($a) use ($statusFilter, $bulanFilter) {
            $tanggal_masuk = \Carbon\Carbon::parse($a->tanggal_masuk);
            
            if ($bulanFilter) {
                if ($tanggal_masuk->format('Y-m') !== $bulanFilter) {
                    return false;
                }
            }

            if (!$statusFilter) return true;
            
            $now = \Carbon\Carbon::now();
            $totalDays = 140 + $tanggal_masuk->diffInDays($now);
            $umurMinggu = floor($totalDays / 7);
            
            $status = '';
            if ($umurMinggu >= 20 && $umurMinggu <= 30) $status = 'puncak';
            elseif ($umurMinggu >= 31 && $umurMinggu <= 79) $status = 'stabil';
            elseif ($umurMinggu >= 80) $status = 'turun';
            
            return $status == $statusFilter;
        });

        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $ayam = new \Illuminate\Pagination\LengthAwarePaginator(
            $ayamList->forPage($page, $perPage)->values(),
            $ayamList->count(),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        return view('ayam.index', compact('ayam', 'perPage', 'countPuncak', 'countStabil', 'countTurun', 'statusFilter', 'bulanFilter'));
    }

    public function create()
    {
        // Ambil kandang yang belum pernah dipakai di tabel ayam ATAU yang semua ayamnya sudah 'keluar'
        $kandang = Kandang::whereDoesntHave('ayam', function ($query) {
            $query->where('status', 'aktif');
        })->get();
        return view('ayam.create', compact('kandang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kandang_id' => 'required|exists:kandang,id',
            'jumlah_ayam' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date|before_or_equal:today',
            'keterangan' => 'nullable|string',
        ]);

        // Ambil kapasitas kandang
        $kandang = \App\Models\Kandang::find($validated['kandang_id']);
        if ($kandang && $validated['jumlah_ayam'] > $kandang->jumlah_ayam) {
            return back()->withInput()->withErrors(['jumlah_ayam' => 'Jumlah ayam tidak boleh melebihi kapasitas kandang (' . $kandang->jumlah_ayam . ').']);
        }

        $validated['nama_ayam'] = 'Ayam Petelur';
        Ayam::create($validated);

        return redirect()->route('ayam.index')->with('success', 'Data ayam berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $ayam = Ayam::findOrFail($id);
        $kandang = Kandang::where(function($query) use ($ayam) {
            $query->whereDoesntHave('ayam', function ($q) {
                $q->where('status', 'aktif');
            })->orWhere('id', $ayam->kandang_id);
        })->get();
        return view('ayam.edit', compact('ayam', 'kandang'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kandang_id' => 'required|exists:kandang,id',
            'jumlah_ayam' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date|before_or_equal:today',
            'keterangan' => 'nullable|string',
        ]);

        $kandang = \App\Models\Kandang::find($validated['kandang_id']);
        if ($kandang && $validated['jumlah_ayam'] > $kandang->jumlah_ayam) {
            return back()->withInput()->withErrors(['jumlah_ayam' => 'Jumlah ayam tidak boleh melebihi kapasitas kandang (' . $kandang->jumlah_ayam . ').']);
        }

        $ayam = Ayam::findOrFail($id);
        $validated['nama_ayam'] = 'Ayam Petelur';
        $ayam->update($validated);

        return redirect()->route('ayam.index')->with('success', 'Data ayam berhasil diupdate.');
    }

    public function destroy($id)
    {
        $ayam = Ayam::findOrFail($id);
        $ayam->delete();
        return redirect()->route('ayam.index')->with('success', 'Data ayam berhasil dihapus.');
    }

    public function keluar($id)
    {
        $ayam = Ayam::findOrFail($id);
        $ayam->update([
            'status' => 'keluar',
            'tanggal_keluar' => now()
        ]);
        return redirect()->route('ayam.index')->with('success', 'Ayam berhasil dikeluarkan/afkir.');
    }
}
