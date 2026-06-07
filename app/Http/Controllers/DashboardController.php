<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Kandang;
use App\Models\Ayam;
use App\Models\Produksi;

class DashboardController extends Controller
{
    public function apiIndex(Request $request)
    {
        // Ambil data produksi 7 hari terakhir
        $produksi_mingguan = [];
        for ($i = 6; $i >= 0; $i--) {
            $produksi_mingguan[] = \App\Models\Produksi::whereDate('tanggal', now()->subDays($i))
                ->whereIn('status', ['final', 'approved'])
                ->sum('jumlah');
        }

        return response()->json([
            'layak' => Produksi::stokLayak(),
            'tidak_layak' => Produksi::stokTidakLayak(),
            'jumlah_kandang' => Kandang::count(),
            'produksi_mingguan' => $produksi_mingguan
        ]);
    }

    public function apiOwnerDashboard(Request $request)
    {
        // ── 1. Stok Telur Saat Ini ─────────────────────────────────────
        $stokLayak       = Produksi::stokLayak();
        $stokTidakLayak  = Produksi::stokTidakLayak();

        // ── 2. Total Penjualan Bulan Ini (Rupiah) ─────────────────────
        $penjualanBulanIni = \App\Models\Penjualan::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('total') + \App\Models\Penjualan::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('total_b');

        // ── 3. Total Penjualan Tahun Ini (Rupiah) ─────────────────────
        $penjualanTahunIni = \App\Models\Penjualan::whereYear('tanggal', now()->year)
            ->sum('total') + \App\Models\Penjualan::whereYear('tanggal', now()->year)
            ->sum('total_b');

        // ── 4. Grafik Produksi Bulanan (12 bulan tahun ini) ───────────
        $bulanLabels = [];
        $produksiBulanan = [];
        $layakBulanan    = [];
        $tidakLayakBulanan = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanLabels[]       = date('M', mktime(0, 0, 0, $i, 1));
            $produksiBulanan[]   = (int) Produksi::whereMonth('tanggal', $i)
                ->whereYear('tanggal', now()->year)
                ->whereIn('status', ['final', 'approved'])
                ->sum('jumlah');
            $layakBulanan[]      = (int) Produksi::whereMonth('tanggal', $i)
                ->whereYear('tanggal', now()->year)
                ->whereIn('status', ['final', 'approved'])
                ->sum('telur_layak');
            $tidakLayakBulanan[] = (int) Produksi::whereMonth('tanggal', $i)
                ->whereYear('tanggal', now()->year)
                ->whereIn('status', ['final', 'approved'])
                ->sum('telur_tidak_layak');
        }

        // ── 5. Grafik Penjualan Bulanan (rupiah, 12 bulan) ────────────
        $penjualanBulanan = [];
        for ($i = 1; $i <= 12; $i++) {
            $penjualanBulanan[] = (int) (\App\Models\Penjualan::whereMonth('tanggal', $i)
                ->whereYear('tanggal', now()->year)
                ->sum('total') + \App\Models\Penjualan::whereMonth('tanggal', $i)
                ->whereYear('tanggal', now()->year)
                ->sum('total_b'));
        }

