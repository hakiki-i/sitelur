@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <span>Data Penjualan</span>
                    <a href="{{ route('penjualan.create') }}" class="btn btn-primary">Tambah Penjualan</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Pembeli</th>
                                <th>Jenis Pembeli</th>
                                <th>Jumlah</th>
                                <th>Harga per Kilo</th>
                                <th>Total</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualan as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->tanggal }}</td>
                                <td>{{ $p->pembeli }}</td>
                                <td>{{ $p->jenis_pembeli }}</td>
                                <td>{{ $p->jumlah }}</td>
                                <td>Rp {{ number_format($p->harga_perkilo,0,',','.') }}</td>
                                <td>Rp {{ number_format($p->total,0,',','.') }}</td>
                                <td>{{ $p->keterangan }}</td>
                                <td>
                                    <a href="{{ route('penjualan.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('penjualan.destroy', $p->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination & PerPage -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div></div>
                        <div class="d-flex align-items-center gap-2">
                            <form method="get" class="mb-0">
                            <label for="perPage" class="me-1 mb-0">Tampil</label>
                                <select name="perPage" class="form-select form-select-sm" style="font-size: 0.85rem; display: inline-block; width: auto;" onchange="this.form.submit()">
                                    <option value="10" {{ request('perPage', $perPage ?? 25) == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('perPage', $perPage ?? 25) == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('perPage', $perPage ?? 25) == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('perPage', $perPage ?? 25) == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <span class="ms-1" style="font-size:0.85rem">data</span>
                            </form>
                            <div>
                                {!! $penjualan->links('pagination::bootstrap-5') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
