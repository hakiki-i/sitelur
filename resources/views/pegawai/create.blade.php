@extends('layouts.app')

@section('title', 'Tambah Pegawai')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pegawai.index') }}"
            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-blue-100 text-blue-600 hover:bg-blue-50 transition-colors shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Tambah Pegawai</h2>
            <p class="text-sm text-gray-400 mt-0.5">Masukkan data pegawai baru</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-2">
            <i class="fas fa-user-plus text-blue-500 text-sm"></i>
            <span class="font-semibold text-gray-700">Form Tambah Pegawai</span>
        </div>
        <div class="p-6">
            <form action="{{ route('pegawai.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="nama" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Nama Pegawai</label>
                    <input type="text" name="nama" id="nama" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                </div>
                <div>
                    <label for="no_hp" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                </div>
                <div>
                    <label for="alamat" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200 resize-none"></textarea>
                </div>

                {{-- Akun Login Pegawai --}}
                <div class="border-t border-gray-100 pt-5 space-y-4">
                    <h4 class="text-sm font-bold text-blue-600 mb-1 flex items-center gap-2">
                        <i class="fas fa-key text-xs"></i> Akun Login Pegawai
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Email (@gmail.com)</label>
                            <input type="email" name="email" id="email" required placeholder="email@gmail.com"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                            @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="role" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Role / Peran</label>
                            <select name="role" id="role" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                                <option value="peternak" selected>Peternak</option>
                                <option value="owner">Owner</option>
                            </select>
                            @error('role')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label for="password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Password</label>
                        <input type="password" name="password" id="password" required placeholder="Masukkan password login" minlength="8"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                        @error('password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-md hover:-translate-y-0.5 transition-all duration-200 text-sm">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                    <a href="{{ route('pegawai.index') }}"
                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-xl transition-colors text-sm flex items-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
