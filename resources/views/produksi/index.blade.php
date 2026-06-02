@extends('layouts.app')

@section('title', 'Data Produksi')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="mb-2 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Produksi</h2>
            <p class="text-sm text-gray-400 mt-0.5">Monitoring produksi telur harian, mingguan, dan bulanan</p>
        </div>
        <a href="{{ route('pengaturan.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-blue-100 text-blue-600 text-sm font-semibold rounded-xl hover:bg-blue-50 transition-colors shadow-sm">
            <i class="fas fa-cog"></i>
            <span>Konversi: 1 kg = {{ $butirPerKg }} butir</span>
        </a>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-5 text-white shadow-md">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fas fa-sun text-yellow-200"></i>
                </div>
                <span class="text-xs font-semibold uppercase tracking-widest text-blue-200">Produksi Hari Ini</span>
            </div>
            <div class="text-3xl font-extrabold">{{ number_format($produksiHarian, 0, ',', '.') }}</div>
            <div class="text-xs text-blue-200 mt-1">butir telur (~{{ number_format($produksiHarian / $butirPerKg, 2, ',', '.') }} kg)</div>
        </div>
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-2xl p-5 text-white shadow-md">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fas fa-calendar-week text-indigo-200"></i>
                </div>
                <span class="text-xs font-semibold uppercase tracking-widest text-indigo-200">Produksi Mingguan</span>
            </div>
            <div class="text-3xl font-extrabold">{{ number_format($produksiMingguan, 0, ',', '.') }}</div>
            <div class="text-xs text-indigo-200 mt-1">butir telur (~{{ number_format($produksiMingguan / $butirPerKg, 2, ',', '.') }} kg)</div>
        </div>
        <div class="bg-gradient-to-br from-violet-500 to-violet-700 rounded-2xl p-5 text-white shadow-md">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fas fa-calendar-days text-violet-200"></i>
                </div>
                <span class="text-xs font-semibold uppercase tracking-widest text-violet-200">Produksi Bulanan</span>
            </div>
            <div class="text-3xl font-extrabold">{{ number_format($produksiBulanan, 0, ',', '.') }}</div>
            <div class="text-xs text-violet-200 mt-1">butir telur (~{{ number_format($produksiBulanan / $butirPerKg, 2, ',', '.') }} kg)</div>
        </div>
    </div>

    {{-- Tabel Produksi --}}
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-egg text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Daftar Produksi Terbaru</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Kandang</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Jumlah Telur</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Telur Layak</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Tidak Layak</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-center font-semibold text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="produksi-table-body" class="divide-y divide-gray-50">
                    @foreach($listProduksi as $produksi)
                    <tr class="hover:bg-blue-50/40 transition-colors duration-150">
                        <td class="px-4 py-3 text-gray-600">{{ $produksi->tanggal }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-medium">
                                <i class="fas fa-warehouse text-xs"></i>
                                {{ $produksi->kandang->nama_kandang ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-bold text-gray-800">
                            {{ number_format($produksi->jumlah, 0, ',', '.') }}
                            <span class="block text-xs font-normal text-gray-400">{{ number_format($produksi->jumlah / $butirPerKg, 2, ',', '.') }} kg</span>
                        </td>
                        <td class="px-4 py-3 text-blue-700 font-semibold">
                            {{ number_format($produksi->telur_layak ?? 0, 0, ',', '.') }}
                            <span class="block text-xs font-normal text-blue-400">{{ number_format(($produksi->telur_layak ?? 0) / $butirPerKg, 2, ',', '.') }} kg</span>
                        </td>
                        <td class="px-4 py-3 text-red-600 font-semibold">
                            {{ number_format($produksi->telur_tidak_layak ?? 0, 0, ',', '.') }}
                            <span class="block text-xs font-normal text-red-400">{{ number_format(($produksi->telur_tidak_layak ?? 0) / $butirPerKg, 2, ',', '.') }} kg</span>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $statusColor = match($produksi->status) {
                                    'final','approved' => 'bg-blue-100 text-blue-700',
                                    'draft' => 'bg-amber-100 text-amber-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-600',
                                };
                            @endphp
                            <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $statusColor }}">
                                {{ ucfirst($produksi->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                @if($produksi->status != 'final' && $produksi->status != 'approved' && $produksi->status != 'rejected')
                                    <form method="POST" action="{{ route('produksi.validasi', $produksi->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Setujui data produksi ini?')"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-lg hover:bg-blue-200 transition-colors">
                                            <i class="fas fa-check text-xs"></i> Approved
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('produksi.reject', $produksi->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Tolak data produksi ini?')"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-lg hover:bg-red-200 transition-colors">
                                            <i class="fas fa-times text-xs"></i> Rejected
                                        </button>
                                    </form>
                                @elseif($produksi->status == 'approved' || $produksi->status == 'final')
                                    <span class="text-xs text-blue-600 font-semibold">✓ Approved</span>
                                @elseif($produksi->status == 'rejected')
                                    <span class="text-xs text-red-600 font-semibold">✗ Rejected</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-50 flex items-center justify-between">
            <form method="get" class="flex items-center gap-2 text-sm text-gray-500">
                <span>Tampil</span>
                <select name="perPage" onchange="this.form.submit()"
                    class="border border-gray-200 rounded-lg px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <option value="10" {{ request('perPage', 25) == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('perPage', 25) == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('perPage', 25) == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('perPage', 25) == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span>data</span>
            </form>
            <div>{!! $listProduksi->links('pagination::bootstrap-5') !!}</div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const BPK = {{ $butirPerKg }}; // butir per kg (dari pengaturan)

function fetchProduksiTable() {
    fetch('/api/produksi', { headers: { 'Accept': 'application/json' } })
    .then(r => r.json())
    .then(data => {
        let tbody = '';
        data.forEach(function(p) {
            const sc = p.status === 'final' || p.status === 'approved' ? 'bg-blue-100 text-blue-700'
                : (p.status === 'draft' ? 'bg-amber-100 text-amber-700'
                : (p.status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600'));
            tbody += `<tr class="hover:bg-blue-50/40 transition-colors">
                <td class="px-4 py-3 text-gray-600">${p.tanggal}</td>
                <td class="px-4 py-3"><span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-medium">${p.kandang ? p.kandang.nama_kandang : '-'}</span></td>
                <td class="px-4 py-3 font-bold text-gray-800">
                    ${new Intl.NumberFormat('id-ID').format(p.jumlah)}
                    <span class="block text-xs font-normal text-gray-400">${(p.jumlah / BPK).toFixed(2).replace('.', ',')} kg</span>
                </td>
                <td class="px-4 py-3 text-blue-700 font-semibold">
                    ${p.telur_layak ? new Intl.NumberFormat('id-ID').format(p.telur_layak) : '-'}
                    <span class="block text-xs font-normal text-blue-400">${p.telur_layak ? (p.telur_layak / BPK).toFixed(2).replace('.', ',') + ' kg' : ''}</span>
                </td>
                <td class="px-4 py-3 text-red-600 font-semibold">
                    ${p.telur_tidak_layak ? new Intl.NumberFormat('id-ID').format(p.telur_tidak_layak) : '-'}
                    <span class="block text-xs font-normal text-red-400">${p.telur_tidak_layak ? (p.telur_tidak_layak / BPK).toFixed(2).replace('.', ',') + ' kg' : ''}</span>
                </td>
                <td class="px-4 py-3"><span class="px-2.5 py-1 rounded-lg text-xs font-semibold ${sc}">${p.status.charAt(0).toUpperCase() + p.status.slice(1)}</span></td>
                <td class="px-4 py-3 text-center text-xs text-gray-400">-</td>
            </tr>`;
        });
        document.querySelector('#produksi-table-body').innerHTML = tbody;
    });
}
setInterval(fetchProduksiTable, 2000);
window.addEventListener('DOMContentLoaded', fetchProduksiTable);
</script>
@endpush
@endsection
