@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- Page Header -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Dashboard Overview</h2>
        <p class="text-sm text-gray-500 mt-0.5">Selamat datang, data real-time peternakan Anda</p>
    </div>
    <div class="flex items-center gap-2 text-sm text-blue-600 bg-blue-50 px-3 py-1.5 rounded-full font-medium">
        <i class="fas fa-calendar-day text-xs"></i>
        <span>{{ now()->translatedFormat('d F Y') }}</span>
    </div>
</div>

<!-- Stats Row 1 -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    <!-- Pegawai -->
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 p-5 flex items-center gap-4 hover:-translate-y-1 transition-transform duration-200 group">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 bg-gradient-to-br from-blue-500 to-blue-700 shadow-md shadow-blue-200">
            <i class="fas fa-users text-white text-lg"></i>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Pegawai</p>
            <p class="text-2xl font-extrabold text-gray-800 leading-tight">{{ $pegawaiCount }}</p>
        </div>
    </div>

    <!-- Kandang -->
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 p-5 flex items-center gap-4 hover:-translate-y-1 transition-transform duration-200 group">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 bg-gradient-to-br from-indigo-500 to-indigo-700 shadow-md shadow-indigo-200">
            <i class="fas fa-warehouse text-white text-lg"></i>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Kandang</p>
            <p class="text-2xl font-extrabold text-gray-800 leading-tight">{{ $kandangCount }}</p>
        </div>
    </div>

    <!-- Jumlah Ayam -->
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 p-5 flex items-center gap-4 hover:-translate-y-1 transition-transform duration-200 group">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 bg-gradient-to-br from-sky-500 to-sky-700 shadow-md shadow-sky-200">
            <i class="fas fa-drumstick-bite text-white text-lg"></i>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Jumlah Ayam</p>
            <p class="text-2xl font-extrabold text-gray-800 leading-tight">{{ $jumlahAyam }}</p>
        </div>
    </div>

    <!-- Produksi Hari Ini -->
    <div class="bg-white rounded-2xl shadow-sm border border-blue-50 p-5 flex items-center gap-4 hover:-translate-y-1 transition-transform duration-200 group">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 bg-gradient-to-br from-blue-600 to-violet-600 shadow-md shadow-violet-200">
            <i class="fas fa-egg text-white text-lg"></i>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Produksi Hari Ini</p>
            <p class="text-2xl font-extrabold text-gray-800 leading-tight">{{ $produksiHariIni }}</p>
        </div>
    </div>
</div>

<!-- Stats Row 2 -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

    <!-- Stok Grade A -->
    <div class="bg-white rounded-2xl shadow-sm border-l-4 border-blue-500 p-5 flex items-center gap-4 hover:-translate-y-1 transition-transform duration-200">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 bg-blue-100">
            <i class="fas fa-check-circle text-blue-600 text-lg"></i>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Stok Grade A</p>
            <p class="text-2xl font-extrabold text-gray-800 leading-tight">{{ $stokLayak }}</p>
        </div>
    </div>

    <!-- Stok Grade B -->
    <div class="bg-white rounded-2xl shadow-sm border-l-4 border-red-400 p-5 flex items-center gap-4 hover:-translate-y-1 transition-transform duration-200">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 bg-red-50">
            <i class="fas fa-times-circle text-red-500 text-lg"></i>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">Stok Grade B</p>
            <p class="text-2xl font-extrabold text-gray-800 leading-tight">{{ $stokTidakLayak }}</p>
        </div>
    </div>

    <!-- Penjualan Bulan Ini -->
    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-md p-5 flex items-center gap-4 hover:-translate-y-1 transition-transform duration-200">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 bg-white/20">
            <i class="fas fa-money-bill-wave text-white text-lg"></i>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-blue-200">Penjualan Bulan Ini</p>
            <p class="text-xl font-extrabold text-white leading-tight">Rp {{ number_format($penjualanBulanIni,0,',','.') }}</p>
        </div>
    </div>
