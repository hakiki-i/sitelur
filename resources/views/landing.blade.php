@extends('layouts.landing')

@section('content')
<div class="min-h-screen relative overflow-hidden flex flex-col"
    style="background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 50%, #4f46e5 100%);">

    {{-- Decorative blobs --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-indigo-300/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 right-1/4 w-72 h-72 bg-blue-300/5 rounded-full blur-2xl"></div>
    </div>

    {{-- Navbar simple --}}
    <nav class="relative z-10 flex items-center justify-between px-8 py-5">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center">
                <i class="fas fa-egg text-yellow-300"></i>
            </div>
            <span class="text-white font-bold text-lg">SIM Ayam</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}"
                class="px-4 py-2 text-white/80 hover:text-white text-sm font-medium transition-colors">
                Masuk
            </a>
            <a href="{{ route('register') }}"
                class="px-4 py-2 bg-white text-blue-700 text-sm font-bold rounded-xl hover:bg-blue-50 transition-colors shadow-md">
                Daftar
            </a>
        </div>
    </nav>

    {{-- Hero Section --}}
    <div class="relative z-10 flex-1 flex items-center justify-center px-6 py-12">
        <div class="max-w-5xl w-full">
            <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl shadow-blue-900/40 overflow-hidden">
                {{-- Top accent bar --}}
                <div class="h-1.5 bg-gradient-to-r from-blue-500 via-indigo-500 to-violet-500"></div>

                <div class="p-8 sm:p-12">
                    {{-- Icon hero --}}
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-xl shadow-blue-300 mb-5 animate-bounce">
                            <i class="fas fa-egg text-yellow-300 text-3xl"></i>
                        </div>
                        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight mb-3">
                            SIM Ayam Petelur
                        </h1>
                        <p class="text-gray-500 text-lg max-w-2xl mx-auto leading-relaxed">
                            Sistem Informasi Manajemen Peternakan Ayam Petelur yang modern, efisien, dan komprehensif untuk memantau kandang, pegawai, produksi, dan penjualan.
                        </p>
                    </div>

                    {{-- CTA Buttons --}}
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
                        <a href="{{ route('login') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-blue-300 hover:shadow-blue-400 hover:-translate-y-1 transition-all duration-200 text-base">
                            <i class="fas fa-sign-in-alt"></i>
                            Masuk ke Sistem
                        </a>
                        <a href="{{ route('register') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold rounded-2xl border-2 border-blue-200 hover:-translate-y-1 transition-all duration-200 text-base">
                            <i class="fas fa-user-plus"></i>
                            Buat Akun Baru
                        </a>
                    </div>

                    {{-- Feature Cards --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 pt-8 border-t border-gray-100">
                        <div class="group text-center p-5 rounded-2xl hover:bg-blue-50 transition-all duration-200 hover:-translate-y-1 cursor-default">
                            <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-blue-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <i class="fas fa-warehouse text-blue-600 text-xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-1">Manajemen Kandang</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">Pantau operasional dan kapasitas kandang secara real-time.</p>
                        </div>
                        <div class="group text-center p-5 rounded-2xl hover:bg-indigo-50 transition-all duration-200 hover:-translate-y-1 cursor-default">
                            <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-indigo-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <i class="fas fa-chart-line text-indigo-600 text-xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-1">Analitik Produksi</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">Catat dan analisis tingkat produksi telur harian dengan mudah.</p>
                        </div>
                        <div class="group text-center p-5 rounded-2xl hover:bg-sky-50 transition-all duration-200 hover:-translate-y-1 cursor-default">
                            <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-sky-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <i class="fas fa-drumstick-bite text-sky-600 text-xl"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-1">Monitoring Ayam</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">Kelola siklus hidup, populasi, dan kesehatan ayam.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <p class="text-center text-white/50 text-sm mt-6">
                &copy; {{ date('Y') }} SIM Ayam Petelur. All rights reserved.
            </p>
        </div>
    </div>
</div>
@endsection
