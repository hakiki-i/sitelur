@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-success text-white">Tambah Ayam</div>
                <div class="card-body">
                    <a href="{{ route('ayam.index') }}" class="btn btn-secondary mb-3">Kembali</a>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('ayam.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="jumlah_ayam" class="form-label">Jumlah Ayam</label>
                            <input type="number" name="jumlah_ayam" id="jumlah_ayam" class="form-control" min="1" required>
                        </div>
                        <!-- Input umur ayam dihapus, umur otomatis dari tanggal masuk -->
                        <div class="mb-3">
                            <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control" required max="{{ date('Y-m-d') }}">
                        </div>
                        <!-- Tidak ada script otomatis, umur hanya info -->
                        <div class="mb-3">
                            <label for="kandang_id" class="form-label">Kandang</label>
                            <select name="kandang_id" id="kandang_id" class="form-control" required>
                                <option value="">Pilih Kandang</option>
                                @foreach($kandang as $k)
                                    <option value="{{ $k->id }}" data-kapasitas="{{ $k->jumlah_ayam }}">{{ $k->nama_kandang }} (kapasitas: {{ $k->jumlah_ayam }})</option>
                                @endforeach
                            </select>
                                                <script>
                                                document.getElementById('kandang_id').addEventListener('change', function() {
                                                    var kapasitas = this.options[this.selectedIndex].getAttribute('data-kapasitas');
                                                    var jumlahInput = document.getElementById('jumlah_ayam');
                                                    if (kapasitas) {
                                                        jumlahInput.max = kapasitas;
                                                        jumlahInput.placeholder = 'Maksimal ' + kapasitas;
                                                    } else {
                                                        jumlahInput.removeAttribute('max');
                                                        jumlahInput.placeholder = '';
                                                    }
                                                });
                                                </script>
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
