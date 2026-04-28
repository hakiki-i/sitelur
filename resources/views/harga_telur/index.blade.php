@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm mt-4 mb-4">
                <div class="card-header bg-success text-white">Harga Telur Terbaru</div>
                <div class="card-body">
                    @if($latestHarga)
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="alert alert-primary">
                                    <b>Harga Layak:</b> Rp {{ number_format($latestHarga->harga_layak,0,',','.') }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-warning">
                                    <b>Harga Tidak Layak:</b> Rp {{ number_format($latestHarga->harga_tidak_layak,0,',','.') }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 text-muted">Berlaku Mulai: {{ $latestHarga->tanggal }}</div>
                    @else
                        <div class="alert alert-info">Belum ada data harga telur.</div>
                    @endif
                </div>
            </div>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">Input Harga Telur Baru</div>
                <div class="card-body">
                    <form action="{{ route('harga_telur.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                @error('tanggal')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="harga_layak" class="form-label">Harga Layak</label>
                                <input type="number" name="harga_layak" id="harga_layak" class="form-control" value="{{ old('harga_layak') }}">
                                @error('harga_layak')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="harga_tidak_layak" class="form-label">Harga Tidak Layak</label>
                                <input type="number" name="harga_tidak_layak" id="harga_tidak_layak" class="form-control" value="{{ old('harga_tidak_layak') }}">
                                @error('harga_tidak_layak')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan Harga</button>
                    </form>
                </div>
            </div>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">Riwayat Harga Telur</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Harga Layak</th>
                                    <th>Harga Tidak Layak</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($listHarga as $harga)
                                    <tr>
                                        <td>{{ $harga->tanggal }}</td>
                                        <td>Rp {{ number_format($harga->harga_layak,0,',','.') }}</td>
                                        <td>Rp {{ number_format($harga->harga_tidak_layak,0,',','.') }}</td>
                                        <td>
                                            <form action="{{ route('harga_telur.destroy', $harga->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center">Belum ada data harga telur.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
