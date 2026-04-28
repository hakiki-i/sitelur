@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <span>Data Ayam</span>
                    <a href="{{ route('ayam.create') }}" class="btn btn-primary">Tambah Ayam</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Jumlah Ayam</th>
                                <th>Tanggal Masuk</th>
                                <th>Umur</th>
                                <th>Kandang</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ayam as $a)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $a->jumlah_ayam }}</td>
                                <td>{{ $a->tanggal_masuk }}</td>
                                <td>
                                    @php
                                        $tanggal_masuk = \Carbon\Carbon::parse($a->tanggal_masuk);
                                        $now = \Carbon\Carbon::now();
                                        $diff = $tanggal_masuk->diff($now);
                                        $umur = [];
                                        if ($diff->y) $umur[] = $diff->y . ' tahun';
                                        if ($diff->m) $umur[] = $diff->m . ' bulan';
                                        if ($diff->d >= 7) {
                                            $minggu = intdiv($diff->d, 7);
                                            $hari = $diff->d % 7;
                                            if ($minggu) $umur[] = $minggu . ' minggu';
                                            if ($hari) $umur[] = $hari . ' hari';
                                        } else if ($diff->d) {
                                            $umur[] = $diff->d . ' hari';
                                        }
                                        echo $umur ? implode(' ', $umur) : '0 hari';
                                    @endphp
                                </td>
                                <td>{{ $a->kandang->nama_kandang ?? '-' }}</td>
                                <td>{{ $a->keterangan }}</td>
                                <td>
                                    <a href="{{ route('ayam.edit', $a->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('ayam.destroy', $a->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end align-items-center mt-2">
                        <form method="get" class="me-2" style="font-size: 0.85em;">
                         <label for="perPage" class="me-1 mb-0">Tampil</label>
                            <select name="perPage" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                                <option value="10" {{ request('perPage', $perPage??25)==10?'selected':'' }}>10</option>
                                <option value="25" {{ request('perPage', $perPage??25)==25?'selected':'' }}>25</option>
                                <option value="50" {{ request('perPage', $perPage??25)==50?'selected':'' }}>50</option>
                                <option value="100" {{ request('perPage', $perPage??25)==100?'selected':'' }}>100</option>
                            </select>
                            <span class="ms-1">data</span>
                        </form>
                        {!! $ayam->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
