@extends('layouts.app')

@section('title', 'Pengaturan Konversi Telur')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('produksi.index') }}"
            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-blue-100 text-blue-600 hover:bg-blue-50 transition-colors shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Pengaturan Konversi Telur</h2>
            <p class="text-sm text-gray-400 mt-0.5">Atur nilai konversi butir ke kilogram</p>
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 px-4 py-3 mb-5 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
            <i class="fas fa-check-circle shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="flex items-start gap-3 px-4 py-3 mb-5 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
            <i class="fas fa-exclamation-circle mt-0.5 shrink-0"></i>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    {{-- Info Card --}}
    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg mb-6">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                <i class="fas fa-exchange-alt text-xl text-yellow-200"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-blue-200 uppercase tracking-wider">Nilai Konversi Saat Ini</p>
                <p class="text-3xl font-extrabold">1 kg = {{ $butirPerKg }} butir</p>
            </div>
        </div>
        <p class="text-sm text-blue-200">
            Nilai ini digunakan di seluruh sistem: halaman produksi, penjualan, laporan, dan dashboard.
        </p>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-cog text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Ubah Nilai Konversi</span>
        </div>
        <div class="p-6">
            <form action="{{ route('pengaturan.update') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="butir_per_kg" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">
                        Jumlah Butir per Kg <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="number" name="butir_per_kg" id="butir_per_kg"
                            value="{{ old('butir_per_kg', $butirPerKg) }}"
                            min="1" max="1000" required
                            class="w-full px-4 py-3 pr-20 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200 text-lg font-bold">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-medium">butir/kg</span>
                    </div>
                    <p class="mt-1.5 text-xs text-gray-400">
                        Contoh umum: 15 butir/kg (ayam ras), 18 butir/kg (ayam kampung kecil).
                    </p>
                </div>

                {{-- Preview --}}
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider mb-2">Preview Konversi</p>
                    <div class="grid grid-cols-3 gap-3 text-center text-sm">
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <p class="text-gray-400 text-xs mb-1">100 butir</p>
                            <p id="preview100" class="font-bold text-blue-700">{{ number_format(100/$butirPerKg, 2) }} kg</p>
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <p class="text-gray-400 text-xs mb-1">1.000 butir</p>
                            <p id="preview1000" class="font-bold text-blue-700">{{ number_format(1000/$butirPerKg, 2) }} kg</p>
                        </div>
                        <div class="bg-white rounded-lg p-3 shadow-sm">
                            <p class="text-gray-400 text-xs mb-1">10.000 butir</p>
                            <p id="preview10000" class="font-bold text-blue-700">{{ number_format(10000/$butirPerKg, 2) }} kg</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-md hover:-translate-y-0.5 transition-all duration-200 text-sm">
                        <i class="fas fa-save mr-2"></i> Simpan Pengaturan
                    </button>
                    <a href="{{ route('produksi.index') }}"
                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-xl transition-colors text-sm flex items-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('butir_per_kg').addEventListener('input', function() {
    const v = parseFloat(this.value) || 1;
    const fmt = (n) => (n / v).toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    document.getElementById('preview100').textContent   = fmt(100)   + ' kg';
    document.getElementById('preview1000').textContent  = fmt(1000)  + ' kg';
    document.getElementById('preview10000').textContent = fmt(10000) + ' kg';
});
</script>
@endsection
