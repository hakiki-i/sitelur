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
        <div class="flex items-center gap-3 px-4 py-3 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl text-sm">
            <i class="fas fa-check-circle text-blue-500"></i>
            {{ session('success') }}
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
