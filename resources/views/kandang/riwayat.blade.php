@extends('layouts.app')

@section('title', 'Riwayat Ayam di ' . $kandang->nama_kandang)

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Riwayat Ayam</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kandang: <span class="font-semibold text-blue-600">{{ $kandang->nama_kandang }}</span></p>
        </div>
        <a href="{{ route('kandang.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-xl shadow-sm hover:bg-gray-50 transition-all duration-200">
            <i class="fas fa-arrow-left text-xs"></i> Kembali
        </a>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-history text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Catatan Keluar/Masuk Ayam</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Tanggal Masuk (Umur 20 Mg)</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Jumlah Ayam</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Tanggal Dikeluarkan/Afkir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($riwayatAyam as $ayam)
                    <tr class="hover:bg-blue-50/40 transition-colors duration-150">
                        <td class="px-4 py-3 text-gray-500 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($ayam->tanggal_masuk)->translatedFormat('d F Y') }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $ayam->jumlah_ayam }} ekor</td>
                        <td class="px-4 py-3">
                            @if($ayam->status == 'aktif')
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-700">Keluar/Afkir</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-500">
                            {{ $ayam->tanggal_keluar ? \Carbon\Carbon::parse($ayam->tanggal_keluar)->translatedFormat('d F Y') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada riwayat ayam di kandang ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
