<div style="text-align:center; margin-bottom:20px;">
    <h2 style="margin:0; font-size:24px; letter-spacing:1px;">LAPORAN PENJUALAN TELUR</h2>
    <div style="font-size:14px; color:#666;">Peternakan Ayam Petelur</div>
    <hr style="margin:10px 0 20px 0; border:1px solid #ccc;">
</div>
<table border="1" cellpadding="4" cellspacing="0">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Pembeli</th>
            <th>Jenis Pembeli</th>
            <th>Jenis Telur</th>
            <th>Jumlah (kg)</th>
            <th>Harga per Kilo</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{ $row->tanggal }}</td>
            <td>{{ $row->pembeli }}</td>
            <td>{{ $row->jenis_pembeli }}</td>
            <td>{{ $row->jenis_telur }}</td>
            <td>{{ $row->jumlah }}</td>
            <td>{{ number_format($row->harga_perkilo,0,',','.') }}</td>
            <td>{{ number_format($row->total,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
