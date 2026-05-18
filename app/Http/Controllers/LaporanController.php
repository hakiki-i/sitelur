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
        $tanggal_mulai = $request->get('tanggal_mulai');
        $tanggal_selesai = $request->get('tanggal_selesai');
        $jenis_telur = $request->get('jenis_telur');
        $jenis_pembeli = $request->get('jenis_pembeli');
        $id_kandang = $request->get('id_kandang');
        $perPage = $request->get('perPage', 25);
        
        if ($filter === 'penjualan') {
            $query = Penjualan::query();
            if ($tanggal_mulai) $query->whereDate('tanggal', '>=', $tanggal_mulai);
            if ($tanggal_selesai) $query->whereDate('tanggal', '<=', $tanggal_selesai);
            if ($jenis_telur) $query->where('jenis_telur', $jenis_telur);
            if ($jenis_pembeli) $query->where('jenis_pembeli', $jenis_pembeli);
            $data = $query->orderBy('tanggal', 'desc')->get();
            $view = 'export.penjualan';
            $filename = 'laporan_penjualan_'.date('Ymd_His');
        } else {
            $query = Produksi::with('kandang');
            if ($tanggal_mulai) $query->whereDate('tanggal', '>=', $tanggal_mulai);
            if ($tanggal_selesai) $query->whereDate('tanggal', '<=', $tanggal_selesai);
            if ($id_kandang) $query->where('id_kandang', $id_kandang);
            $data = $query->orderBy('tanggal', 'desc')->get();
            $view = 'export.produksi';
            $filename = 'laporan_produksi_'.date('Ymd_His');
        }

        if ($type === 'excel') {
            return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\LaporanExport($data, $view), $filename.'.xlsx');
        } elseif ($type === 'pdf') {
            $pdf = \PDF::loadView($view, ['data' => $data]);
            return $pdf->download($filename.'.pdf');
        }
        abort(404);
    }

    public function index(Request $request)
    {
        $filter = $request->get('filter_jenis', 'produksi');
        $tanggal_mulai = $request->get('tanggal_mulai');
        $tanggal_selesai = $request->get('tanggal_selesai');
        $jenis_telur = $request->get('jenis_telur');
        $jenis_pembeli = $request->get('jenis_pembeli');
        $id_kandang = $request->get('id_kandang');
        $perPage = $request->get('perPage', 25);
        
        $kandangs = \App\Models\Kandang::orderBy('nama_kandang')->get();
        
        if ($filter === 'penjualan') {
            $query = Penjualan::query();
            if ($tanggal_mulai) $query->whereDate('tanggal', '>=', $tanggal_mulai);
            if ($tanggal_selesai) $query->whereDate('tanggal', '<=', $tanggal_selesai);
            if ($jenis_telur) $query->where('jenis_telur', $jenis_telur);
            if ($jenis_pembeli) $query->where('jenis_pembeli', $jenis_pembeli);
            $data = $query->orderBy('tanggal', 'desc')->paginate($perPage)->withQueryString();
        } else {
            $query = Produksi::with('kandang');
            if ($tanggal_mulai) $query->whereDate('tanggal', '>=', $tanggal_mulai);
            if ($tanggal_selesai) $query->whereDate('tanggal', '<=', $tanggal_selesai);
            if ($id_kandang) $query->where('id_kandang', $id_kandang);
            $data = $query->orderBy('tanggal', 'desc')->paginate($perPage)->withQueryString();
        }
        
        return view('laporan', [
            'filter' => $filter,
            'data' => $data,
            'kandangs' => $kandangs,
        ]);
    }
}
