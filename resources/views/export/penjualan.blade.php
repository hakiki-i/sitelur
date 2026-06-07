<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan Telur</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #333; }
        table { width: 100%; border-collapse: collapse; }
        th { font-size: 11px; text-transform: uppercase; }
        td { font-size: 12px; }
        .footer { margin-top: 30px; text-align: right; font-size: 11px; color: #64748b; }
    </style>
</head>
<body>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <!-- Centered Header Title across all columns -->
            <tr>
                <th colspan="8" style="text-align: center; color: #1e3a8a; font-size: 18px; font-weight: bold; padding: 10px 0; border: none;">
                    LAPORAN PENJUALAN TELUR
                </th>
            </tr>
            <tr>
                <th colspan="8" style="text-align: center; color: #64748b; font-size: 11px; font-weight: normal; padding-bottom: 20px; border: none;">
                    SIM Ayam Petelur &bull; Tanggal Cetak: {{ date('d/m/Y H:i') }}
                </th>
            </tr>
            <!-- Actual Table Headers -->
            <tr style="background-color: #2563eb; color: #ffffff;">
                <th style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: center; vertical-align: middle;">No</th>
                <th style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: center; vertical-align: middle;">Tanggal</th>
                <th style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: center; vertical-align: middle;">Nama Pembeli</th>
                <th style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: center; vertical-align: middle;">Tipe</th>
                <th style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: center; vertical-align: middle;">Jenis Telur</th>
                <th style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: right; vertical-align: middle;">Jumlah (kg)</th>
                <th style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: right; vertical-align: middle;">Harga/kg</th>
                <th style="background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 10px; border: 1px solid #1e40af; font-size: 11px; text-transform: uppercase; text-align: right; vertical-align: middle;">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $sum_jumlah = 0; 
                $sum_total = 0; 
            @endphp
            @forelse($data as $index => $row)
            @php
                $sum_jumlah += $row->jumlah + ($row->jumlah_b ?? 0);
                $rowTotal = $row->total + ($row->total_b ?? 0);
                $sum_total += $rowTotal;
                $rowBg = $index % 2 == 0 ? '#ffffff' : '#f8fafc';
            @endphp
            <tr style="background-color: {{ $rowBg }};">
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: center; vertical-align: middle;">{{ $index + 1 }}</td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: center; vertical-align: middle;">{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: center; vertical-align: middle; font-weight: bold;">{{ $row->pembeli }}</td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: center; vertical-align: middle;">{{ $row->jenis_pembeli }}</td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: center; vertical-align: middle;">
                    @if($row->jenis_telur === 'keduanya')
                        Grade A + B
                    @else
                        {{ $row->jenis_telur == 'layak' ? 'Grade A' : 'Grade B' }}
                    @endif
                </td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: right; vertical-align: middle;">
                    @if($row->jenis_telur === 'keduanya')
                        A: {{ number_format($row->jumlah, 2, ',', '.') }} kg<br>B: {{ number_format($row->jumlah_b, 2, ',', '.') }} kg
                    @else
                        {{ number_format($row->jumlah, 2, ',', '.') }}
                    @endif
                </td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: right; vertical-align: middle;">
                    @if($row->jenis_telur === 'keduanya')
                        A: Rp {{ number_format($row->harga_perkilo, 0, ',', '.') }}<br>B: Rp {{ number_format($row->harga_perkilo_b, 0, ',', '.') }}
                    @else
                        {{ number_format($row->harga_perkilo, 0, ',', '.') }}
                    @endif
                </td>
                <td style="padding: 8px 10px; border: 1px solid #e2e8f0; font-size: 12px; text-align: right; font-weight: bold; color: #1d4ed8; vertical-align: middle;">
                    {{ number_format($rowTotal, 0, ',', '.') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="padding: 20px; color: #94a3b8; text-align: center; border: 1px solid #e2e8f0; vertical-align: middle;">Tidak ada data penjualan.</td>
            </tr>
            @endforelse
        </tbody>
        @if(count($data) > 0)
        <tfoot>
            <tr style="background-color: #f1f5f9;">
                <td colspan="5" style="background-color: #f1f5f9; padding: 10px; border: 1px solid #cbd5e1; text-align: right; font-weight: bold; vertical-align: middle;">TOTAL KESELURUHAN:</td>
                <td style="background-color: #f1f5f9; border: 1px solid #cbd5e1; text-align: right; font-weight: bold; vertical-align: middle;">{{ number_format($sum_jumlah, 2, ',', '.') }}</td>
                <td style="background-color: #f1f5f9; border: 1px solid #cbd5e1; vertical-align: middle;"></td>
                <td style="background-color: #f1f5f9; border: 1px solid #cbd5e1; text-align: right; font-weight: bold; color: #1d4ed8; font-size: 14px; vertical-align: middle;">{{ number_format($sum_total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer" style="margin-top: 30px; text-align: right; font-size: 11px; color: #64748b;">
        Dicetak oleh Sistem Informasi Manajemen Ayam Petelur
    </div>
</body>
</html>
