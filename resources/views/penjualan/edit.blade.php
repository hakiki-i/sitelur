@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-success text-white">Edit Penjualan</div>
                <div class="card-body">
                    <a href="{{ route('penjualan.index') }}" class="btn btn-secondary mb-3">Kembali</a>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $penjualan->tanggal) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="pembeli" class="form-label">Pembeli</label>
                            <input type="text" name="pembeli" id="pembeli" class="form-control" value="{{ old('pembeli', $penjualan->pembeli) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_pembeli" class="form-label">Jenis Pembeli</label>
                            <select name="jenis_pembeli" id="jenis_pembeli" class="form-control">
                                <option value="">Pilih Jenis</option>
                                <option value="Agen" {{ $penjualan->jenis_pembeli == 'Agen' ? 'selected' : '' }}>Agen</option>
                                <option value="Toko" {{ $penjualan->jenis_pembeli == 'Toko' ? 'selected' : '' }}>Toko</option>
                                <option value="Lainnya" {{ $penjualan->jenis_pembeli == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah (kg)</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="{{ old('jumlah', $penjualan->jumlah) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_perkilo" class="form-label">Harga per Kilo (Rp)</label>
                            <input type="number" name="harga_perkilo" id="harga_perkilo" class="form-control" min="0" value="{{ old('harga_perkilo', $penjualan->harga_perkilo) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control">{{ old('keterangan', $penjualan->keterangan) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
