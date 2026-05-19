@extends('layouts.app')

@section('title', 'Data Ayam')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Ayam</h2>
            <p class="text-sm text-gray-400 mt-0.5">Manajemen data ayam petelur</p>
        </div>
        <a href="{{ route('ayam.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-xl shadow-md hover:from-blue-700 hover:to-indigo-700 hover:-translate-y-0.5 transition-all duration-200">
            <i class="fas fa-plus text-xs"></i> Tambah Ayam
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-4 py-3 mb-5 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl text-sm">
            <i class="fas fa-check-circle text-blue-500"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl p-5 text-white shadow-md">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fas fa-arrow-up text-blue-100"></i>
                </div>
                <span class="text-xs font-semibold uppercase tracking-widest text-blue-100">Puncak Produktif</span>
            </div>
            <div class="text-3xl font-extrabold">{{ $countPuncak }} <span class="text-sm font-normal text-blue-200">kelompok</span></div>
            <div class="text-xs text-blue-200 mt-1">Umur 20 - 30 minggu</div>
        </div>
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl p-5 text-white shadow-md">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fas fa-check text-emerald-100"></i>
                </div>
                <span class="text-xs font-semibold uppercase tracking-widest text-emerald-100">Produksi Stabil</span>
            </div>
            <div class="text-3xl font-extrabold">{{ $countStabil }} <span class="text-sm font-normal text-emerald-200">kelompok</span></div>
            <div class="text-xs text-emerald-200 mt-1">Umur 31 - 79 minggu</div>
        </div>
        <div class="bg-gradient-to-br from-amber-500 to-amber-700 rounded-2xl p-5 text-white shadow-md">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fas fa-arrow-down text-amber-100"></i>
                </div>
                <span class="text-xs font-semibold uppercase tracking-widest text-amber-100">Produksi Turun</span>
            </div>
            <div class="text-3xl font-extrabold">{{ $countTurun }} <span class="text-sm font-normal text-amber-200">kelompok</span></div>
            <div class="text-xs text-amber-200 mt-1">Umur > 80 minggu</div>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 p-5 mb-5">
        <form method="GET" action="" class="flex flex-col sm:flex-row items-end gap-3">
            <div class="w-full sm:w-auto flex-1 max-w-xs">
                <label for="status_produktif" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Filter Status Produktif</label>
                <select name="status_produktif" id="status_produktif"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all">
                    <option value="">Semua Status</option>
                    <option value="puncak" {{ request('status_produktif') == 'puncak' ? 'selected' : '' }}>Puncak Produktif (20-30 minggu)</option>
                    <option value="stabil" {{ request('status_produktif') == 'stabil' ? 'selected' : '' }}>Produksi Stabil (31-79 minggu)</option>
                    <option value="turun" {{ request('status_produktif') == 'turun' ? 'selected' : '' }}>Produksi Turun (> 80 minggu)</option>
                </select>
            </div>
            <div class="w-full sm:w-auto flex-1 max-w-xs">
                <label for="bulan_masuk" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Filter Bulan Masuk</label>
                <input type="month" name="bulan_masuk" id="bulan_masuk" value="{{ request('bulan_masuk') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all">
            </div>
            <button type="submit"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-700 hover:-translate-y-0.5 transition-all shadow-md">
                <i class="fas fa-filter text-xs"></i> Terapkan Filter
            </button>
        </form>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-drumstick-bite text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Daftar Ayam</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Kandang</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Jumlah Ayam</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Tanggal Masuk</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Umur</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Status Produktif</th>
                        <th class="px-4 py-3 text-center font-semibold text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($ayam as $a)
                    <tr class="hover:bg-blue-50/40 transition-colors duration-150">
                        <td class="px-4 py-3 text-gray-500 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-medium">
                                <i class="fas fa-warehouse text-xs"></i>
                                {{ $a->kandang->nama_kandang ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-800 font-bold">{{ $a->jumlah_ayam }} ekor</td>
                        <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($a->tanggal_masuk)->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-gray-600 font-semibold">
                            @php
                                $tanggal_masuk = \Carbon\Carbon::parse($a->tanggal_masuk);
                                $now = \Carbon\Carbon::now();
                                $totalDays = 140 + $tanggal_masuk->diffInDays($now);
                                $umurMinggu = floor($totalDays / 7);
                                $sisaHari = $totalDays % 7;
                                
                                $teksUmur = $umurMinggu . ' minggu';
                                if ($sisaHari > 0) {
                                    $teksUmur .= ' ' . $sisaHari . ' hari';
                                }
                                echo $teksUmur;
                            @endphp
                        </td>
                        <td class="px-4 py-3">
                            @php
                                if ($umurMinggu >= 20 && $umurMinggu <= 30) {
                                    echo '<span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-700">Puncak Produktif</span>';
                                } elseif ($umurMinggu >= 31 && $umurMinggu <= 79) {
                                    echo '<span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-100 text-emerald-700">Produksi Stabil</span>';
                                } elseif ($umurMinggu >= 80) {
                                    echo '<span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-100 text-amber-700">Produksi Turun</span>';
                                }
                            @endphp
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('ayam.keluar', $a->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        onclick="return confirm('Keluarkan kelompok ayam ini dari kandang?')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                                        <i class="fas fa-sign-out-alt text-xs"></i> Keluar
                                    </button>
                                </form>
                                <a href="{{ route('ayam.edit', $a->id) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-100 text-amber-700 text-xs font-semibold rounded-lg hover:bg-amber-200 transition-colors">
                                    <i class="fas fa-pen text-xs"></i> Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-400">Tidak ada data ayam.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-50 flex items-center justify-between">
            <form method="get" action="" class="flex items-center gap-2 text-sm text-gray-500">
                <input type="hidden" name="status_produktif" value="{{ request('status_produktif') }}">
                <input type="hidden" name="bulan_masuk" value="{{ request('bulan_masuk') }}">
                <span>Tampil</span>
                <select name="perPage" onchange="this.form.submit()"
                    class="border border-gray-200 rounded-lg px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="10" {{ request('perPage', $perPage??25)==10?'selected':'' }}>10</option>
                    <option value="25" {{ request('perPage', $perPage??25)==25?'selected':'' }}>25</option>
                    <option value="50" {{ request('perPage', $perPage??25)==50?'selected':'' }}>50</option>
                    <option value="100" {{ request('perPage', $perPage??25)==100?'selected':'' }}>100</option>
                </select>
                <span>data</span>
            </form>
            <div>
                {!! $ayam->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>
@endsection
