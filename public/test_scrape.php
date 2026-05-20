<?php
$url = "https://siskaperbapo.jatimprov.go.id/harga/tabel";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$html = curl_exec($ch);
if(curl_errno($ch)){
    echo "Curl error: " . curl_error($ch);
}
curl_close($ch);

if (strlen($html) > 0) {
    echo "Length: " . strlen($html) . "\n";
    // Check if it contains 'Telur Ayam Ras'
    if (strpos($html, 'Telur Ayam Ras') !== false) {
        echo "Found 'Telur Ayam Ras'\n";
        
        // Let's try to extract something using regex or just print a snippet
        preg_match_all('/<tr.*?>(.*?)<\/tr>/is', $html, $matches);
        echo "Found " . count($matches[0]) . " rows.\n";
    } else {
        echo "Keyword not found.\n";
        echo substr($html, 0, 500);
    }
} else {
    echo "Empty response";
}
