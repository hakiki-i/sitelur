
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <span>Data Pegawai</span>
                    <a href="{{ route('pegawai.create') }}" class="btn btn-primary">Tambah Pegawai</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Pegawai</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pegawai as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->no_hp }}</td>
                                <td>{{ $p->alamat }}</td>
                                <td>
                                    <a href="{{ route('pegawai.edit', $p->id_pegawai ?? $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('pegawai.destroy', $p->id_pegawai ?? $p->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
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
                        {!! $pegawai->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
