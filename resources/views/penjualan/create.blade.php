@extends('layouts.app')

@section('title', 'Tambah Penjualan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('penjualan.index') }}"
            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-blue-100 text-blue-600 hover:bg-blue-50 transition-colors shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Tambah Penjualan</h2>
            <p class="text-sm text-gray-400 mt-0.5">Input transaksi penjualan telur</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="flex items-start gap-3 px-4 py-3 mb-5 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
            <i class="fas fa-exclamation-circle mt-0.5 shrink-0"></i>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    {{-- Stok Info --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
        <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-5 text-white shadow-md">
            <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider mb-2">Stok Tersedia (Total)</p>
            <p class="text-3xl font-extrabold">{{ isset($stok_butir) ? number_format($stok_butir/15, 2) : '0.00' }} kg</p>
            <p class="text-sm text-blue-200 mt-1">Total {{ $stok_butir ?? 0 }} butir (1 kg = 15 butir)</p>
        </div>
        <div class="bg-white rounded-2xl border border-blue-50 p-5 shadow-sm">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Rincian Stok per Jenis</p>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between items-center bg-blue-50/50 p-2 rounded-lg">
                    <span class="text-gray-600 font-medium">Telur Layak</span>
                    <div class="text-right">
                        <div class="font-bold text-blue-700">{{ isset($telur_layak) ? number_format($telur_layak/15, 2) : '0.00' }} kg</div>
                        <div class="text-xs text-gray-400">{{ $telur_layak ?? 0 }} butir</div>
                    </div>
                </div>
                <div class="flex justify-between items-center bg-indigo-50/50 p-2 rounded-lg">
                    <span class="text-gray-600 font-medium">Telur Tidak Layak</span>
                    <div class="text-right">
                        <div class="font-bold text-indigo-700">{{ isset($telur_tidak_layak) ? number_format($telur_tidak_layak/15, 2) : '0.00' }} kg</div>
                        <div class="text-xs text-gray-400">{{ $telur_tidak_layak ?? 0 }} butir</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-shopping-cart text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Form Penjualan</span>
        </div>
        <div class="p-6">
            <form action="{{ route('penjualan.store') }}" method="POST" class="space-y-5" enctype="multipart/form-data">
                @csrf

                <div>
                    <label for="tanggal" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Tanggal Pembelian</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}" readonly
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-100 text-sm text-gray-600 focus:outline-none font-semibold cursor-not-allowed">
                    <p class="mt-1 text-xs text-gray-400">Tanggal otomatis menyesuaikan hari ini.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="jenis_pembeli" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Jenis Pembeli</label>
                        <select name="jenis_pembeli" id="jenis_pembeli" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                            <option value="">Pilih Jenis</option>
                            <option value="Agen">Agen</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div id="wrapper_pilih_agen" class="hidden">
                        <label for="pilih_agen" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Pilih Agen</label>
                        <select id="pilih_agen"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                            <option value="">-- Pilih Agen --</option>
                            @foreach($agens as $agen)
                                <option value="{{ $agen->nama_agen }}">{{ $agen->nama_agen }} ({{ $agen->nomor_hp ?? 'Tidak ada no. HP' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="wrapper_nama_pembeli">
                        <label for="pembeli" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Nama Pembeli</label>
                        <input type="text" name="pembeli" id="pembeli" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="jenis_telur" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Jenis Telur</label>
                        <select name="jenis_telur" id="jenis_telur" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                            <option value="">Pilih Jenis Telur</option>
                            <option value="layak">Layak</option>
                            <option value="tidak_layak">Tidak Layak</option>
                        </select>
                    </div>

                    <div>
                        <label for="harga_perkilo" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Harga per Kilo (Rp)</label>
                        <input type="number" name="harga_perkilo" id="harga_perkilo" min="0" required readonly
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-blue-50 text-sm text-gray-800 focus:outline-none cursor-not-allowed font-semibold">
                        <p class="mt-1 text-xs text-gray-400">Harga otomatis sesuai jenis telur</p>
                    </div>
                </div>

                <div>
                    <label for="jumlah" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Jumlah Pembelian (kg)</label>
                    <input type="number" name="jumlah" id="jumlah" min="0.1" step="0.01" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                    <div id="peringatanStok" class="hidden mt-2 px-3 py-2 bg-red-50 border border-red-200 text-red-600 text-xs rounded-lg font-medium"></div>
                </div>

                {{-- Status Pembayaran & Kasbon --}}
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Total Harga</span>
                        <span id="display_total" class="text-xl font-bold text-blue-700">Rp 0</span>
                    </div>
                    
                    <div id="wrapper_status_pembayaran" class="grid grid-cols-1 md:grid-cols-2 gap-4 hidden">
                        <div>
                            <label for="status_pembayaran" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Status Pembayaran</label>
                            <select name="status_pembayaran" id="status_pembayaran" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200">
                                <option value="lunas">Lunas</option>
                                <option value="kasbon">Kasbon (Hutang)</option>
                            </select>
                        </div>
                        <div id="wrapper_kasbon" class="hidden">
                            <label for="dibayar" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Nominal Dibayar (Rp)</label>
                            <input type="number" name="dibayar" id="dibayar" min="0" value="0"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200">
                        </div>
                    </div>

                    <div id="wrapper_kekurangan" class="hidden flex items-center justify-between border-t border-blue-200 pt-3">
                        <span class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Kekurangan (Hutang)</span>
                        <span id="display_kekurangan" class="text-lg font-bold text-red-600">Rp 0</span>
                    </div>
                </div>

                <div>
                    <label for="bukti_foto" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Upload Bukti Pembayaran (Opsional)</label>
                    <input type="file" name="bukti_foto" id="bukti_foto" accept="image/*"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                    <p class="mt-1 text-xs text-gray-400">Format yang didukung: JPG, PNG, JPEG. Ukuran maksimal: 2MB.</p>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" id="btnSimpan"
                        class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-md hover:-translate-y-0.5 transition-all duration-200 text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-save mr-2"></i> Simpan Transaksi
                    </button>
                    <a href="{{ route('penjualan.index') }}"
                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-xl transition-colors text-sm flex items-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Harga Telur
    const hargaTelur = {
        layak: {{ \App\Models\HargaTelur::orderBy('created_at', 'desc')->value('harga_layak') ?? 0 }},
        tidak_layak: {{ \App\Models\HargaTelur::orderBy('created_at', 'desc')->value('harga_tidak_layak') ?? 0 }}
    };

    // Logic Jenis Pembeli -> Agen
    const selectJenisPembeli = document.getElementById('jenis_pembeli');
    const wrapperPilihAgen = document.getElementById('wrapper_pilih_agen');
    const selectPilihAgen = document.getElementById('pilih_agen');
    const inputPembeli = document.getElementById('pembeli');
    const wrapperNamaPembeli = document.getElementById('wrapper_nama_pembeli');

    selectJenisPembeli.addEventListener('change', function() {
        const optionKasbon = document.querySelector('#status_pembayaran option[value="kasbon"]');
        const wrapperStatusPembayaran = document.getElementById('wrapper_status_pembayaran');
        
        if(this.value === 'Agen') {
            wrapperPilihAgen.classList.remove('hidden');
            inputPembeli.readOnly = true;
            inputPembeli.classList.add('bg-gray-100', 'cursor-not-allowed');
            inputPembeli.value = selectPilihAgen.value;
            
            // Show status pembayaran, enable kasbon
            if (wrapperStatusPembayaran) wrapperStatusPembayaran.classList.remove('hidden');
            if(optionKasbon) optionKasbon.disabled = false;
        } else {
            wrapperPilihAgen.classList.add('hidden');
            inputPembeli.readOnly = false;
            inputPembeli.classList.remove('bg-gray-100', 'cursor-not-allowed');
            inputPembeli.value = '';
            
            // Hide status pembayaran, force lunas
            if (wrapperStatusPembayaran) wrapperStatusPembayaran.classList.add('hidden');
            if(optionKasbon) {
                optionKasbon.disabled = true;
                if(statusPembayaran.value === 'kasbon') {
                    statusPembayaran.value = 'lunas';
                    statusPembayaran.dispatchEvent(new Event('change'));
                }
            }
        }
    });

    selectPilihAgen.addEventListener('change', function() {
        if(selectJenisPembeli.value === 'Agen') {
            inputPembeli.value = this.value;
        }
    });

    // (Listener ditambahkan ke bagian bawah di event jenis_telur)

    const jumlahInput = document.getElementById('jumlah');
    const stokLayak = {{ $telur_layak > 0 ? number_format($telur_layak/15, 2, '.', '') : 0 }};
    const stokTidakLayak = {{ $telur_tidak_layak > 0 ? number_format($telur_tidak_layak/15, 2, '.', '') : 0 }};
    const peringatanStok = document.getElementById('peringatanStok');
    const btnSimpan = document.getElementById('btnSimpan');
    const jenisTelur = document.getElementById('jenis_telur');

    function cekStok() {
        let val = parseFloat(jumlahInput.value);
        let jenis = jenisTelur.value;
        let stok = jenis === 'layak' ? stokLayak : (jenis === 'tidak_layak' ? stokTidakLayak : 0);
        
        if (!isNaN(val) && val > stok && stok > 0) {
            peringatanStok.classList.remove('hidden');
            peringatanStok.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i> Jumlah melebihi stok! Maksimal: ' + stok + ' kg';
            btnSimpan.disabled = true;
        } else {
            peringatanStok.classList.add('hidden');
            btnSimpan.disabled = false;
        }
    }
    
    // Logic Pembayaran
    const statusPembayaran = document.getElementById('status_pembayaran');
    const wrapperKasbon = document.getElementById('wrapper_kasbon');
    const wrapperKekurangan = document.getElementById('wrapper_kekurangan');
    const inputDibayar = document.getElementById('dibayar');
    const displayTotal = document.getElementById('display_total');
    const displayKekurangan = document.getElementById('display_kekurangan');
    const hargaPerkilo = document.getElementById('harga_perkilo');

    function calculateTotal() {
        let hrg = parseFloat(hargaPerkilo.value) || 0;
        let jml = parseFloat(jumlahInput.value) || 0;
        let total = hrg * jml;
        displayTotal.innerText = 'Rp ' + total.toLocaleString('id-ID');

        let dibayar = parseFloat(inputDibayar.value) || 0;
        let kurang = total - dibayar;
        if(kurang < 0) kurang = 0;
        displayKekurangan.innerText = 'Rp ' + kurang.toLocaleString('id-ID');
    }

    jumlahInput.addEventListener('input', function() {
        cekStok();
        calculateTotal();
    });
    
    document.getElementById('jenis_telur').addEventListener('change', function() {
        hargaPerkilo.value = hargaTelur[this.value] || '';
        cekStok();
        calculateTotal();
    });

    inputDibayar.addEventListener('input', calculateTotal);

    statusPembayaran.addEventListener('change', function() {
        if(this.value === 'kasbon') {
            wrapperKasbon.classList.remove('hidden');
            wrapperKekurangan.classList.remove('hidden');
        } else {
            wrapperKasbon.classList.add('hidden');
            wrapperKekurangan.classList.add('hidden');
            inputDibayar.value = 0;
        }
        calculateTotal();
    });
});
</script>
@endsection
