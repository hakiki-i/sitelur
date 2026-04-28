
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-success text-white">Tambah Kandang</div>
                <div class="card-body">
                    <a href="{{ route('kandang.index') }}" class="btn btn-secondary mb-3">Kembali</a>
                    <form action="{{ route('kandang.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_kandang" class="form-label">Nama Kandang</label>
                            <input type="text" name="nama_kandang" id="nama_kandang" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_ayam" class="form-label">Jumlah Ayam</label>
                            <input type="number" name="jumlah_ayam" id="jumlah_ayam" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
