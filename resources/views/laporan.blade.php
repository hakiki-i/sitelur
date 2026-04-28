@extends('layouts.app')

@section('content')
<h2 class="mb-4">Laporan / Riwayat</h2>
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-2">
            <form method="GET" action="" class="flex-grow-1">
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label for="filter_jenis" class="form-label">Tampilkan Riwayat</label>
                        <select name="filter_jenis" id="filter_jenis" class="form-control">
                            <option value="produksi" {{ request('filter_jenis') == 'produksi' ? 'selected' : '' }}>Produksi</option>
                            <option value="penjualan" {{ request('filter_jenis') == 'penjualan' ? 'selected' : '' }}>Penjualan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ request('tanggal') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
            <div class="d-flex gap-2 mt-2 mt-md-0 align-items-end">
                <form method="GET" action="{{ route('laporan.export', ['type' => 'excel']) }}" class="d-inline">
                    <input type="hidden" name="filter_jenis" value="{{ request('filter_jenis') }}">
                    <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                    <input type="hidden" name="perPage" value="{{ request('perPage', 25) }}">
                    <button type="submit" class="btn btn-success btn-sm px-3"><i class="fas fa-file-excel me-1"></i> Export Excel</button>
                </form>
                <form method="GET" action="{{ route('laporan.export', ['type' => 'pdf']) }}" class="d-inline">
                    <input type="hidden" name="filter_jenis" value="{{ request('filter_jenis') }}">
                    <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                    <input type="hidden" name="perPage" value="{{ request('perPage', 25) }}">
                    <button type="submit" class="btn btn-danger btn-sm px-3"><i class="fas fa-file-pdf me-1"></i> Export PDF</button>
                </form>
            </div>
        </div>
    </div>
</div>

@if($filter == 'produksi')
    <div class="card">
        <div class="card-header bg-success text-white">Riwayat Produksi</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Kandang</th>
                            <th>Jumlah Produksi (butir)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $row)
                        <tr>
                            <td>{{ $row->tanggal }}</td>
                            <td>{{ $row->kandang->nama_kandang ?? '-' }}</td>
                            <td>{{ $row->jumlah }}</td>
                            <td>{{ $row->status }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center">Tidak ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-header bg-info text-white">Riwayat Penjualan</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Pembeli</th>
                            <th>Jenis Telur</th>
                            <th>Jumlah (kg)</th>
                            <th>Harga per Kilo</th>
                            <th>Total</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $row)
                        <tr>
                            <td>{{ $row->tanggal }}</td>
                            <td>{{ $row->pembeli }}</td>
                            <td>{{ ucfirst($row->jenis_telur) }}</td>
                            <td>{{ $row->jumlah_kg }}</td>
                            <td>Rp {{ number_format($row->harga_perkilo,0,',','.') }}</td>
                            <td>Rp {{ number_format($row->total,0,',','.') }}</td>
                            <td>{{ $row->keterangan }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

<div class="d-flex justify-content-end align-items-center mt-2" style="font-size: 0.9rem;">
    <form method="GET" action="" class="me-2">
        <input type="hidden" name="filter_jenis" value="{{ request('filter_jenis') }}">
        <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
        <label for="perPage" class="me-1 mb-0">Tampil</label>
        <select name="perPage" id="perPage" class="form-select form-select-sm d-inline-block w-auto" style="font-size:0.9em;display:inline-block;min-width:60px;" onchange="this.form.submit()">
            <option value="10" {{ request('perPage', 25) == 10 ? 'selected' : '' }}>10</option>
            <option value="25" {{ request('perPage', 25) == 25 ? 'selected' : '' }}>25</option>
            <option value="50" {{ request('perPage', 25) == 50 ? 'selected' : '' }}>50</option>
            <option value="100" {{ request('perPage', 25) == 100 ? 'selected' : '' }}>100</option>
        </select>
        <span class="ms-1">data</span>
    </form>
    <div>
        {!! $data->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
</div>

@endsection
