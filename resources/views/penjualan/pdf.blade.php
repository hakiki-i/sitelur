<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Penjualan #{{ $penjualan->id }}</title>
    <style>
        @page { margin: 8px; }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            line-height: 1.3;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .text-center { text-align: center; }
        .text-right  { text-align: right; }
        .bold        { font-weight: bold; }
        .title       { font-size: 14px; font-weight: bold; margin-bottom: 2px; }
        .subtitle    { font-size: 9px; margin-bottom: 5px; }
        .divider     { border-top: 1px dashed #000; margin: 6px 0; }
        .double-divider {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            height: 3px;
            margin: 6px 0;
        }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 2px 0; vertical-align: top; }
        .total-section td { font-weight: bold; }
        .grade-label {
            font-size: 9px;
            font-weight: bold;
            background: #eee;
            padding: 0 3px;
        }
    </style>
</head>
<body>

    <div class="text-center">
        <div class="title">SITELUR POS</div>
        <div class="subtitle">Peternakan Ayam Petelur</div>
        <div class="double-divider"></div>
    </div>

    <table>
        <tr>
            <td width="30%">Waktu</td>
            <td>: {{ \Carbon\Carbon::parse($penjualan->tanggal)->translatedFormat('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Pembeli</td>
            <td>: {{ $penjualan->pembeli }}</td>
        </tr>
        <tr>
            <td>Tipe</td>
            <td>: {{ $penjualan->jenis_pembeli }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    @php
        $grandTotal = $penjualan->total + ($penjualan->total_b ?? 0);
    @endphp

    @if($penjualan->jenis_telur === 'keduanya')
        {{-- Tampilkan 2 baris: Grade A dan Grade B --}}
        <table>
            <tr>
                <td colspan="2"><span class="grade-label">Grade A</span> Telur Ayam ({{ $penjualan->jumlah }} kg)</td>
            </tr>
            <tr>
                <td>{{ $penjualan->jumlah }} x Rp {{ number_format($penjualan->harga_perkilo, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <table>
            <tr>
                <td colspan="2"><span class="grade-label">Grade B</span> Telur Ayam ({{ $penjualan->jumlah_b }} kg)</td>
            </tr>
            <tr>
                <td>{{ $penjualan->jumlah_b }} x Rp {{ number_format($penjualan->harga_perkilo_b, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($penjualan->total_b, 0, ',', '.') }}</td>
            </tr>
        </table>
    @else
        {{-- Satu jenis telur saja --}}
        <table>
            <tr>
                <td colspan="2">
                    <span class="grade-label">{{ $penjualan->jenis_telur === 'layak' ? 'Grade A' : 'Grade B' }}</span>
                    Telur Ayam ({{ $penjualan->jumlah }} kg)
                </td>
            </tr>
            <tr>
                <td>{{ $penjualan->jumlah }} x Rp {{ number_format($penjualan->harga_perkilo, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
            </tr>
        </table>
    @endif

    <div class="divider"></div>

    <table class="total-section">
        <tr>
            <td>TOTAL</td>
            <td class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        <tr>
            <td>Status</td>
            <td class="text-right bold">{{ strtoupper($penjualan->status_pembayaran) }}</td>
        </tr>
        @if($penjualan->status_pembayaran == 'kasbon')
        <tr>
            <td>Dibayar</td>
            <td class="text-right">Rp {{ number_format($penjualan->dibayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kekurangan</td>
            <td class="text-right bold">Rp {{ number_format($penjualan->kekurangan, 0, ',', '.') }}</td>
        </tr>
        @endif
    </table>

    <div class="double-divider"></div>

    <div class="text-center" style="margin-top: 15px; font-size: 10px;">
        Terima Kasih
    </div>

</body>
</html>
