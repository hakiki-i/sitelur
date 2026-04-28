@extends('layouts.app')

@section('content')
<h2 class="mb-4">Dashboard</h2>
<div class="row g-4 mb-4">
    <div class="col-12">
        @include('dashboard_kandang_info')
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <span class="fs-1 me-3"><i class="fas fa-users"></i></span>
                <div>
                    <div class="fw-bold text-secondary">Pegawai</div>
                    <div class="fs-4">{{ $pegawaiCount }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <span class="fs-1 me-3"><i class="fas fa-warehouse"></i></span>
                <div>
                    <div class="fw-bold text-secondary">Kandang</div>
                    <div class="fs-4">{{ $kandangCount }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <span class="fs-1 me-3"><i class="fas fa-drumstick-bite"></i></span>
                <div>
                    <div class="fw-bold text-secondary">Jumlah Ayam</div>
                    <div class="fs-4">{{ $jumlahAyam }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <span class="fs-1 me-3"><i class="fas fa-egg"></i></span>
                <div>
                    <div class="fw-bold text-secondary">Produksi Hari Ini</div>
                    <div class="fs-4">{{ $produksiHariIni }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <span class="fs-1 me-3"><i class="fas fa-check-circle text-success"></i></span>
                <div>
                    <div class="fw-bold text-secondary">Stok Telur Layak</div>
                    <div class="fs-4">{{ $stokLayak }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <span class="fs-1 me-3"><i class="fas fa-times-circle text-danger"></i></span>
                <div>
                    <div class="fw-bold text-secondary">Stok Telur Tidak Layak</div>
                    <div class="fs-4">{{ $stokTidakLayak }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <span class="fs-1 me-3"><i class="fas fa-money-bill-wave text-warning"></i></span>
                <div>
                    <div class="fw-bold text-secondary">Penjualan Bulan Ini</div>
                    <div class="fs-4">Rp {{ number_format($penjualanBulanIni,0,',','.') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row mt-5">
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Produksi Bulanan</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="produksiAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Persentase Stok Telur</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="stokPieChart"></canvas>
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
            backgroundColor: 'rgba(78, 115, 223, 0.05)',
            borderColor: 'rgba(78, 115, 223, 1)',
            pointRadius: 3,
            pointBackgroundColor: 'rgba(78, 115, 223, 1)',
            pointBorderColor: 'rgba(78, 115, 223, 1)',
            pointHoverRadius: 3,
            pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
            pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
            pointHitRadius: 10,
            pointBorderWidth: 2,
        }]
    },
    options: {
        maintainAspectRatio: false,
        scales: {
            x: { grid: { display: false } },
            y: { beginAtZero: true }
        },
        plugins: {
            legend: { display: false }
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
            hoverBorderColor: 'rgba(234, 236, 244, 1)',
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: { display: true, position: 'bottom' }
        },
        cutout: '70%'
    }
});
</script>
@endpush
@endsection
