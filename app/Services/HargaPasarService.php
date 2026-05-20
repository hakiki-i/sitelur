<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class HargaPasarService
{
    /**
     * Mendapatkan indeks harga telur rata-rata dengan Web Scraping dari Siskaperbapo Jatim
     */
    public function getIndeksJatim()
    {
        $secondsUntilMidnight = now()->diffInSeconds(Carbon::tomorrow());

        // Cache 1 hari
        return Cache::remember('indeks_harga_telur_jatim_real', $secondsUntilMidnight, function () {
            $wilayahList = [
                'kedirikab' => 'Kab. Kediri',
                'kedirikota' => 'Kota Kediri',
                'blitarkab' => 'Kab. Blitar'
            ];
            
            $hasilWilayah = [];
            $totalHarga = 0;
            $count = 0;

            foreach ($wilayahList as $kode => $nama) {
                $dataScraped = $this->scrapeSiskaperbapo($kode);
                
                if ($dataScraped) {
                    $hasilWilayah[] = [
                        'nama' => $nama,
                        'harga' => $dataScraped['sekarang'],
                        'status' => $dataScraped['status']
                    ];
                    $totalHarga += $dataScraped['sekarang'];
                    $count++;
                } else {
                    // Fallback jika gagal scrape
                    $hasilWilayah[] = [
                        'nama' => $nama,
                        'harga' => 0,
                        'status' => 'tetap'
                    ];
                }
            }
            
            $rata_rata = $count > 0 ? round($totalHarga / $count) : 0;
            
            // Status rata-rata bisa dihitung, tapi untuk UI kita set tetap saja
            $hasilWilayah[] = [
                'nama' => 'Rata-rata Jatim',
                'harga' => $rata_rata,
                'status' => 'tetap'
            ];

            return [
                'tanggal' => now()->format('Y-m-d'),
                'wilayah' => $hasilWilayah,
                'sumber' => 'Siskaperbapo Jatim (Real-time Scraping)'
            ];
        });
    }

    private function scrapeSiskaperbapo($kabkota)
    {
        try {
            $response = Http::asForm()->withHeaders([
                'X-Requested-With' => 'XMLHttpRequest',
                'Referer' => 'https://siskaperbapo.jatimprov.go.id/harga/tabel',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'
            ])->withoutVerifying()->post('https://siskaperbapo.jatimprov.go.id/harga/tabel.nodesign/', [
                'tanggal' => date('Y-m-d'),
                'kabkota' => $kabkota,
                'pasar' => ''
            ]);

            $html = $response->body();
            
            // Parsing HTML sederhana menggunakan Regex
            if (preg_match('/Telur Ayam Ras<\/span>.*?<td align="right" class="kemarin">(.*?)<\/td>.*?<td align="right" class="sekarang">(.*?)<\/td>/is', $html, $matches)) {
                
                $hargaKemarinStr = trim(strip_tags($matches[1]));
                $hargaSekarangStr = trim(strip_tags($matches[2]));
                
                // Menghilangkan titik (contoh 25.000 menjadi 25000)
                $kemarin = (int) str_replace('.', '', $hargaKemarinStr);
                $sekarang = (int) str_replace('.', '', $hargaSekarangStr);
                
                $status = 'tetap';
                if ($sekarang > $kemarin) $status = 'naik';
                if ($sekarang < $kemarin) $status = 'turun';
                if ($kemarin == 0) $status = 'tetap'; // Jika tidak ada data kemarin

                return [
                    'kemarin' => $kemarin,
                    'sekarang' => $sekarang,
                    'status' => $status
                ];
            }
            
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
