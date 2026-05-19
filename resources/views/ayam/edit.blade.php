@extends('layouts.app')

@section('title', 'Edit Ayam')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('ayam.index') }}"
            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-blue-100 text-blue-600 hover:bg-blue-50 transition-colors shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Edit Ayam</h2>
            <p class="text-sm text-gray-400 mt-0.5">Perbarui data ayam</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-pen text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Form Edit Ayam</span>
        </div>
        <div class="p-6">
            <form action="{{ route('ayam.update', $ayam->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="jumlah_ayam" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Jumlah Ayam</label>
                    <input type="number" name="jumlah_ayam" id="jumlah_ayam" min="1" value="{{ $ayam->jumlah_ayam ?? '' }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                </div>

                <div>
                    <label for="tanggal_masuk" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" id="tanggal_masuk" value="{{ $ayam->tanggal_masuk }}" required readonly
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-100 text-sm text-gray-500 cursor-not-allowed">
                </div>

                <div>
                    <label for="kandang_id" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Kandang</label>
                    <select id="kandang_id_disabled" disabled
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-100 text-sm text-gray-500 cursor-not-allowed">
                        @foreach($kandang as $k)
                            <option value="{{ $k->id }}" data-kapasitas="{{ $k->jumlah_ayam }}" {{ $ayam->kandang_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kandang }} (kapasitas: {{ $k->jumlah_ayam }})</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="kandang_id" id="kandang_id" value="{{ $ayam->kandang_id }}">
                    <script>
                    window.addEventListener('DOMContentLoaded', function() {
                        var select = document.getElementById('kandang_id_disabled');
                        var kapasitas = select.options[select.selectedIndex].getAttribute('data-kapasitas');
                        var jumlahInput = document.getElementById('jumlah_ayam');
                        if (kapasitas) { jumlahInput.max = kapasitas; jumlahInput.placeholder = 'Maksimal ' + kapasitas; }
                    });
                    </script>
                </div>

                <div>
                    <label for="keterangan" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3" readonly
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-100 text-sm text-gray-500 cursor-not-allowed resize-none">{{ $ayam->keterangan }}</textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-md hover:-translate-y-0.5 transition-all duration-200 text-sm">
                        <i class="fas fa-save mr-2"></i> Update
                    </button>
                    <a href="{{ route('ayam.index') }}"
                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-xl transition-colors text-sm flex items-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
