@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-success text-white">Tambah Penjualan</div>
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
                    <div class="row">
                        <div class="col-md-8">
                            <div class="alert alert-info">
                                <strong>Stok Produksi Saat Ini:</strong> {{ $stok_butir ?? 0 }} butir ({{ $stok_kg ?? 0 }} kg)
                                <br><small>Konversi: 1 kg = 15 butir</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-info mb-3">
                                <div class="card-header p-2 py-1 bg-info text-white">Rincian Telur</div>
                                <div class="card-body p-2">
                                    <div class="mb-1 small">Telur Layak: <strong>{{ $telur_layak }}</strong></div>
                                    <div class="mb-1 small">Telur Tidak Layak: <strong>{{ $telur_tidak_layak }}</strong></div>
                                    <div class="mb-1 small">Total (kg): <strong>{{ isset($stok_butir) ? number_format($stok_butir/15, 2) : '0.00' }}</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('penjualan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="pembeli" class="form-label">Pembeli</label>
                            <input type="text" name="pembeli" id="pembeli" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_pembeli" class="form-label">Jenis Pembeli</label>
                            <select name="jenis_pembeli" id="jenis_pembeli" class="form-control">
                                <option value="">Pilih Jenis</option>
                                <option value="Agen">Agen</option>
                                <option value="Toko">Toko</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_telur" class="form-label">Jenis Telur</label>
                            <select name="jenis_telur" id="jenis_telur" class="form-control" required>
                                <option value="">Pilih Jenis Telur</option>
                                <option value="layak">Layak</option>
                                <option value="tidak_layak">Tidak Layak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah (kg)</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" step="0.01" required>
                            <div id="peringatanStok" class="text-danger mt-1" style="display:none;font-size:0.95em;"></div>
                        </div>
                        <div class="mb-3">
                            <label for="harga_perkilo" class="form-label">Harga per Kilo (Rp)</label>
                            <input type="number" name="harga_perkilo" id="harga_perkilo" class="form-control" min="0" required readonly>
                        </div>
                        <div class="mb-3 d-flex gap-2">
                            <button type="submit" name="action" value="save" class="btn btn-primary">Simpan</button>
                            <button type="submit" name="action" value="save_print" class="btn btn-success">Simpan & Cetak Nota</button>
                        </div>
                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const hargaTelur = {
                                layak: {{ \App\Models\HargaTelur::orderBy('created_at', 'desc')->value('harga_layak') ?? 0 }},
                                tidak_layak: {{ \App\Models\HargaTelur::orderBy('created_at', 'desc')->value('harga_tidak_layak') ?? 0 }}
                            };
                            document.getElementById('jenis_telur').addEventListener('change', function() {
                                const jenis = this.value;
                                document.getElementById('harga_perkilo').value = hargaTelur[jenis] || '';
                            });

                            // Validasi stok saat input jumlah
                            const jumlahInput = document.getElementById('jumlah');
                            const stokLayak = {{ $telur_layak > 0 ? number_format($telur_layak/15, 2, '.', '') : 0 }};
                            const stokTidakLayak = {{ $telur_tidak_layak > 0 ? number_format($telur_tidak_layak/15, 2, '.', '') : 0 }};
                            const peringatanStok = document.getElementById('peringatanStok');
                            const btnSimpan = document.getElementById('btnSimpan');
                            const jenisTelur = document.getElementById('jenis_telur');

                            function cekStok() {
                                let val = parseFloat(jumlahInput.value);
                                let jenis = jenisTelur.value;
                                let stok = 0;
                                if (jenis === 'layak') stok = stokLayak;
                                else if (jenis === 'tidak_layak') stok = stokTidakLayak;
                                else stok = 0;
                                if (!isNaN(val) && val > stok) {
                                    peringatanStok.style.display = 'block';
                                    peringatanStok.textContent = 'Jumlah penjualan melebihi stok telur ' + (jenis === 'layak' ? 'layak' : 'tidak layak') + '! Maksimal: ' + stok + ' kg';
                                    btnSimpan.disabled = true;
                                } else {
                                    peringatanStok.style.display = 'none';
                                    btnSimpan.disabled = false;
                                }
                            }
                            jumlahInput.addEventListener('input', cekStok);
                            jenisTelur.addEventListener('change', cekStok);
                        });
                        </script>
                        <div class="mb-3">
                            <label for="bukti_foto" class="form-label">Upload Bukti Foto (Nota/Kwitansi)</label>
                            <input type="file" name="bukti_foto" id="bukti_foto" class="form-control" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-success" id="btnSimpan">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
