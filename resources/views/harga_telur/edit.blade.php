@extends('layouts.app')

@section('title', 'Edit Harga Telur')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('harga_telur.index') }}"
            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-blue-100 text-blue-600 hover:bg-blue-50 transition-colors shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Edit Harga Telur</h2>
            <p class="text-sm text-gray-400 mt-0.5">Perbarui data harga telur</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-pen text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Form Edit Harga Telur</span>
        </div>
        <div class="p-6">
            <form action="{{ route('harga_telur.update', $harga->id) }}" method="POST" class="space-y-5">
                @csrf @method('PUT')
                <div>
                    <label for="tanggal" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $harga->tanggal) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                    @error('tanggal')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="harga_layak" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Harga Telur Layak (Rp)</label>
                    <input type="number" name="harga_layak" id="harga_layak" value="{{ old('harga_layak', $harga->harga_layak) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                    @error('harga_layak')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="harga_tidak_layak" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Harga Telur Tidak Layak (Rp)</label>
                    <input type="number" name="harga_tidak_layak" id="harga_tidak_layak" value="{{ old('harga_tidak_layak', $harga->harga_tidak_layak) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                    @error('harga_tidak_layak')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-md hover:-translate-y-0.5 transition-all duration-200 text-sm">
                        <i class="fas fa-save mr-2"></i> Update
                    </button>
                    <a href="{{ route('harga_telur.index') }}"
                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-xl transition-colors text-sm flex items-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
