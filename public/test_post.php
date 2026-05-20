<?php
$url = "https://siskaperbapo.jatimprov.go.id/harga/tabel.nodesign/";
$data = http_build_query([
    'tanggal' => date('Y-m-d'),
    'kabkota' => 'kedirikab',
    'pasar' => ''
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
    'X-Requested-With: XMLHttpRequest',
    'Referer: https://siskaperbapo.jatimprov.go.id/harga/tabel',
    'User-Agent: Mozilla/5.0'
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$result = curl_exec($ch);
curl_close($ch);

// Regex for the row containing 'Telur Ayam Ras'
if (preg_match('/Telur Ayam Ras<\/span>.*?<td align="right" class="kemarin">(.*?)<\/td>.*?<td align="right" class="sekarang">(.*?)<\/td>/is', $result, $matches)) {
    echo "Kemarin: " . trim(strip_tags($matches[1])) . "\n";
    echo "Sekarang: " . trim(strip_tags($matches[2])) . "\n";
} else {
    echo "Not matched precisely. Let's try splitting.\n";
    $parts = explode('Telur Ayam Ras', $result);
    if(count($parts) > 1) {
        $sub = substr($parts[1], 0, 300);
        echo strip_tags($sub);
    }
}
