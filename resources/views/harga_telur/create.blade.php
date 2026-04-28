@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-primary text-white">Tambah Harga Telur</div>
                <div class="card-body">
                    <form action="{{ route('harga_telur.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                            @error('tanggal')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="harga_layak" class="form-label">Harga Telur Layak</label>
                            <input type="number" name="harga_layak" id="harga_layak" class="form-control" value="{{ old('harga_layak') }}" required>
                            @error('harga_layak')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="harga_tidak_layak" class="form-label">Harga Telur Tidak Layak</label>
                            <input type="number" name="harga_tidak_layak" id="harga_tidak_layak" class="form-control" value="{{ old('harga_tidak_layak') }}" required>
                            @error('harga_tidak_layak')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('harga_telur.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
