<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Http;

$kabkota = 'kedirikab';
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
echo "HTML Length: " . strlen($html) . "\n";

if (preg_match('/Telur Ayam Ras<\/span>.*?<td[^>]*class="kemarin"[^>]*>(.*?)<\/td>.*?<td[^>]*class="sekarang"[^>]*>(.*?)<\/td>/is', $html, $matches)) {
    echo "Found using regex 1!\n";
    var_dump($matches[1], $matches[2]);
} else if (preg_match('/Telur Ayam Ras.*?kemarin">(.*?)<\/td>.*?sekarang">(.*?)<\/td>/is', $html, $matches)) {
    echo "Found using regex 2!\n";
    var_dump($matches[1], $matches[2]);
} else {
    echo "Regex failed.\n";
    $parts = explode('Telur Ayam Ras', $html);
    if(count($parts) > 1) {
        echo "Found string 'Telur Ayam Ras'. Extract:\n";
        echo substr($parts[1], 0, 300);
    } else {
        echo "String 'Telur Ayam Ras' not found.\n";
    }
}
