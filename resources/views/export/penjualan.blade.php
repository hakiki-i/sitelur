<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan Telur</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #2563eb; padding-bottom: 15px; }
        .header h2 { margin: 0; font-size: 22px; color: #1e3a8a; text-transform: uppercase; letter-spacing: 1px; }
        .header p { margin: 5px 0 0 0; font-size: 13px; color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; text-align: left; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; }
        td { padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .footer { margin-top: 30px; text-align: right; font-size: 11px; color: #64748b; }
        .text-blue { color: #1d4ed8; }
    </style>
</head>
<body>
    <div class="header" style="text-align: center; margin-bottom: 25px; border-bottom: 2px solid #2563eb; padding-bottom: 15px;">
        <h2 style="margin: 0; font-size: 22px; color: #1e3a8a; text-transform: uppercase; letter-spacing: 1px;">Laporan Penjualan Telur</h2>
        <p style="margin: 5px 0 0 0; font-size: 13px; color: #64748b;">SIM Ayam Petelur &bull; Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <thead>
            <tr style="background-color: #2563eb; color: #ffffff;">
                <th width="5%" class="text-center" style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: center;">No</th>
                <th width="12%" style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: left;">Tanggal</th>
                <th width="20%" style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: left;">Nama Pembeli</th>
                <th width="10%" style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: left;">Tipe</th>
                <th width="10%" style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: left;">Jenis Telur</th>
                <th class="text-right" width="10%" style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: right;">Jumlah (kg)</th>
                <th class="text-right" width="15%" style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: right;">Harga/kg</th>
                <th class="text-right" width="18%" style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: right;">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $sum_jumlah = 0; 
                $sum_total = 0; 
            @endphp
            @forelse($data as $index => $row)
            @php
                $sum_jumlah += $row->jumlah;
                $sum_total += $row->total;
                $rowBg = $index % 2 == 0 ? '#ffffff' : '#f8fafc';
            @endphp
            <tr style="background-color: {{ $rowBg }};">
                <td class="text-center" style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: center;">{{ $index + 1 }}</td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px;">{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
                <td class="font-bold" style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; font-weight: bold;">{{ $row->pembeli }}</td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px;">{{ $row->jenis_pembeli }}</td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px;">{{ ucfirst(str_replace('_', ' ', $row->jenis_telur)) }}</td>
                <td class="text-right" style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: right;">{{ number_format($row->jumlah, 2, ',', '.') }}</td>
                <td class="text-right" style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: right;">{{ number_format($row->harga_perkilo, 0, ',', '.') }}</td>
                <td class="text-right font-bold text-blue" style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: right; font-weight: bold; color: #1d4ed8;">{{ number_format($row->total, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center" style="padding: 20px; color: #94a3b8; text-align: center; border: 1px solid #e2e8f0;">Tidak ada data penjualan.</td>
            </tr>
            @endforelse
        </tbody>
        @if(count($data) > 0)
        <tfoot>
            <tr style="background-color: #f1f5f9;">
                <td colspan="5" class="text-right font-bold" style="background-color: #f1f5f9; padding: 10px; border: 1px solid #cbd5e1; text-align: right; font-weight: bold;">TOTAL KESELURUHAN:</td>
                <td class="text-right font-bold" style="background-color: #f1f5f9; border: 1px solid #cbd5e1; text-align: right; font-weight: bold;">{{ number_format($sum_jumlah, 2, ',', '.') }}</td>
                <td style="background-color: #f1f5f9; border: 1px solid #cbd5e1;"></td>
                <td class="text-right font-bold text-blue" style="background-color: #f1f5f9; border: 1px solid #cbd5e1; text-align: right; font-weight: bold; color: #1d4ed8; font-size: 14px;">{{ number_format($sum_total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer" style="margin-top: 30px; text-align: right; font-size: 11px; color: #64748b;">
        Dicetak oleh Sistem Informasi Manajemen Ayam Petelur
    </div>
</body>
</html>
