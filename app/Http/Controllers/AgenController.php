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

        // Ambil nama-nama agen yang sudah ada untuk dieksklusi
        $existingAgentNames = Agen::pluck('nama_agen')->toArray();

        // Query dasar untuk pembeli umum (Lainnya) dalam 30 hari terakhir
        $queryBase = \App\Models\Penjualan::where('jenis_pembeli', 'Lainnya')
            ->where('tanggal', '>=', now()->subDays(30)->toDateString());

        if (!empty($existingAgentNames)) {
            $queryBase->whereNotIn('pembeli', $existingAgentNames);
        }

        // 1. Calon Agen yang memenuhi syarat (>= 15 transaksi, masing-masing >= 10 kg)
        $calonAgens = (clone $queryBase)
            ->whereRaw('(jumlah + COALESCE(jumlah_b, 0)) >= 10')
            ->groupBy('pembeli')
            ->select('pembeli', \DB::raw('COUNT(*) as total_transaksi'))
            ->havingRaw('COUNT(*) >= 15')
            ->get();

        // 2. Daftar pembeli umum lainnya untuk monitoring / diagnosis
        $monitorPembelis = (clone $queryBase)
            ->groupBy('pembeli')
            ->select('pembeli', \DB::raw('COUNT(*) as total_transaksi'))
            ->get();

        // Tambahkan info transaksi layak (>= 10 kg) untuk masing-masing pembeli di monitor
        $monitorPembelis->transform(function ($item) use ($existingAgentNames) {
            $item->transaksi_layak = \App\Models\Penjualan::where('jenis_pembeli', 'Lainnya')
                ->where('pembeli', $item->pembeli)
                ->where('tanggal', '>=', now()->subDays(30)->toDateString())
                ->whereRaw('(jumlah + COALESCE(jumlah_b, 0)) >= 10')
                ->count();
            return $item;
        });
        
        return view('agen.index', compact('agens', 'calonAgens', 'monitorPembelis', 'perPage'));
    }

    public function promosikan(Request $request)
    {
        $request->validate([
            'nama_agen' => 'required|string|unique:agens,nama_agen',
            'nomor_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        // 1. Buat agen baru
        Agen::create([
            'nama_agen' => $request->nama_agen,
            'nomor_hp' => $request->nomor_hp,
            'alamat' => $request->alamat,
        ]);

        // 2. Update histori transaksi penjualan untuk pembeli ini dari 'Lainnya' menjadi 'Agen'
        \App\Models\Penjualan::where('jenis_pembeli', 'Lainnya')
            ->where('pembeli', $request->nama_agen)
            ->update(['jenis_pembeli' => 'Agen']);

        return redirect()->route('agen.index')->with('success', 'Pembeli ' . $request->nama_agen . ' berhasil dipromosikan menjadi Agen dan riwayat transaksi telah diperbarui.');
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
