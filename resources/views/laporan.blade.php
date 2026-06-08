@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="max-w-6xl mx-auto space-y-5">

    {{-- Page Header --}}
    <div class="mb-2">
        <h2 class="text-2xl font-bold text-gray-800">Laporan {{ $filter == 'produksi' ? 'Produksi' : 'Penjualan' }}</h2>
        <p class="text-sm text-gray-400 mt-0.5">Riwayat {{ $filter == 'produksi' ? 'produksi' : 'penjualan' }} telur ayam</p>
    </div>

    {{-- Filter Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 p-5">
        <div class="flex flex-col lg:flex-row items-end gap-4">
            {{-- Filter Form --}}
            <form method="GET" action="" class="flex flex-col sm:flex-row items-end gap-3 flex-1">
                <input type="hidden" name="filter_jenis" value="{{ $filter }}">
                @if($filter == 'penjualan')
                <div class="w-full sm:w-auto">
                    <label for="jenis_telur" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Jenis Telur</label>
                    <select name="jenis_telur" id="jenis_telur"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all">
                        <option value="">Semua Jenis</option>
                        <option value="layak" {{ request('jenis_telur') == 'layak' ? 'selected' : '' }}>Grade A</option>
                        <option value="tidak_layak" {{ request('jenis_telur') == 'tidak_layak' ? 'selected' : '' }}>Grade B</option>
                    </select>
                </div>
                <div class="w-full sm:w-auto">
                    <label for="jenis_pembeli" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Jenis Pembeli</label>
                    <select name="jenis_pembeli" id="jenis_pembeli"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all">
                        <option value="">Semua Pembeli</option>
                        <option value="Agen" {{ request('jenis_pembeli') == 'Agen' ? 'selected' : '' }}>Agen</option>
                        <option value="Lainnya" {{ request('jenis_pembeli') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                @endif
                @if($filter == 'produksi')
                <div class="w-full sm:w-auto">
                    <label for="id_kandang" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Pilih Kandang</label>
                    <select name="id_kandang" id="id_kandang"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all">
                        <option value="">Semua Kandang</option>
                        @foreach($kandangs as $k)
                            <option value="{{ $k->id }}" {{ request('id_kandang') == $k->id ? 'selected' : '' }}>{{ $k->nama_kandang }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="w-full sm:w-auto">
                    <label for="tanggal_mulai" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Mulai Tanggal</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all">
                </div>
                <div class="w-full sm:w-auto">
                    <label for="tanggal_selesai" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ request('tanggal_selesai') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition-all">
                </div>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-700 hover:-translate-y-0.5 transition-all shadow-md">
                    <i class="fas fa-filter text-xs"></i> Filter Tanggal
                </button>
            </form>

            {{-- Export Buttons --}}
            <div class="flex items-center gap-2">
                <form method="GET" action="{{ route('laporan.export', ['type' => 'excel']) }}" class="inline">
                    <input type="hidden" name="filter_jenis" value="{{ request('filter_jenis') }}">
                    <input type="hidden" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                    <input type="hidden" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
                    <input type="hidden" name="jenis_telur" value="{{ request('jenis_telur') }}">
                    <input type="hidden" name="jenis_pembeli" value="{{ request('jenis_pembeli') }}">
                    <input type="hidden" name="id_kandang" value="{{ request('id_kandang') }}">
                    <input type="hidden" name="perPage" value="{{ request('perPage', 25) }}">
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-100 text-emerald-700 text-sm font-semibold rounded-xl hover:bg-emerald-200 transition-colors">
                        <i class="fas fa-file-excel text-xs"></i> Excel
                    </button>
                </form>
                <form method="GET" action="{{ route('laporan.export', ['type' => 'pdf']) }}" class="inline">
                    <input type="hidden" name="filter_jenis" value="{{ request('filter_jenis') }}">
                    <input type="hidden" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                    <input type="hidden" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
                    <input type="hidden" name="jenis_telur" value="{{ request('jenis_telur') }}">
                    <input type="hidden" name="jenis_pembeli" value="{{ request('jenis_pembeli') }}">
                    <input type="hidden" name="id_kandang" value="{{ request('id_kandang') }}">
                    <input type="hidden" name="perPage" value="{{ request('perPage', 25) }}">
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-red-100 text-red-600 text-sm font-semibold rounded-xl hover:bg-red-200 transition-colors">
                        <i class="fas fa-file-pdf text-xs"></i> PDF
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            @if($filter == 'produksi')
                <i class="fas fa-egg text-blue-500 text-sm"></i>
                <span class="font-semibold text-gray-700">Riwayat Produksi</span>
            @else
                <i class="fas fa-shopping-cart text-blue-500 text-sm"></i>
                <span class="font-semibold text-gray-700">Riwayat Penjualan</span>
            @endif
        </div>

        <div class="overflow-x-auto">
            @if($filter == 'produksi')
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Kandang</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Grade A (Btr)</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Grade B (Btr)</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Total Produksi</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($data as $row)
                    <tr class="hover:bg-blue-50/40 transition-colors">
                        <td class="px-4 py-3 text-gray-600">{{ $row->tanggal }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-medium">
                                <i class="fas fa-warehouse text-xs"></i> {{ $row->kandang->nama_kandang ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-semibold text-blue-700">
                            {{ number_format($row->telur_layak, 0, ',', '.') }} butir
                            <span class="block text-xs font-normal text-blue-400">~{{ number_format(($row->telur_layak ?? 0) / \App\Models\Pengaturan::butirPerKg(), 2, ',', '.') }} kg</span>
                        </td>
                        <td class="px-4 py-3 font-semibold text-amber-600">
                            {{ number_format($row->telur_tidak_layak, 0, ',', '.') }} butir
                            <span class="block text-xs font-normal text-amber-500">~{{ number_format(($row->telur_tidak_layak ?? 0) / \App\Models\Pengaturan::butirPerKg(), 2, ',', '.') }} kg</span>
                        </td>
                        <td class="px-4 py-3 font-bold text-gray-800">
                            {{ number_format($row->jumlah, 0, ',', '.') }} butir
                            <span class="block text-xs font-normal text-gray-400">~{{ number_format(($row->jumlah ?? 0) / \App\Models\Pengaturan::butirPerKg(), 2, ',', '.') }} kg</span>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $sc = match($row->status) {
                                    'final','approved' => 'bg-blue-100 text-blue-700',
                                    'draft' => 'bg-amber-100 text-amber-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-600',
                                };
                            @endphp
                            <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $sc }}">
                                {{ ucfirst($row->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Pembeli</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Jenis Telur</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Jumlah (kg)</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Harga/Kilo</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Total</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($data as $row)
                    <tr class="hover:bg-blue-50/40 transition-colors">
                        <td class="px-4 py-3 text-gray-600">
                            <div>{{ $row->tanggal }}</div>
                            @if($row->is_po)
                                <div class="text-[10px] text-amber-600 font-semibold mt-0.5">
                                    <i class="fas fa-calendar-alt"></i> PO Ambil: {{ \Carbon\Carbon::parse($row->tanggal_ambil)->format('d/m/Y') }}
                                    @if($row->status_po === 'pending')
                                        <span class="text-red-500 font-bold">(Pending)</span>
                                    @else
                                        <span class="text-blue-500 font-bold">(Selesai)</span>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $row->pembeli }}</td>
                        <td class="px-4 py-3">
                            @if($row->jenis_telur === 'keduanya')
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-100 text-blue-700">
                                    Grade A + B
                                </span>
                            @else
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold
                                    {{ $row->jenis_telur == 'layak' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $row->jenis_telur == 'layak' ? 'Grade A' : 'Grade B' }}
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-700">
                            @if($row->jenis_telur === 'keduanya')
                                <div class="text-xs"><span class="font-bold text-emerald-600">A:</span> {{ $row->jumlah }} kg</div>
                                <div class="text-xs"><span class="font-bold text-amber-600">B:</span> {{ $row->jumlah_b }} kg</div>
                            @else
                                {{ $row->jumlah }} kg
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-700">
                            @if($row->jenis_telur === 'keduanya')
                                <div class="text-xs">Rp {{ number_format($row->harga_perkilo,0,',','.') }}</div>
                                <div class="text-xs">Rp {{ number_format($row->harga_perkilo_b,0,',','.') }}</div>
                            @else
                                Rp {{ number_format($row->harga_perkilo,0,',','.') }}
                            @endif
                        </td>
                        <td class="px-4 py-3 font-bold text-blue-700">
                            Rp {{ number_format(($row->total + ($row->total_b ?? 0)), 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-gray-500 max-w-xs truncate">{{ $row->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @endif
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-50 flex items-center justify-between">
            <form method="GET" action="" class="flex items-center gap-2 text-sm text-gray-500">
                <input type="hidden" name="filter_jenis" value="{{ request('filter_jenis') }}">
                <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                <input type="hidden" name="jenis_telur" value="{{ request('jenis_telur') }}">
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
            <div>{!! $data->withQueryString()->links('pagination::bootstrap-5') !!}</div>
        </div>
    </div>
</div>
@endsection
