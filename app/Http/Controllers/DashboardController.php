<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Kandang;
use App\Models\Ayam;
use App\Models\Produksi;

class DashboardController extends Controller
{
    public function index()
    {
        $pegawaiCount = Pegawai::count();
        $kandangCount = Kandang::count();
        // Jumlah ayam total dari tabel ayam
        $jumlahAyam = Ayam::sum('jumlah_ayam');

        // Produksi hari ini (semua kandang)
        $produksiHariIni = Produksi::whereDate('tanggal', now())
            ->whereIn('status', ['final', 'approved'])
            ->sum('jumlah');

        // Stok telur layak/tidak layak (pakai method Produksi)
        $stokLayak = Produksi::stokLayak();
        $stokTidakLayak = Produksi::stokTidakLayak();

        // Penjualan bulan ini (total rupiah)
        $penjualanBulanIni = \App\Models\Penjualan::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('total');

        // Data untuk chart produksi bulanan
        $bulanChartLabels = [];
        $bulanChartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanChartLabels[] = date('M', mktime(0,0,0,$i,1));
            $bulanChartData[] = Produksi::whereMonth('tanggal', $i)
                ->whereYear('tanggal', now()->year)
                ->whereIn('status', ['final', 'approved'])
                ->sum('jumlah');
        }
        // Info per kandang
        $kandangList = Kandang::all()->map(function($kandang) {
            // Jumlah ayam diambil dari tabel ayam (sum jumlah_ayam per kandang)
            $jumlahAyam = \App\Models\Ayam::where('kandang_id', $kandang->id)->sum('jumlah_ayam');
            // Umur ayam tertua (dalam format tahun/bulan/minggu/hari)
            $ayamTertua = \App\Models\Ayam::where('kandang_id', $kandang->id)->orderBy('tanggal_masuk')->first();
            if ($ayamTertua) {
                $tanggal_masuk = \Carbon\Carbon::parse($ayamTertua->tanggal_masuk);
                $now = \Carbon\Carbon::now();
                $diff = $tanggal_masuk->diff($now);
                $umur = [];
                if ($diff->y) $umur[] = $diff->y . ' tahun';
                if ($diff->m) $umur[] = $diff->m . ' bulan';
                if ($diff->d >= 7) {
                    $minggu = intdiv($diff->d, 7);
                    $hari = $diff->d % 7;
                    if ($minggu) $umur[] = $minggu . ' minggu';
                    if ($hari) $umur[] = $hari . ' hari';
                } else if ($diff->d) {
                    $umur[] = $diff->d . ' hari';
                }
                $umurTertua = $umur ? implode(' ', $umur) : '0 hari';
            } else {
                $umurTertua = '-';
            }
            // Produksi hari ini
            $produksiHariIni = \App\Models\Produksi::where('id_kandang', $kandang->id)
                ->whereDate('tanggal', now())
                ->sum('jumlah');
            $kandang->jumlah_ayam = $jumlahAyam;
            $kandang->umur_tertua = $umurTertua;
            $kandang->produksi_hari_ini = $produksiHariIni;
            return $kandang;
        });
        return view('dashboard', compact(
            'pegawaiCount',
            'kandangCount',
            'jumlahAyam',
            'produksiHariIni',
            'stokLayak',
            'stokTidakLayak',
            'penjualanBulanIni',
            'kandangList',
            'bulanChartLabels',
            'bulanChartData',
        ));
    }
}
