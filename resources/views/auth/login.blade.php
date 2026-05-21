@extends('layouts.landing')

@section('content')
<div class="min-h-screen flex items-center justify-center"
    style="background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 45%, #4f46e5 100%);">

    <!-- Decorative blobs -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-indigo-400/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/4 w-64 h-64 bg-blue-300/5 rounded-full blur-2xl"></div>
    </div>

    <div class="relative w-full max-w-md mx-auto px-4">
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl shadow-blue-900/30 overflow-hidden">

            <!-- Top gradient bar -->
            <div class="h-1.5 bg-gradient-to-r from-blue-500 via-indigo-500 to-violet-500"></div>

            <div class="p-8">
                <!-- Logo & Title -->
                <div class="text-center mb-7">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg shadow-blue-300 mb-4">
                        <i class="fas fa-egg text-yellow-300 text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">Selamat Datang</h2>
                    <p class="text-sm text-gray-400 mt-1">SIM Ayam Petelur — Masuk ke akun Anda</p>
                </div>

                @if(session('status'))
                    <div class="mb-4 px-4 py-3 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 text-sm flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Email</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-blue-400">
                                <i class="fas fa-envelope text-sm"></i>
                            </span>
                            <input id="email" type="email" name="email"
                                value="{{ old('email') }}" required autofocus autocomplete="username"
                                placeholder="Masukkan email @gmail.com"
                                oninput="validateGmailLogin(this)"
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                        </div>
                        <div id="gmail-warning-login" class="hidden mt-1.5 text-xs text-red-500 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> Domain harus @gmail.com
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5">Password</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-blue-400">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            <input id="password" type="password" name="password"
                                required autocomplete="current-password"
                                placeholder="Masukkan password"
                                class="w-full pl-10 pr-12 py-3 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent focus:bg-white transition-all duration-200">
                            <button type="button" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-500 transition-colors"
                                onclick="togglePassword('password', this)">
                                <i class="fa fa-eye text-sm"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-400">
                            <span class="text-xs text-gray-500">Ingat saya</span>
                        </label>
                        <!-- Lupa password dihapus -->
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full py-3 px-6 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-blue-300 hover:shadow-blue-400 transition-all duration-200 hover:-translate-y-0.5 flex items-center justify-center gap-2 text-sm">
                        <i class="fas fa-sign-in-alt"></i>
                        Masuk ke Dashboard
                    </button>

                    <!-- Back to Home -->
                    <a href="/"
                        class="w-full py-2.5 flex items-center justify-center gap-2 text-sm text-gray-500 hover:text-blue-600 font-medium transition-colors rounded-xl hover:bg-blue-50 border border-transparent hover:border-blue-100">
                        <i class="fas fa-arrow-left text-xs"></i>
                        Kembali ke Beranda
                    </a>
                </form>

                <!-- Register Link -->
                <div class="mt-5 pt-5 border-t border-gray-100 text-center">
                    <span class="text-xs text-gray-400">Belum punya akun?</span>
                    <a href="{{ route('register') }}" class="text-xs text-blue-600 font-bold hover:text-blue-800 transition-colors ml-1">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function validateGmailLogin(input) {
    const warning = document.getElementById('gmail-warning-login');
    if (input.value && !input.value.endsWith('@gmail.com')) {
        warning.classList.remove('hidden');
    } else {
        warning.classList.add('hidden');
    }
}
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endsection
