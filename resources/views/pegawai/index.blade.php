@extends('layouts.app')

@section('title', 'Data Pegawai')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Pegawai</h2>
            <p class="text-sm text-gray-400 mt-0.5">Manajemen data pegawai peternakan</p>
        </div>
        <a href="{{ route('pegawai.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-xl shadow-md hover:from-blue-700 hover:to-indigo-700 hover:-translate-y-0.5 transition-all duration-200">
            <i class="fas fa-plus text-xs"></i> Tambah Pegawai
        </a>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-users text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Daftar Pegawai</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Nama Pegawai & Email</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Role</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">No HP</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Alamat</th>
                        <th class="px-4 py-3 text-center font-semibold text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($pegawai as $p)
                    <tr class="hover:bg-blue-50/40 transition-colors duration-150">
                        <td class="px-4 py-3 text-gray-500 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($p->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-800 block leading-tight">{{ $p->nama }}</span>
                                    @if($p->user)
                                        <span class="text-xs text-gray-400 block mt-0.5">{{ $p->user->email }}</span>
                                    @else
                                        <span class="text-xs text-red-400 block mt-0.5">Belum ada akun</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @if($p->user)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100 uppercase tracking-wide">
                                    {{ $p->user->role }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $p->no_hp }}</td>
                        <td class="px-4 py-3 text-gray-500 max-w-xs truncate">{{ $p->alamat }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('pegawai.edit', $p->id_pegawai ?? $p->id) }}"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-100 text-amber-700 text-xs font-semibold rounded-lg hover:bg-amber-200 transition-colors">
                                    <i class="fas fa-pen text-xs"></i> Edit
                                </a>
                                <form action="{{ route('pegawai.destroy', $p->id_pegawai ?? $p->id) }}" method="POST" class="inline">
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

        {{-- Pagination --}}
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
                {!! $pegawai->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>
@endsection
