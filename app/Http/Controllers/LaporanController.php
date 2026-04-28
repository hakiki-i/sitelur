<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produksi;
use App\Models\Penjualan;

class LaporanController extends Controller
{
    public function export(Request $request, $type)
    {
        $filter = $request->get('filter_jenis', 'produksi');
        $tanggal = $request->get('tanggal');
        $perPage = $request->get('perPage', 25);
        if ($filter === 'penjualan') {
            $query = Penjualan::query();
            if ($tanggal) $query->whereDate('tanggal', $tanggal);
            $data = $query->orderBy('tanggal', 'desc')->get();
            $view = 'export.penjualan';
            $filename = 'laporan_penjualan_'.date('Ymd_His');
        } else {
            $query = Produksi::with('kandang');
            if ($tanggal) $query->whereDate('tanggal', $tanggal);
            $data = $query->orderBy('tanggal', 'desc')->get();
            $view = 'export.produksi';
            $filename = 'laporan_produksi_'.date('Ymd_His');
        }

        if ($type === 'excel') {
            // Export Excel (pakai Laravel Excel)
            return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\LaporanExport($data, $view), $filename.'.xlsx');
        } elseif ($type === 'pdf') {
            // Export PDF (pakai DomPDF)
            $pdf = \PDF::loadView($view, ['data' => $data]);
            return $pdf->download($filename.'.pdf');
        }
        abort(404);
    }

    public function index(Request $request)
    {
        $filter = $request->get('filter_jenis', 'produksi');
        $tanggal = $request->get('tanggal');
        $perPage = $request->get('perPage', 25);
        if ($filter === 'penjualan') {
            $query = Penjualan::query();
            if ($tanggal) $query->whereDate('tanggal', $tanggal);
            $data = $query->orderBy('tanggal', 'desc')->paginate($perPage)->withQueryString();
        } else {
            $query = Produksi::with('kandang');
            if ($tanggal) $query->whereDate('tanggal', $tanggal);
            $data = $query->orderBy('tanggal', 'desc')->paginate($perPage)->withQueryString();
        }
        return view('laporan', [
            'filter' => $filter,
            'data' => $data,
        ]);
    }
}
