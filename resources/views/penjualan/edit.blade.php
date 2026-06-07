@extends('layouts.app')

@section('title', 'Edit Penjualan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('penjualan.index') }}"
            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-blue-100 text-blue-600 hover:bg-blue-50 transition-colors shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Edit Penjualan</h2>
            <p class="text-sm text-gray-400 mt-0.5">Perbarui data transaksi penjualan</p>
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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
        <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-5 text-white shadow-md">
            <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider mb-2">Stok Total Tersedia</p>
            <p class="text-3xl font-extrabold">{{ number_format(($stok_layak + $stok_tidak_layak)/$bpk, 2) }} kg</p>
            <p class="text-sm text-blue-200 mt-1">{{ number_format($stok_layak + $stok_tidak_layak) }} butir</p>
        </div>
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl p-5 text-white shadow-md">
            <p class="text-xs font-semibold text-emerald-200 uppercase tracking-wider mb-1">Grade A Tersedia</p>
            <p class="text-2xl font-extrabold">{{ number_format($stok_layak/$bpk, 2) }} kg</p>
            <p class="text-xs text-emerald-200 mt-1">{{ number_format($stok_layak) }} butir</p>
        </div>
        <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl p-5 text-white shadow-md">
            <p class="text-xs font-semibold text-amber-200 uppercase tracking-wider mb-1">Grade B Tersedia</p>
            <p class="text-2xl font-extrabold">{{ number_format($stok_tidak_layak/$bpk, 2) }} kg</p>
            <p class="text-xs text-amber-200 mt-1">{{ number_format($stok_tidak_layak) }} butir</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-pen text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Form Edit Penjualan</span>
        </div>
        <div class="p-6">
            <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST" class="space-y-5" enctype="multipart/form-data" id="formPenjualan">
                @csrf
                @method('PUT')

                <div>
                    <label for="tanggal" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Tanggal Pembelian</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $penjualan->tanggal) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="jenis_pembeli" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Jenis Pembeli</label>
                        <select name="jenis_pembeli" id="jenis_pembeli" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                            <option value="">Pilih Jenis</option>
                            <option value="Agen" {{ $penjualan->jenis_pembeli == 'Agen' ? 'selected' : '' }}>Agen</option>
                            <option value="Lainnya" {{ $penjualan->jenis_pembeli == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>

                    <div id="wrapper_pilih_agen" class="{{ $penjualan->jenis_pembeli == 'Agen' ? '' : 'hidden' }}">
                        <label for="pilih_agen" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Pilih Agen</label>
                        <select id="pilih_agen"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                            <option value="">-- Pilih Agen --</option>
                            @foreach($agens as $agen)
                                <option value="{{ $agen->nama_agen }}" {{ $penjualan->pembeli == $agen->nama_agen ? 'selected' : '' }}>{{ $agen->nama_agen }} ({{ $agen->nomor_hp ?? 'Tidak ada no. HP' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="wrapper_nama_pembeli">
                        <label for="pembeli" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Nama Pembeli</label>
                        <input type="text" name="pembeli" id="pembeli" value="{{ old('pembeli', $penjualan->pembeli) }}" required {{ $penjualan->jenis_pembeli == 'Agen' ? 'readonly' : '' }}
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 {{ $penjualan->jenis_pembeli == 'Agen' ? 'bg-gray-100 cursor-not-allowed' : 'bg-gray-50' }} text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all">
                    </div>
                </div>

                {{-- Pesanan Telur --}}
                <div class="space-y-3">
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Pesanan Telur <span class="text-red-500">*</span> <span class="text-gray-400 font-normal normal-case">(isi minimal satu jenis)</span></p>

                    {{-- Grade A --}}
                    <div class="border border-emerald-100 bg-emerald-50/40 rounded-xl p-4 space-y-3">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">
                                <i class="fas fa-star text-[10px]"></i> Grade A
                            </span>
                            <span class="text-xs text-gray-400">Stok: {{ number_format($stok_layak/$bpk, 2) }} kg (termasuk penjualan ini)</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Jumlah (kg)</label>
                                <input type="number" name="jumlah_a" id="jumlah_a" min="0" step="0.01" placeholder="0.00" value="{{ old('jumlah_a', $jumlah_a) }}"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition-all duration-200">
                                <div id="peringatanStokA" class="hidden mt-1.5 px-3 py-1.5 bg-red-50 border border-red-200 text-red-600 text-xs rounded-lg font-medium"></div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Harga/kg (Rp)</label>
                                <input type="number" name="harga_perkilo_a" id="harga_perkilo_a" min="0" readonly value="{{ $harga_a }}"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-100 text-sm text-gray-700 font-semibold focus:outline-none cursor-not-allowed transition-all duration-200">
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-500">Subtotal Grade A:</span>
                            <span id="subtotal_a" class="font-bold text-emerald-700">Rp 0</span>
                        </div>
                    </div>

                    {{-- Grade B --}}
                    <div class="border border-amber-100 bg-amber-50/40 rounded-xl p-4 space-y-3">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full">
                                <i class="fas fa-certificate text-[10px]"></i> Grade B
                            </span>
                            <span class="text-xs text-gray-400">Stok: {{ number_format($stok_tidak_layak/$bpk, 2) }} kg (termasuk penjualan ini)</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Jumlah (kg)</label>
                                <input type="number" name="jumlah_b" id="jumlah_b" min="0" step="0.01" placeholder="0.00" value="{{ old('jumlah_b', $jumlah_b) }}"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition-all duration-200">
                                <div id="peringatanStokB" class="hidden mt-1.5 px-3 py-1.5 bg-red-50 border border-red-200 text-red-600 text-xs rounded-lg font-medium"></div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">Harga/kg (Rp)</label>
                                <input type="number" name="harga_perkilo_b" id="harga_perkilo_b" min="0" readonly value="{{ $harga_b }}"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-100 text-sm text-gray-700 font-semibold focus:outline-none cursor-not-allowed transition-all duration-200">
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-500">Subtotal Grade B:</span>
                            <span id="subtotal_b" class="font-bold text-amber-700">Rp 0</span>
                        </div>
                    </div>
                </div>

                {{-- Status Pembayaran & Kasbon --}}
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Total Harga</span>
                        <span id="display_total" class="text-xl font-bold text-blue-700">Rp 0</span>
                    </div>

                    <div id="wrapper_status_pembayaran" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="status_pembayaran" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Status Pembayaran</label>
                            <select name="status_pembayaran" id="status_pembayaran" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200">
                                <option value="lunas" {{ $penjualan->status_pembayaran == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="kasbon" {{ $penjualan->status_pembayaran == 'kasbon' ? 'selected' : '' }}>Kasbon (Hutang)</option>
                            </select>
                        </div>
                        <div id="wrapper_kasbon" class="{{ $penjualan->status_pembayaran == 'kasbon' ? '' : 'hidden' }}">
                            <label for="dibayar" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Nominal Dibayar (Rp)</label>
                            <input type="number" name="dibayar" id="dibayar" min="0" value="{{ old('dibayar', $penjualan->dibayar) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200">
                        </div>
                    </div>

                    <div id="wrapper_kekurangan" class="{{ $penjualan->status_pembayaran == 'kasbon' ? '' : 'hidden' }} flex items-center justify-between border-t border-blue-200 pt-3">
                        <span class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Kekurangan (Hutang)</span>
                        <span id="display_kekurangan" class="text-lg font-bold text-red-600">Rp {{ number_format($penjualan->kekurangan, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all resize-none">{{ old('keterangan', $penjualan->keterangan) }}</textarea>
                </div>

                <div>
                    <label for="bukti_foto" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Upload Bukti Pembayaran Baru (Opsional)</label>
                    <input type="file" name="bukti_foto" id="bukti_foto" accept="image/*"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                    <p class="mt-1 text-xs text-gray-400">Format yang didukung: JPG, PNG, JPEG. Ukuran maksimal: 2MB.</p>
                    @if($penjualan->bukti_foto)
                        <div class="mt-2">
                            <span class="text-xs text-emerald-600 font-semibold"><i class="fas fa-check-circle mr-1"></i> Bukti foto sudah diunggah sebelumnya.</span>
                            <a href="{{ Storage::url($penjualan->bukti_foto) }}" target="_blank" class="text-xs text-blue-600 hover:underline ml-2">Lihat Foto</a>
                        </div>
                    @endif
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" id="btnSimpan"
                        class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-md hover:-translate-y-0.5 transition-all duration-200 text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-save mr-2"></i> Update Transaksi
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
    const stokA = {{ $stok_layak > 0 ? number_format($stok_layak/$bpk, 4, '.', '') : 0 }};
    const stokB = {{ $stok_tidak_layak > 0 ? number_format($stok_tidak_layak/$bpk, 4, '.', '') : 0 }};

    const jumlahA     = document.getElementById('jumlah_a');
    const jumlahB     = document.getElementById('jumlah_b');
    const hargaA      = document.getElementById('harga_perkilo_a');
    const hargaB      = document.getElementById('harga_perkilo_b');
    const subtotalA   = document.getElementById('subtotal_a');
    const subtotalB   = document.getElementById('subtotal_b');
    const displayTotal= document.getElementById('display_total');
    const peringA     = document.getElementById('peringatanStokA');
    const peringB     = document.getElementById('peringatanStokB');
    const btnSimpan   = document.getElementById('btnSimpan');
    const inputDibayar= document.getElementById('dibayar');
    const displayKekurangan = document.getElementById('display_kekurangan');
    const statusPembayaran  = document.getElementById('status_pembayaran');
    const wrapperKasbon     = document.getElementById('wrapper_kasbon');
    const wrapperKekurangan = document.getElementById('wrapper_kekurangan');

    function fmt(n) { return 'Rp ' + n.toLocaleString('id-ID'); }

    function hitungSemua() {
        const valA = parseFloat(jumlahA.value) || 0;
        const valB = parseFloat(jumlahB.value) || 0;
        const hrgA = parseFloat(hargaA.value)  || 0;
        const hrgB = parseFloat(hargaB.value)  || 0;

        // Stok warning Grade A
        if (valA > 0 && valA > stokA) {
            peringA.classList.remove('hidden');
            peringA.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i> Melebihi stok! Maksimal: ' + stokA.toFixed(2) + ' kg';
        } else {
            peringA.classList.add('hidden');
        }

        // Stok warning Grade B
        if (valB > 0 && valB > stokB) {
            peringB.classList.remove('hidden');
            peringB.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i> Melebihi stok! Maksimal: ' + stokB.toFixed(2) + ' kg';
        } else {
            peringB.classList.add('hidden');
        }

        const subA = valA * hrgA;
        const subB = valB * hrgB;
        subtotalA.innerText = fmt(subA);
        subtotalB.innerText = fmt(subB);

        const total = subA + subB;
        displayTotal.innerText = fmt(total);

        // Kasbon kekurangan
        if (statusPembayaran.value === 'kasbon') {
            const dibayar = parseFloat(inputDibayar.value) || 0;
            const kurang  = Math.max(0, total - dibayar);
            displayKekurangan.innerText = fmt(kurang);
        }

        // Disable tombol jika ada stok yang terlampaui atau keduanya kosong
        const adaStokError = (valA > 0 && valA > stokA) || (valB > 0 && valB > stokB);
        const keduanyaKosong = valA <= 0 && valB <= 0;
        btnSimpan.disabled = adaStokError || keduanyaKosong;
    }

    jumlahA.addEventListener('input', hitungSemua);
    jumlahB.addEventListener('input', hitungSemua);
    inputDibayar.addEventListener('input', hitungSemua);

    statusPembayaran.addEventListener('change', function() {
        if (this.value === 'kasbon') {
            wrapperKasbon.classList.remove('hidden');
            wrapperKekurangan.classList.remove('hidden');
        } else {
            wrapperKasbon.classList.add('hidden');
            wrapperKekurangan.classList.add('hidden');
            inputDibayar.value = 0;
        }
        hitungSemua();
    });

    // Logic Jenis Pembeli -> Agen
    const selectJenisPembeli = document.getElementById('jenis_pembeli');
    const wrapperPilihAgen   = document.getElementById('wrapper_pilih_agen');
    const selectPilihAgen    = document.getElementById('pilih_agen');
    const inputPembeli       = document.getElementById('pembeli');

    selectJenisPembeli.addEventListener('change', function() {
        const optionKasbon = document.querySelector('#status_pembayaran option[value="kasbon"]');
        const wrapperStatusPembayaran = document.getElementById('wrapper_status_pembayaran');

        if (this.value === 'Agen') {
            wrapperPilihAgen.classList.remove('hidden');
            inputPembeli.readOnly = true;
            inputPembeli.classList.add('bg-gray-100', 'cursor-not-allowed');
            inputPembeli.value = selectPilihAgen.value;
            if (wrapperStatusPembayaran) wrapperStatusPembayaran.classList.remove('hidden');
            if (optionKasbon) optionKasbon.disabled = false;
        } else {
            wrapperPilihAgen.classList.add('hidden');
            inputPembeli.readOnly = false;
            inputPembeli.classList.remove('bg-gray-100', 'cursor-not-allowed');
            inputPembeli.value = '';
            if (wrapperStatusPembayaran) wrapperStatusPembayaran.classList.add('hidden');
            if (optionKasbon) {
                optionKasbon.disabled = true;
                if (statusPembayaran.value === 'kasbon') {
                    statusPembayaran.value = 'lunas';
                    statusPembayaran.dispatchEvent(new Event('change'));
                }
            }
        }
    });

    selectPilihAgen.addEventListener('change', function() {
        if (selectJenisPembeli.value === 'Agen') inputPembeli.value = this.value;
    });

    // Validasi sebelum submit: minimal 1 jenis telur harus diisi
    document.getElementById('formPenjualan').addEventListener('submit', function(e) {
        const valA = parseFloat(jumlahA.value) || 0;
        const valB = parseFloat(jumlahB.value) || 0;
        if (valA <= 0 && valB <= 0) {
            e.preventDefault();
            alert('Harap isi minimal satu jenis telur (Grade A atau Grade B)!');
        }
    });

    // Init
    hitungSemua();
});
</script>
@endsection
