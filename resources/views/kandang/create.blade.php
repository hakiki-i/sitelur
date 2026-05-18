@extends('layouts.app')

@section('title', 'Tambah Kandang')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('kandang.index') }}"
            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-blue-100 text-blue-600 hover:bg-blue-50 transition-colors shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Tambah Kandang</h2>
            <p class="text-sm text-gray-400 mt-0.5">Masukkan data kandang baru</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-warehouse text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Form Tambah Kandang</span>
        </div>
        <div class="p-6">
            <form action="{{ route('kandang.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="nama_kandang" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Nama Kandang</label>
                    <input type="text" name="nama_kandang" id="nama_kandang" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                </div>
                <div>
                    <label for="jumlah_ayam" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Jumlah Ayam (Kapasitas)</label>
                    <input type="number" name="jumlah_ayam" id="jumlah_ayam" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                </div>
                <div>
                    <label for="keterangan" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200 resize-none"></textarea>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-md hover:-translate-y-0.5 transition-all duration-200 text-sm">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                    <a href="{{ route('kandang.index') }}"
                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-xl transition-colors text-sm flex items-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