</div>

<!-- Kandang Info -->
<div class="mb-6">
    @include('dashboard_kandang_info')
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 xl:grid-cols-8 gap-4 mb-6">
    <!-- Area Chart -->
    <div class="xl:col-span-5 bg-white rounded-2xl shadow-sm border border-blue-50 p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-gray-800 text-base">Grafik Produksi Bulanan</h3>
                <p class="text-xs text-gray-400 mt-0.5">Jumlah telur diproduksi per bulan</p>
            </div>
            <div class="w-8 h-8 rounded-xl bg-blue-50 flex items-center justify-center">
                <i class="fas fa-chart-line text-blue-500 text-sm"></i>
            </div>
        </div>
        <div style="height: 280px;">
            <canvas id="produksiAreaChart"></canvas>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="xl:col-span-3 bg-white rounded-2xl shadow-sm border border-blue-50 p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-gray-800 text-base">Persentase Stok Telur</h3>
                <p class="text-xs text-gray-400 mt-0.5">Grade A vs Grade B</p>
            </div>
            <div class="w-8 h-8 rounded-xl bg-blue-50 flex items-center justify-center">
                <i class="fas fa-chart-pie text-blue-500 text-sm"></i>
            </div>
        </div>
        <div class="flex flex-col items-center">
            <div style="height: 220px; width: 220px;">
                <canvas id="stokPieChart"></canvas>
            </div>
            <div class="flex gap-4 mt-3 text-xs font-medium text-gray-500">
                <span class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500 inline-block"></span> Grade A
                </span>
                <span class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-400 inline-block"></span> Grade B
                </span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('sbadmin/vendor/chart.js/Chart.min.js') }}"></script>
<script>
// Area Chart
var ctxArea = document.getElementById('produksiAreaChart').getContext('2d');
var produksiAreaChart = new Chart(ctxArea, {
    type: 'line',
    data: {
        labels: {!! json_encode($bulanChartLabels ?? ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"]) !!},
        datasets: [{
            label: 'Produksi',
            data: {!! json_encode($bulanChartData ?? [120, 150, 180, 200, 170, 210, 190, 220, 230, 210, 200, 180]) !!},
            backgroundColor: 'rgba(59, 130, 246, 0.12)',
            borderColor: 'rgba(59, 130, 246, 1)',
            pointRadius: 4,
            pointBackgroundColor: 'rgba(59, 130, 246, 1)',
            pointBorderColor: '#fff',
            pointHoverRadius: 6,
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgba(59, 130, 246, 1)',
            pointHitRadius: 10,
            pointBorderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        maintainAspectRatio: false,
        scales: {
            x: { grid: { display: false }, ticks: { color: '#9ca3af', font: { size: 11 } } },
            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { color: '#9ca3af', font: { size: 11 }, padding: 8 } }
        },
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#fff',
                titleColor: '#374151',
                bodyColor: '#6b7280',
                borderColor: '#e5e7eb',
                borderWidth: 1,
                padding: 10,
                displayColors: false,
                intersect: false,
                mode: 'index',
            }
        }
    }
});

// Pie Chart
var ctxPie = document.getElementById('stokPieChart').getContext('2d');
var stokPieChart = new Chart(ctxPie, {
    type: 'doughnut',
    data: {
        labels: ['Grade A', 'Grade B'],
        datasets: [{
            data: [{{ $stokLayak ?? 60 }}, {{ $stokTidakLayak ?? 40 }}],
            backgroundColor: ['#3b82f6', '#f87171'],
            hoverBackgroundColor: ['#2563eb', '#ef4444'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
            borderWidth: 2,
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#fff',
                titleColor: '#374151',
                bodyColor: '#6b7280',
                borderColor: '#e5e7eb',
                borderWidth: 1,
                padding: 10,
                displayColors: true,
                caretPadding: 10
            }
        },
        cutout: '72%',
    }
});
</script>
@endpush

@endsection
