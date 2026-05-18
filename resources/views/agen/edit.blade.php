@extends('layouts.app')

@section('title', 'Edit Agen')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('agen.index') }}"
            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-blue-100 text-blue-600 hover:bg-blue-50 transition-colors shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Edit Agen</h2>
            <p class="text-sm text-gray-400 mt-0.5">Perbarui data agen</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-pen text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Form Edit Agen</span>
        </div>
        <div class="p-6">
            <form action="{{ route('agen.update', $agen->id) }}" method="POST" class="space-y-5">
                @csrf @method('PUT')
                <div>
                    <label for="nama_agen" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Nama Agen</label>
                    <input type="text" name="nama_agen" id="nama_agen" value="{{ $agen->nama_agen }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                </div>
                <div>
                    <label for="nomor_hp" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Nomor HP</label>
                    <input type="text" name="nomor_hp" id="nomor_hp" value="{{ $agen->nomor_hp }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                </div>
                <div>
                    <label for="alamat" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200 resize-none">{{ $agen->alamat }}</textarea>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-md hover:-translate-y-0.5 transition-all duration-200 text-sm">
                        <i class="fas fa-save mr-2"></i> Update
                    </button>
                    <a href="{{ route('agen.index') }}"
                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-xl transition-colors text-sm flex items-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
