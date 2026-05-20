@extends('layouts.app')

@section('title', 'Harga Telur')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Page Header --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Harga Telur</h2>
        <p class="text-sm text-gray-400 mt-0.5">Manajemen harga telur layak dan tidak layak</p>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-4 py-3 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl text-sm mb-6">
            <i class="fas fa-check-circle text-blue-500"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Widget Live Indeks Pasar --}}
    @if(isset($indeksPasar))
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl shadow-md overflow-hidden text-white mb-6">
        <div class="px-6 py-4 border-b border-white/20 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-chart-line text-emerald-100 text-lg"></i>
                <span class="font-bold tracking-wide">Live Indeks Pasar Telur Ras</span>
            </div>
            <div class="text-xs text-emerald-100 bg-white/20 px-3 py-1.5 rounded-full font-medium">
                <i class="fas fa-calendar-day mr-1"></i> {{ \Carbon\Carbon::parse($indeksPasar['tanggal'])->translatedFormat('d F Y') }}
            </div>
        </div>
        <div class="p-5 sm:p-6">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach($indeksPasar['wilayah'] as $wilayah)
                <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm border border-white/10 relative overflow-hidden group hover:bg-white/20 transition-all duration-300">
                    <div class="text-xs text-emerald-100 font-medium mb-1 truncate">{{ $wilayah['nama'] }}</div>
                    <div class="text-xl sm:text-2xl font-bold tracking-tight">Rp {{ number_format($wilayah['harga'], 0, ',', '.') }}</div>
                    
                    <div class="absolute top-3 right-3">
                        @if($wilayah['status'] == 'naik')
                            <div class="flex items-center justify-center w-5 h-5 rounded-full bg-red-500/20 text-red-200" title="Harga Naik">
                                <i class="fas fa-arrow-up text-[10px] animate-bounce"></i>
                            </div>
                        @elseif($wilayah['status'] == 'turun')
                            <div class="flex items-center justify-center w-5 h-5 rounded-full bg-emerald-300/30 text-emerald-100" title="Harga Turun">
                                <i class="fas fa-arrow-down text-[10px] animate-bounce"></i>
                            </div>
                        @else
                            <div class="flex items-center justify-center w-5 h-5 rounded-full bg-gray-300/20 text-gray-200" title="Harga Stabil">
                                <i class="fas fa-minus text-[10px]"></i>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4 text-[10px] sm:text-xs text-emerald-100 flex items-center gap-2">
                <i class="fas fa-info-circle opacity-80"></i>
                <span class="opacity-90">Sumber data: {{ $indeksPasar['sumber'] }}. Gunakan informasi ini sebagai referensi sebelum menentukan Harga Telur harian Anda.</span>
            </div>
        </div>
    </div>
    @endif

    {{-- Harga Terbaru --}}
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-tags text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Harga Telur Terbaru</span>
        </div>
        <div class="p-6">
            @if($latestHarga)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-5 text-white">
                        <div class="text-xs font-semibold uppercase tracking-widest text-blue-200 mb-1">Harga Telur Layak</div>
                        <div class="text-2xl font-extrabold">Rp {{ number_format($latestHarga->harga_layak,0,',','.') }}</div>
                        <div class="text-xs text-blue-200 mt-1">per kilogram</div>
                    </div>
                    <div class="bg-gradient-to-br from-indigo-500 to-violet-600 rounded-2xl p-5 text-white">
                        <div class="text-xs font-semibold uppercase tracking-widest text-indigo-200 mb-1">Harga Tidak Layak</div>
                        <div class="text-2xl font-extrabold">Rp {{ number_format($latestHarga->harga_tidak_layak,0,',','.') }}</div>
                        <div class="text-xs text-indigo-200 mt-1">per kilogram</div>
                    </div>
                </div>
                <p class="text-sm text-gray-400"><i class="fas fa-calendar-alt mr-1"></i> Berlaku mulai: <span class="font-semibold text-gray-600">{{ $latestHarga->tanggal }}</span></p>
            @else
                <div class="flex items-center gap-3 px-4 py-3 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl text-sm">
                    <i class="fas fa-info-circle"></i> Belum ada data harga telur.
                </div>
            @endif
        </div>
    </div>

    {{-- Form Input Harga Baru --}}
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-plus-circle text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Input Harga Telur Baru</span>
        </div>
        <div class="p-6">
            <form action="{{ route('harga_telur.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="tanggal" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                        @error('tanggal')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="harga_layak" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Harga Layak (Rp)</label>
                        <input type="number" name="harga_layak" id="harga_layak" value="{{ old('harga_layak') }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                        @error('harga_layak')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="harga_tidak_layak" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Harga Tidak Layak (Rp)</label>
                        <input type="number" name="harga_tidak_layak" id="harga_tidak_layak" value="{{ old('harga_tidak_layak') }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                        @error('harga_tidak_layak')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-md hover:-translate-y-0.5 transition-all duration-200 text-sm">
                    <i class="fas fa-save mr-2"></i> Simpan Harga
                </button>
            </form>
        </div>
    </div>

    {{-- Riwayat Harga --}}
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-history text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Riwayat Harga Telur</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Harga Layak</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Harga Tidak Layak</th>
                        <th class="px-4 py-3 text-center font-semibold text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($listHarga as $harga)
                    <tr class="hover:bg-blue-50/40 transition-colors duration-150">
                        <td class="px-4 py-3 text-gray-600">{{ $harga->tanggal }}</td>
                        <td class="px-4 py-3 font-semibold text-blue-700">Rp {{ number_format($harga->harga_layak,0,',','.') }}</td>
                        <td class="px-4 py-3 font-semibold text-indigo-700">Rp {{ number_format($harga->harga_tidak_layak,0,',','.') }}</td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('harga_telur.destroy', $harga->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Yakin hapus data ini?')"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-lg hover:bg-red-200 transition-colors">
                                    <i class="fas fa-trash text-xs"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-400">Belum ada data harga telur.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
