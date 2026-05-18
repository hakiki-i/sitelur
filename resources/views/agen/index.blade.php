@extends('layouts.app')

@section('title', 'Data Agen')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Agen</h2>
            <p class="text-sm text-gray-400 mt-0.5">Manajemen data agen penjualan</p>
        </div>
        <a href="{{ route('agen.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-xl shadow-md hover:from-blue-700 hover:to-indigo-700 hover:-translate-y-0.5 transition-all duration-200">
            <i class="fas fa-plus text-xs"></i> Tambah Agen
        </a>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 px-4 py-3 mb-5 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl text-sm">
            <i class="fas fa-check-circle text-blue-500"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-store text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Daftar Agen</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Nama Agen</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Nomor HP</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Alamat</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Total Hutang</th>
                        <th class="px-4 py-3 text-center font-semibold text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($agens as $a)
                    <tr class="hover:bg-blue-50/40 transition-colors duration-150">
                        <td class="px-4 py-3 text-gray-500 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $a->nama_agen }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $a->nomor_hp ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-500 max-w-xs truncate">{{ $a->alamat ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if($a->total_hutang > 0)
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold bg-red-100 text-red-700">
                                    Rp {{ number_format($a->total_hutang, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold bg-green-100 text-green-700">
                                    Lunas
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('agen.riwayat', $a->id) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-lg hover:bg-blue-200 transition-colors">
                                    <i class="fas fa-history text-xs"></i> Riwayat
                                </a>
                                <a href="{{ route('agen.edit', $a->id) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-100 text-amber-700 text-xs font-semibold rounded-lg hover:bg-amber-200 transition-colors">
                                    <i class="fas fa-pen text-xs"></i> Edit
                                </a>
                                <form action="{{ route('agen.destroy', $a->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Yakin hapus data ini?')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded-lg hover:bg-red-200 transition-colors">
                                        <i class="fas fa-trash text-xs"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-50 flex items-center justify-between">
            <form method="get" class="flex items-center gap-2 text-sm text-gray-500">
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
                {!! $agens->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>
@endsection
