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
    <div class="header">
        <h2>Laporan Produksi Telur</h2>
        <p>SIM Ayam Petelur &bull; Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="15%">Kandang</th>
                <th class="text-right">T. Layak (Btr)</th>
                <th class="text-right">T. Tidak Layak (Btr)</th>
                <th class="text-right">Total (Btr)</th>
                <th class="text-center" width="12%">Status</th>
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
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $row->kandang->nama_kandang ?? '-' }}</td>
                <td class="text-right">{{ number_format($row->telur_layak, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($row->telur_tidak_layak, 0, ',', '.') }}</td>
                <td class="text-right font-bold">{{ number_format($row->jumlah, 0, ',', '.') }}</td>
                <td class="text-center">
                    @php
                        $color = in_array($row->status, ['final', 'approved']) ? 'bg-blue' : ($row->status == 'draft' ? 'bg-amber' : 'bg-red');
                    @endphp
                    <span class="status-badge {{ $color }}">{{ ucfirst($row->status) }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 20px; color: #94a3b8;">Tidak ada data produksi.</td>
            </tr>
            @endforelse
        </tbody>
        @if(count($data) > 0)
        <tfoot>
            <tr>
                <td colspan="3" class="text-right font-bold" style="background-color: #f1f5f9; padding: 10px;">TOTAL PRODUKSI:</td>
                <td class="text-right font-bold" style="background-color: #f1f5f9;">{{ number_format($sum_layak, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="background-color: #f1f5f9;">{{ number_format($sum_tidak_layak, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="background-color: #f1f5f9; color: #1d4ed8;">{{ number_format($sum_total, 0, ',', '.') }}</td>
                <td style="background-color: #f1f5f9;"></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer">
        Dicetak oleh Sistem Informasi Manajemen Ayam Petelur
    </div>
</body>
</html>
