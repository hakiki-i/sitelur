@extends('layouts.app')

@section('title', 'Tambah Ayam')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('ayam.index') }}"
            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-blue-100 text-blue-600 hover:bg-blue-50 transition-colors shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Tambah Ayam</h2>
            <p class="text-sm text-gray-400 mt-0.5">Masukkan data ayam baru</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="flex items-start gap-3 px-4 py-3 mb-5 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
            <i class="fas fa-exclamation-circle mt-0.5 shrink-0"></i>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-drumstick-bite text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Form Tambah Ayam</span>
        </div>
        <div class="p-6">
            <form action="{{ route('ayam.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="jumlah_ayam" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Jumlah Ayam</label>
                    <input type="number" name="jumlah_ayam" id="jumlah_ayam" min="1" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                </div>

                <div>
                    <label for="tanggal_masuk" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" id="tanggal_masuk" required value="{{ date('Y-m-d') }}" readonly
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-100 text-sm text-gray-800 focus:outline-none cursor-not-allowed transition-all duration-200">
                    <p class="mt-1 text-xs text-gray-400">Tanggal masuk fiks ke hari ini.</p>
                </div>

                <div>
                    <label for="kandang_id" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Kandang</label>
                    <select name="kandang_id" id="kandang_id" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
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
