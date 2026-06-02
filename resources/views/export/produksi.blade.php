<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Produksi Telur</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #333; }
        table { width: 100%; border-collapse: collapse; }
        th { font-size: 11px; text-transform: uppercase; }
        td { font-size: 12px; }
        .status-badge { padding: 3px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; text-transform: uppercase; }
        .bg-blue { background-color: #dbeafe; color: #1d4ed8; }
        .bg-amber { background-color: #fef3c7; color: #b45309; }
        .bg-red { background-color: #fee2e2; color: #b91c1c; }
        .footer { margin-top: 30px; text-align: right; font-size: 11px; color: #64748b; }
    </style>
</head>
<body>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <!-- Centered Header Title across all columns -->
            <tr>
                <th colspan="7" style="text-align: center; color: #1e3a8a; font-size: 18px; font-weight: bold; padding: 10px 0; border: none;">
                    LAPORAN PRODUKSI TELUR
                </th>
            </tr>
            <tr>
                <th colspan="7" style="text-align: center; color: #64748b; font-size: 11px; font-weight: normal; padding-bottom: 20px; border: none;">
                    SIM Ayam Petelur &bull; Tanggal Cetak: {{ date('d/m/Y H:i') }}
                </th>
            </tr>
            <!-- Actual Table Headers -->
            <tr style="background-color: #2563eb; color: #ffffff;">
                <th style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: center; vertical-align: middle;">No</th>
                <th style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: center; vertical-align: middle;">Tanggal</th>
                <th style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: center; vertical-align: middle;">Kandang</th>
                <th style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: right; vertical-align: middle;">T. Layak (Btr)</th>
                <th style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: right; vertical-align: middle;">T. Tidak Layak (Btr)</th>
                <th style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: right; vertical-align: middle;">Total (Btr)</th>
                <th style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: center; vertical-align: middle;">Status</th>
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
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: center; vertical-align: middle;">{{ $index + 1 }}</td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: center; vertical-align: middle;">{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: center; vertical-align: middle;">{{ $row->kandang->nama_kandang ?? '-' }}</td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: right; vertical-align: middle;">{{ number_format($row->telur_layak, 0, ',', '.') }}</td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: right; vertical-align: middle;">{{ number_format($row->telur_tidak_layak, 0, ',', '.') }}</td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: right; font-weight: bold; vertical-align: middle;">{{ number_format($row->jumlah, 0, ',', '.') }}</td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: center; vertical-align: middle;">
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
                <td colspan="7" style="padding: 20px; color: #94a3b8; text-align: center; border: 1px solid #e2e8f0; vertical-align: middle;">Tidak ada data produksi.</td>
            </tr>
            @endforelse
        </tbody>
        @if(count($data) > 0)
        <tfoot>
            <tr style="background-color: #f1f5f9;">
                <td colspan="3" style="background-color: #f1f5f9; padding: 10px; border: 1px solid #cbd5e1; text-align: right; font-weight: bold; vertical-align: middle;">TOTAL PRODUKSI:</td>
                <td style="background-color: #f1f5f9; border: 1px solid #cbd5e1; text-align: right; font-weight: bold; vertical-align: middle;">{{ number_format($sum_layak, 0, ',', '.') }}</td>
                <td style="background-color: #f1f5f9; border: 1px solid #cbd5e1; text-align: right; font-weight: bold; vertical-align: middle;">{{ number_format($sum_tidak_layak, 0, ',', '.') }}</td>
                <td style="background-color: #f1f5f9; color: #1d4ed8; border: 1px solid #cbd5e1; text-align: right; font-weight: bold; vertical-align: middle;">{{ number_format($sum_total, 0, ',', '.') }}</td>
                <td style="background-color: #f1f5f9; border: 1px solid #cbd5e1; vertical-align: middle;"></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer" style="margin-top: 30px; text-align: right; font-size: 11px; color: #64748b;">
        Dicetak oleh Sistem Informasi Manajemen Ayam Petelur
    </div>
</body>
</html>
