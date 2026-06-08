@extends('layouts.landing')

@section('content')
<div class="min-h-screen flex items-center justify-center"
    style="background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 45%, #4f46e5 100%);">

    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-indigo-400/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md mx-auto px-4 py-8">
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl shadow-blue-900/30 overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-blue-500 via-indigo-500 to-violet-500"></div>
            <div class="p-8">
                {{-- Logo --}}
                <div class="text-center mb-7">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg shadow-blue-300 mb-4">
                        <i class="fas fa-egg text-yellow-300 text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">Tambah Akun Baru</h2>
                    <p class="text-sm text-gray-400 mt-1">SIM Ayam Petelur — Daftarkan pengguna baru</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    {{-- Nama --}}
                    <div>
                        <label for="name" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-blue-400">
                                <i class="fas fa-user text-sm"></i>
                            </span>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                placeholder="Masukkan nama Anda"
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all">
                        </div>
                        @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Email</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-blue-400">
                                <i class="fas fa-envelope text-sm"></i>
                            </span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                placeholder="Masukkan email @gmail.com"
                                oninput="validateGmail(this)"
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all">
                        </div>
                        <div id="gmail-warning" class="hidden mt-1.5 text-xs text-red-500 items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> Domain harus @gmail.com
                        </div>
                        @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- Role --}}
                    <div>
                        <label for="role" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Role Pengguna</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-blue-400">
                                <i class="fas fa-user-tag text-sm"></i>
                            </span>
                            <select id="role" name="role" required
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all">
                                <option value="peternak">Peternak (Default)</option>
                                <option value="owner">Owner</option>
                            </select>
                        </div>
                        @error('role')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Password</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-blue-400">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            <input id="password" type="password" name="password" required
                                placeholder="Buat password"
                                class="w-full pl-10 pr-12 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all">
                            <button type="button" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-500 transition-colors"
                                onclick="togglePassword('password', this)">
                                <i class="fa fa-eye text-sm"></i>
                            </button>
                        </div>
                        @error('password')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Konfirmasi Password</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-blue-400">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                placeholder="Ulangi password"
                                class="w-full pl-10 pr-12 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all">
                            <button type="button" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-500 transition-colors"
                                onclick="togglePassword('password_confirmation', this)">
                                <i class="fa fa-eye text-sm"></i>
                            </button>
                        </div>
                        @error('password_confirmation')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-blue-300 hover:-translate-y-0.5 transition-all text-sm mt-2 flex items-center justify-center gap-2">
                        <i class="fas fa-user-plus"></i> Tambah Akun
                    </button>

                    <a href="/"
                        class="w-full py-2.5 flex items-center justify-center gap-2 text-sm text-gray-500 hover:text-blue-600 font-medium transition-colors rounded-xl hover:bg-blue-50 border border-transparent hover:border-blue-100">
                        <i class="fas fa-arrow-left text-xs"></i> Batal & Kembali
                    </a>
                </form>

                <div class="mt-5 pt-5 border-t border-gray-100 text-center">
                    <span class="text-xs text-gray-400">Sudah punya akun?</span>
                    <a href="{{ route('login') }}" class="text-xs text-blue-600 font-bold hover:text-blue-800 ml-1">Masuk di sini</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function validateGmail(input) {
    const w = document.getElementById('gmail-warning');
    if (input.value && !input.value.endsWith('@gmail.com')) { w.classList.remove('hidden'); }
    else { w.classList.add('hidden'); }
}
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');
    if (input.type === 'password') { input.type = 'text'; icon.classList.replace('fa-eye','fa-eye-slash'); }
    else { input.type = 'password'; icon.classList.replace('fa-eye-slash','fa-eye'); }
}
</script>
@endsection
