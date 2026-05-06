@extends('layouts.app')

@section('content')
<style>
    .dashboard-card {
        border: none;
        border-radius: 20px;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        background: #ffffff;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    .dashboard-card::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        transform: translate(30%, -30%);
        z-index: -1;
    }
    .icon-box {
        width: 38px;
        height: 38px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .bg-gradient-primary-custom { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; }
    .bg-gradient-success-custom { background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); color: white; }
    .bg-gradient-info-custom { background: linear-gradient(135deg, #36b9cc 0%, #258391 100%); color: white; }
    .bg-gradient-warning-custom { background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%); color: white; }
    .bg-gradient-danger-custom { background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%); color: white; }
    .bg-gradient-secondary-custom { background: linear-gradient(135deg, #858796 0%, #60616f 100%); color: white; }
    
    .card-title-custom {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 700;
        color: #858796;
        margin-bottom: 4px;
    }
    .card-value-custom {
        font-size: 1.6rem;
        font-weight: 800;
        color: #3a3b45;
        margin-bottom: 0;
        line-height: 1.2;
    }
    .page-header {
        font-weight: 800;
        color: #3a3b45;
        position: relative;
        padding-bottom: 10px;
    }
    .page-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border-radius: 2px;
    }
    .chart-card {
        border-radius: 20px;
        border: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    .chart-card .card-header {
        background-color: transparent;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 1.25rem 1.5rem;
    }
    .chart-card .card-header h6 {
        font-weight: 700;
        font-size: 1rem;
        color: #4e73df;
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h2 class="h3 mb-0 page-header">Dashboard Overview</h2>
</div>

<div class="row g-4 mb-4">
    <div class="col-12">
        @include('dashboard_kandang_info')
    </div>
    
    <!-- Pegawai Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card h-100">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="icon-box bg-gradient-primary-custom me-3">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <div class="card-title-custom">Pegawai</div>
                    <div class="card-value-custom">{{ $pegawaiCount }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kandang Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card h-100">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="icon-box bg-gradient-info-custom me-3">
                    <i class="fas fa-warehouse"></i>
                </div>
                <div>
                    <div class="card-title-custom">Kandang</div>
                    <div class="card-value-custom">{{ $kandangCount }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jumlah Ayam Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card h-100">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="icon-box bg-gradient-warning-custom me-3">
                    <i class="fas fa-drumstick-bite"></i>
                </div>
                <div>
                    <div class="card-title-custom">Jumlah Ayam</div>
                    <div class="card-value-custom">{{ $jumlahAyam }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Produksi Hari Ini Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card dashboard-card h-100">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="icon-box bg-gradient-success-custom me-3">
                    <i class="fas fa-egg"></i>
                </div>
                <div>
                    <div class="card-title-custom">Produksi Hari Ini</div>
                    <div class="card-value-custom">{{ $produksiHariIni }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Stok Layak Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card dashboard-card h-100" style="border-bottom: 4px solid #1cc88a;">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="icon-box bg-gradient-success-custom me-3" style="opacity: 0.9;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div class="card-title-custom">Stok Telur Layak</div>
                    <div class="card-value-custom">{{ $stokLayak }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stok Tidak Layak Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card dashboard-card h-100" style="border-bottom: 4px solid #e74a3b;">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="icon-box bg-gradient-danger-custom me-3" style="opacity: 0.9;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div>
                    <div class="card-title-custom">Stok Telur Tidak Layak</div>
                    <div class="card-value-custom">{{ $stokTidakLayak }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Penjualan Bulan Ini Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card dashboard-card h-100" style="border-bottom: 4px solid #f6c23e;">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="icon-box bg-gradient-warning-custom me-3" style="opacity: 0.9;">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div>
                    <div class="card-title-custom">Penjualan Bulan Ini</div>
                    <div class="card-value-custom" style="font-size: 1.4rem;">Rp {{ number_format($penjualanBulanIni,0,',','.') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row">
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card chart-card h-100">
            <div class="card-header d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0">Grafik Produksi Bulanan</h6>
            </div>
            <div class="card-body">
                <div class="chart-area" style="height: 320px;">
                    <canvas id="produksiAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card chart-card h-100">
            <div class="card-header d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0">Persentase Stok Telur</h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-center">
                <div class="chart-pie pt-4 pb-2" style="height: 280px;">
                    <canvas id="stokPieChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Layak
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-danger"></i> Tidak Layak
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('sbadmin/vendor/chart.js/Chart.min.js') }}"></script>
<script>
// Area Chart Example
var ctxArea = document.getElementById('produksiAreaChart').getContext('2d');
var produksiAreaChart = new Chart(ctxArea, {
    type: 'line',
    data: {
        labels: {!! json_encode($bulanChartLabels ?? ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"]) !!},
        datasets: [{
            label: 'Produksi',
            data: {!! json_encode($bulanChartData ?? [120, 150, 180, 200, 170, 210, 190, 220, 230, 210, 200, 180]) !!},
            backgroundColor: 'rgba(78, 115, 223, 0.1)',
            borderColor: 'rgba(78, 115, 223, 1)',
            pointRadius: 4,
            pointBackgroundColor: 'rgba(78, 115, 223, 1)',
            pointBorderColor: '#fff',
            pointHoverRadius: 6,
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
            pointHitRadius: 10,
            pointBorderWidth: 2,
            fill: true,
            tension: 0.4 // Smooth curve
        }]
    },
    options: {
        maintainAspectRatio: false,
        scales: {
            x: { 
                grid: { display: false, drawBorder: false },
                ticks: { color: '#858796', font: { family: 'Nunito', size: 12 } }
            },
            y: { 
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                ticks: { color: '#858796', font: { family: 'Nunito', size: 12 }, padding: 10 }
            }
        },
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                titleColor: '#6e707e',
                bodyColor: '#858796',
                borderColor: '#dddfeb',
                borderWidth: 1,
                padding: 10,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10
            }
        }
    }
});

// Pie Chart Example
var ctxPie = document.getElementById('stokPieChart').getContext('2d');
var stokPieChart = new Chart(ctxPie, {
    type: 'doughnut',
    data: {
        labels: ['Layak', 'Tidak Layak'],
        datasets: [{
            data: [{{ $stokLayak ?? 60 }}, {{ $stokTidakLayak ?? 40 }}],
            backgroundColor: ['#1cc88a', '#e74a3b'],
            hoverBackgroundColor: ['#17a673', '#be2617'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
            borderWidth: 2,
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                titleColor: '#6e707e',
                bodyColor: '#858796',
                borderColor: '#dddfeb',
                borderWidth: 1,
                padding: 10,
                displayColors: true,
                caretPadding: 10
            }
        },
        cutout: '75%',
    }
});
</script>
@endpush
@endsection
