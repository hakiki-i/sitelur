<div style="text-align:center; margin-bottom:20px;">
    <h2 style="margin:0; font-size:24px; letter-spacing:1px;">LAPORAN PRODUKSI TELUR</h2>
    <div style="font-size:14px; color:#666;">Peternakan Ayam Petelur</div>
    <hr style="margin:10px 0 20px 0; border:1px solid #ccc;">
</div>
<table border="1" cellpadding="4" cellspacing="0">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Kandang</th>
            <th>Jumlah Produksi (butir)</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{ $row->tanggal }}</td>
            <td>{{ $row->kandang->nama_kandang ?? '-' }}</td>
            <td>{{ $row->jumlah }}</td>
            <td>{{ ucfirst($row->status) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
