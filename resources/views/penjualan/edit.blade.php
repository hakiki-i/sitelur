@extends('layouts.app')

@section('title', 'Edit Penjualan')

@section('content')
<div class="max-w-2xl mx-auto">
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

    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-pen text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Form Edit Penjualan</span>
        </div>
        <div class="p-6">
            <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST" class="space-y-5">
                @csrf @method('PUT')
                
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $penjualan->tanggal) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Jenis Pembeli</label>
                        <select name="jenis_pembeli" id="jenis_pembeli" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all">
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

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Nama Pembeli</label>
                        <input type="text" name="pembeli" id="pembeli" value="{{ old('pembeli', $penjualan->pembeli) }}" required {{ $penjualan->jenis_pembeli == 'Agen' ? 'readonly' : '' }}
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 {{ $penjualan->jenis_pembeli == 'Agen' ? 'bg-gray-100 cursor-not-allowed' : 'bg-gray-50' }} text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Jumlah (kg)</label>
                    <input type="number" name="jumlah" min="0.1" step="0.01" value="{{ old('jumlah', $penjualan->jumlah) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Harga per Kilo (Rp)</label>
                    <input type="number" name="harga_perkilo" min="0" value="{{ old('harga_perkilo', $penjualan->harga_perkilo) }}" required readonly
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-100 text-sm font-semibold focus:outline-none cursor-not-allowed transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all resize-none">{{ old('keterangan', $penjualan->keterangan) }}</textarea>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-md hover:-translate-y-0.5 transition-all text-sm">
                        <i class="fas fa-save mr-2"></i> Update
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
    const selectJenisPembeli = document.getElementById('jenis_pembeli');
    const wrapperPilihAgen = document.getElementById('wrapper_pilih_agen');
    const selectPilihAgen = document.getElementById('pilih_agen');
    const inputPembeli = document.getElementById('pembeli');

    selectJenisPembeli.addEventListener('change', function() {
        if(this.value === 'Agen') {
            wrapperPilihAgen.classList.remove('hidden');
            inputPembeli.readOnly = true;
            inputPembeli.classList.add('bg-gray-100', 'cursor-not-allowed');
            inputPembeli.classList.remove('bg-gray-50');
            inputPembeli.value = selectPilihAgen.value;
        } else {
            wrapperPilihAgen.classList.add('hidden');
            inputPembeli.readOnly = false;
            inputPembeli.classList.remove('bg-gray-100', 'cursor-not-allowed');
            inputPembeli.classList.add('bg-gray-50');
            inputPembeli.value = '';
        }
    });

    selectPilihAgen.addEventListener('change', function() {
        if(selectJenisPembeli.value === 'Agen') {
            inputPembeli.value = this.value;
        }
    });
});
</script>
@endsection