        // ── 6. Detail Per Kandang ─────────────────────────────────────
        $detailKandang = Kandang::all()->map(function ($kandang) {
            $jumlahAyam = Ayam::where('kandang_id', $kandang->id)
                ->where('status', 'aktif')
                ->sum('jumlah_ayam');

            // Produksi hari ini untuk kandang ini
            $produksiHariIni = Produksi::where('id_kandang', $kandang->id)
                ->whereDate('tanggal', now())
                ->whereIn('status', ['final', 'approved'])
                ->sum('jumlah');

            $layakHariIni = Produksi::where('id_kandang', $kandang->id)
                ->whereDate('tanggal', now())
                ->whereIn('status', ['final', 'approved'])
                ->sum('telur_layak');

            $tidakLayakHariIni = Produksi::where('id_kandang', $kandang->id)
                ->whereDate('tanggal', now())
                ->whereIn('status', ['final', 'approved'])
                ->sum('telur_tidak_layak');

            // Total produksi bulan ini untuk kandang ini
            $produksiBulanIni = Produksi::where('id_kandang', $kandang->id)
                ->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->whereIn('status', ['final', 'approved'])
                ->sum('jumlah');

            // Produksi 7 hari terakhir (untuk mini bar chart per kandang)
            $produksiMingguanKandang = [];
            $labelMingguanKandang    = [];
            for ($i = 6; $i >= 0; $i--) {
                $tgl = now()->subDays($i);
                $produksiMingguanKandang[] = (int) Produksi::where('id_kandang', $kandang->id)
                    ->whereDate('tanggal', $tgl)
                    ->whereIn('status', ['final', 'approved'])
                    ->sum('jumlah');
                $labelMingguanKandang[] = $tgl->format('d/m');
            }

            // Umur ayam tertua
            $ayamTertua = Ayam::where('kandang_id', $kandang->id)
                ->where('status', 'aktif')
                ->orderBy('tanggal_masuk')->first();
            if ($ayamTertua) {
                $totalDays  = \Carbon\Carbon::parse($ayamTertua->tanggal_masuk)->diffInDays(now()) + 140;
                $umurTertua = floor($totalDays / 7) . ' minggu';
                if ($totalDays % 7 > 0) $umurTertua .= ' ' . ($totalDays % 7) . ' hari';
            } else {
                $umurTertua = '-';
            }

            // Rasio layak hari ini
            $rasioLayak = $produksiHariIni > 0
                ? round(($layakHariIni / $produksiHariIni) * 100)
                : 0;

            return [
                'id'                        => $kandang->id,
                'nama'                      => $kandang->nama_kandang,
                'kapasitas'                 => (int) $kandang->jumlah_ayam,
                'jumlah_ayam'               => (int) $jumlahAyam,
                'produksi_hari_ini'         => (int) $produksiHariIni,
                'telur_layak_hari_ini'      => (int) $layakHariIni,
                'telur_tidak_layak_hari_ini'=> (int) $tidakLayakHariIni,
                'produksi_bulan_ini'        => (int) $produksiBulanIni,
                'produksi_mingguan'         => $produksiMingguanKandang,
                'label_mingguan'            => $labelMingguanKandang,
                'umur_tertua'               => $umurTertua,
                'rasio_layak_persen'        => $rasioLayak,
            ];
        });

        // ── 7. Total ayam aktif ───────────────────────────────────────
        $totalAyam = Ayam::where('status', 'aktif')->sum('jumlah_ayam');

        return response()->json([
            'stok_layak'            => (int) $stokLayak,
            'stok_tidak_layak'      => (int) $stokTidakLayak,
            'penjualan_bulan_ini'   => (int) $penjualanBulanIni,
            'penjualan_tahun_ini'   => (int) $penjualanTahunIni,
            'total_ayam'            => (int) $totalAyam,
            'jumlah_kandang'        => Kandang::count(),
            'bulan_labels'          => $bulanLabels,
            'produksi_bulanan'      => $produksiBulanan,
            'layak_bulanan'         => $layakBulanan,
            'tidak_layak_bulanan'   => $tidakLayakBulanan,
            'penjualan_bulanan'     => $penjualanBulanan,
            'detail_kandang'        => $detailKandang,
            'butir_per_kg'          => \App\Models\Pengaturan::butirPerKg(),
        ]);
    }
    public function index()
    {
        $pegawaiCount = Pegawai::count();
        $kandangCount = Kandang::count();
        // Jumlah ayam total dari tabel ayam
        $jumlahAyam = Ayam::where('status', 'aktif')->sum('jumlah_ayam');

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
            ->sum('total') + \App\Models\Penjualan::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('total_b');

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
            $jumlahAyam = \App\Models\Ayam::where('kandang_id', $kandang->id)->where('status', 'aktif')->sum('jumlah_ayam');
            // Umur ayam tertua (dalam format tahun/bulan/minggu/hari)
            $ayamTertua = \App\Models\Ayam::where('kandang_id', $kandang->id)->where('status', 'aktif')->orderBy('tanggal_masuk')->first();
            if ($ayamTertua) {
                $tanggal_masuk = \Carbon\Carbon::parse($ayamTertua->tanggal_masuk);
                $totalDays = $tanggal_masuk->diffInDays(now());
                // Tambahkan base umur 20 minggu (140 hari) saat masuk
                $totalDays += 140;

                $minggu = floor($totalDays / 7);
                $hari = $totalDays % 7;

                $umurTertua = $minggu . ' minggu';
                if ($hari > 0) {
                    $umurTertua .= ' ' . $hari . ' hari';
                }
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
