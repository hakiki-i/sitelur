@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-center">
    <div id="nota" style="width:58mm;min-width:58mm;max-width:58mm;font-size:11px;padding:8px 0;">
        <div style="text-align:center;font-weight:bold;">TOKO TELUR MAKMUR</div>
        <div>Invoice: {{ $penjualan->id }}</div>
        <div>Tanggal: {{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d/m/Y H:i') }}</div>
        <div>Pembeli: {{ $penjualan->pembeli }}</div>
        <hr style="margin:4px 0;">
        <div>Telur {{ ucfirst($penjualan->jenis_telur ?? '-') }}</div>
        <div>{{ $penjualan->jumlah }} x {{ number_format($penjualan->harga_perkilo,0,',','.') }}</div>
        <hr style="margin:4px 0;">
        <div style="text-align:right;">TOTAL: Rp {{ number_format($penjualan->total,0,',','.') }}</div>
        <div>Pembayaran: CASH</div>
        <div style="text-align:center;margin-top:8px;">Terima kasih</div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/qz-tray/qz-tray.js"></script>
<script src="/js/thermal-print.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    printNotaQZ(@json($penjualan));
});
</script>
@endsection
