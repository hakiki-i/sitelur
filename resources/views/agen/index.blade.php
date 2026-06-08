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

    <!-- Pemisah -->
    <hr class="my-8 border-gray-200">

    {{-- Tabel Daftar Calon Agen Baru --}}
    <div class="mt-8 bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2 bg-gradient-to-r from-emerald-50 to-teal-50">
            <i class="fas fa-user-plus text-emerald-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Daftar Calon Agen Baru</span>
            <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                Kriteria Rutin
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-emerald-600 text-white">
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider w-16">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Nama Calon Agen</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Total Transaksi (30 Hari Terakhir)</th>
                        <th class="px-4 py-3 text-center font-semibold text-xs uppercase tracking-wider w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($calonAgens as $calon)
                    <tr class="hover:bg-emerald-50/40 transition-colors duration-150">
                        <td class="px-4 py-3 text-gray-500 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $calon->pembeli }}</td>
                        <td class="px-4 py-3 text-gray-600">
                            <span class="inline-flex px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg font-bold text-xs">
                                <i class="fas fa-shopping-basket mr-1.5 mt-0.5"></i> {{ $calon->total_transaksi }}x Pembelian (&ge; 10 kg)
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center">
                                <button type="button"
                                    onclick="openPromoteModal('{{ addslashes($calon->pembeli) }}')"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-lg hover:bg-emerald-200 transition-colors">
                                    <i class="fas fa-award text-xs"></i> Promosikan Jadi Agen
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                            Tidak ada calon agen baru yang memenuhi kriteria rutinitas pembelian (minimal 15x transaksi dalam 30 hari terakhir dengan jumlah masing-masing &ge; 10 kg).
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pemisah -->
    <hr class="my-8 border-gray-200">

    {{-- Tabel Monitoring Pembeli Umum (Lainnya) untuk Diagnostik --}}
    <div class="mt-8 bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2 bg-gradient-to-r from-blue-50 to-indigo-50">
            <i class="fas fa-chart-line text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Aktivitas & Kualifikasi Pembeli Umum (30 Hari Terakhir)</span>
            <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 uppercase tracking-wider">
                Monitoring
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider w-16">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Nama Pembeli</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Total Transaksi</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Transaksi Layak (&ge; 10 kg)</th>
                        <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wider">Status / Kekurangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($monitorPembelis as $mon)
                    <tr class="hover:bg-blue-50/40 transition-colors duration-150">
                        <td class="px-4 py-3 text-gray-500 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $mon->pembeli }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $mon->total_transaksi }} kali</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex px-2.5 py-1 {{ $mon->transaksi_layak >= 15 ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }} rounded-lg font-bold text-xs">
                                {{ $mon->transaksi_layak }} kali
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if ($mon->transaksi_layak >= 15)
                                <span class="inline-flex items-center gap-1 text-emerald-600 font-semibold text-xs">
                                    <i class="fas fa-check-circle"></i> Memenuhi syarat promosi!
                                </span>
                            @else
                                <span class="text-gray-500 text-xs">
                                    Kurang <strong class="text-amber-600">{{ 15 - $mon->transaksi_layak }}</strong> transaksi layak (&ge; 10 kg)
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                            Tidak ada aktivitas transaksi pembeli umum (Lainnya) dalam 30 hari terakhir.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Promosi Calon Agen --}}
<div id="promoteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closePromoteModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="sm:flex sm:items-start">
                <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-emerald-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                    <i class="fas fa-award text-emerald-600"></i>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                    <h3 class="text-lg font-bold text-gray-900" id="modal-title">
                        Promosikan Calon Agen
                    </h3>
                    <div class="mt-1 mb-4">
                        <p class="text-xs text-gray-400">
                            Masukkan data tambahan untuk mempromosikan pembeli umum menjadi agen resmi.
                        </p>
                    </div>
                    <form id="modal-form-promote" action="{{ route('agen.promosikan') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Nama Calon Agen</label>
                            <input type="text" id="modal-display-name" disabled
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-100 text-sm text-gray-500 font-semibold focus:outline-none">
                            <input type="hidden" name="nama_agen" id="modal-input-name">
                        </div>
                        <div>
                            <label for="modal-input-hp" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Nomor HP</label>
                            <input type="text" name="nomor_hp" id="modal-input-hp" placeholder="Contoh: 08123456789"
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent focus:bg-white transition-all duration-200">
                        </div>
                        <div>
                            <label for="modal-input-alamat" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Alamat Lengkap</label>
                            <textarea name="alamat" id="modal-input-alamat" rows="3" placeholder="Masukkan alamat lengkap..."
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent focus:bg-white transition-all duration-200"></textarea>
                        </div>
                        <div class="pt-2 sm:flex sm:flex-row-reverse gap-2">
                            <button type="submit"
                                class="inline-flex justify-center w-full px-4 py-2.5 text-sm font-semibold text-white bg-emerald-600 border border-transparent rounded-xl shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:w-auto">
                                Promosikan Sekarang
                            </button>
                            <button type="button" onclick="closePromoteModal()"
                                class="inline-flex justify-center w-full px-4 py-2.5 mt-3 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:w-auto">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const promoteModal = document.getElementById('promoteModal');
    const modalDisplayName = document.getElementById('modal-display-name');
    const modalInputName = document.getElementById('modal-input-name');
    const modalInputHp = document.getElementById('modal-input-hp');
    const modalInputAlamat = document.getElementById('modal-input-alamat');

    function openPromoteModal(name) {
        modalDisplayName.value = name;
        modalInputName.value = name;
        modalInputHp.value = '';
        modalInputAlamat.value = '';
        promoteModal.classList.remove('hidden');
        setTimeout(() => modalInputHp.focus(), 100);
    }

    function closePromoteModal() {
        promoteModal.classList.add('hidden');
    }
</script>
@endpush
