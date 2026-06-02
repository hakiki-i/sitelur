<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Produksi Telur</title>
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
        .status-badge { padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase; }
        .bg-blue { background-color: #dbeafe; color: #1d4ed8; }
        .bg-amber { background-color: #fef3c7; color: #b45309; }
        .bg-red { background-color: #fee2e2; color: #b91c1c; }
        .footer { margin-top: 30px; text-align: right; font-size: 11px; color: #64748b; }
    </style>
</head>
<body>
    <div class="header" style="text-align: center; margin-bottom: 25px; border-bottom: 2px solid #2563eb; padding-bottom: 15px;">
        <h2 style="margin: 0; font-size: 22px; color: #1e3a8a; text-transform: uppercase; letter-spacing: 1px;">Laporan Produksi Telur</h2>
        <p style="margin: 5px 0 0 0; font-size: 13px; color: #64748b;">SIM Ayam Petelur &bull; Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <thead>
            <tr style="background-color: #2563eb; color: #ffffff;">
                <th width="5%" class="text-center" style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: center;">No</th>
                <th width="15%" style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: left;">Tanggal</th>
                <th width="15%" style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: left;">Kandang</th>
                <th class="text-right" style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: right;">T. Layak (Btr)</th>
                <th class="text-right" style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: right;">T. Tidak Layak (Btr)</th>
                <th class="text-right" style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: right;">Total (Btr)</th>
                <th class="text-center" width="12%" style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $sum_layak = 0; 
                $sum_tidak_layak = 0; 
                $sum_total = 0; 
            @endphp
            @forelse($data as $index => $row)
            @php
                $sum_layak += $row->telur_layak;
                $sum_tidak_layak += $row->telur_tidak_layak;
                $sum_total += $row->jumlah;
                $rowBg = $index % 2 == 0 ? '#ffffff' : '#f8fafc';
            @endphp
            <tr style="background-color: {{ $rowBg }};">
                <td class="text-center" style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: center;">{{ $index + 1 }}</td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px;">{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px;">{{ $row->kandang->nama_kandang ?? '-' }}</td>
                <td class="text-right" style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: right;">{{ number_format($row->telur_layak, 0, ',', '.') }}</td>
                <td class="text-right" style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: right;">{{ number_format($row->telur_tidak_layak, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: right; font-weight: bold;">{{ number_format($row->jumlah, 0, ',', '.') }}</td>
                <td class="text-center" style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: center;">
                    @php
                        $color = in_array($row->status, ['final', 'approved']) ? 'bg-blue' : ($row->status == 'draft' ? 'bg-amber' : 'bg-red');
                        $badgeBg = in_array($row->status, ['final', 'approved']) ? '#dbeafe' : ($row->status == 'draft' ? '#fef3c7' : '#fee2e2');
                        $badgeColor = in_array($row->status, ['final', 'approved']) ? '#1d4ed8' : ($row->status == 'draft' ? '#b45309' : '#b91c1c');
                    @endphp
                    <span class="status-badge {{ $color }}" style="background-color: {{ $badgeBg }}; color: {{ $badgeColor }}; padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase;">{{ ucfirst($row->status) }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 20px; color: #94a3b8; text-align: center; border: 1px solid #e2e8f0;">Tidak ada data produksi.</td>
            </tr>
            @endforelse
        </tbody>
        @if(count($data) > 0)
        <tfoot>
            <tr style="background-color: #f1f5f9;">
                <td colspan="3" class="text-right font-bold" style="background-color: #f1f5f9; padding: 10px; border: 1px solid #cbd5e1; text-align: right; font-weight: bold;">TOTAL PRODUKSI:</td>
                <td class="text-right font-bold" style="background-color: #f1f5f9; border: 1px solid #cbd5e1; text-align: right; font-weight: bold;">{{ number_format($sum_layak, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="background-color: #f1f5f9; border: 1px solid #cbd5e1; text-align: right; font-weight: bold;">{{ number_format($sum_tidak_layak, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="background-color: #f1f5f9; color: #1d4ed8; border: 1px solid #cbd5e1; text-align: right; font-weight: bold;">{{ number_format($sum_total, 0, ',', '.') }}</td>
                <td style="background-color: #f1f5f9; border: 1px solid #cbd5e1;"></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer" style="margin-top: 30px; text-align: right; font-size: 11px; color: #64748b;">
        Dicetak oleh Sistem Informasi Manajemen Ayam Petelur
    </div>
</body>
</html>
