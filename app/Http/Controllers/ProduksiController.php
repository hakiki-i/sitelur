<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produksi;
use Carbon\Carbon;

class ProduksiController extends Controller
{
    // ================= API =================

    public function reject($id)
    {
        $produksi = Produksi::findOrFail($id);
        $produksi->status = 'rejected';
        $produksi->save();
        return redirect()->route('produksi.index')
                         ->with('success', 'Data produksi berhasil ditolak.');
    }

    // API: GET /api/produksi
    public function apiIndex()
    {
        $listProduksi = Produksi::with('kandang')
                                ->orderBy('tanggal', 'desc')
                                ->get();

        return response()->json($listProduksi);
    }

    // API: POST /api/produksi
    public function apiStore(Request $request)
    {
        $request->validate([
            'kandang_id' => 'required|exists:kandang,id',
            'layak' => 'required|integer',
            'tidak_layak' => 'required|integer',
        ]);

        $total = $request->layak + $request->tidak_layak;

        $produksi = Produksi::create([
            'tanggal' => now(),
            'id_kandang' => $request->kandang_id,
            'jumlah' => $total,
            'telur_layak' => $request->layak,
            'telur_tidak_layak' => $request->tidak_layak,
            'status' => 'draft',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil disimpan',
            'data' => $produksi
        ]);
    }

    // API: POST /api/produksi/{id}/validasi
    public function apiValidasi($id)
    {
        $produksi = Produksi::findOrFail($id);
        $produksi->status = 'final';
        $produksi->save();

        return response()->json([
            'success' => true,
            'message' => 'Status produksi diubah ke final'
        ]);
    }

    // ================= WEB =================

    public function index()
    {
        // Statistik produksi

        $produksiHarian = Produksi::whereDate('tanggal', Carbon::today())
            ->where('status', 'final')
            ->sum('jumlah');

        $produksiMingguan = Produksi::whereBetween('tanggal', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->where('status', 'final')
            ->sum('jumlah');

        $produksiBulanan = Produksi::whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->where('status', 'final')
            ->sum('jumlah');

        // List data
        $perPage = request('perPage', 25);
        $listProduksi = Produksi::with('kandang')
                                ->orderBy('tanggal', 'desc')
                                ->paginate($perPage)
                                ->withQueryString();

        return view('produksi.index', compact(
            'produksiHarian',
            'produksiMingguan',
            'produksiBulanan',
            'listProduksi',
            'perPage'
        ));
    }

    public function validasi($id)
    {
        $produksi = Produksi::findOrFail($id);
        $produksi->status = 'final';
        $produksi->save();

        return redirect()->route('produksi.index')
                         ->with('success', 'Data produksi berhasil divalidasi.');
    }
}