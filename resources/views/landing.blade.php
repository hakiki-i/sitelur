@extends('layouts.landing')

@section('content')
<div class="landing-bg min-vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100">
        <div class="col-md-8 mx-auto text-center">
            <div class="card shadow-lg border-0 animate__animated animate__fadeInDown" style="background: rgba(255,255,255,0.95);">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <span class="bg-gradient-primary rounded-circle p-3">
                            <i class="fas fa-egg fa-3x text-warning"></i>
                        </span>
                    </div>
                    <h1 class="display-4 mt-3 mb-2 text-primary fw-bold">SIM Ayam Petelur</h1>
                    <p class="lead mb-4 text-dark">Sistem Informasi Manajemen Peternakan Ayam Petelur modern untuk monitoring kandang, pegawai, produksi, dan ayam.</p>
                    <div class="mb-4">
                        <a href="{{ route('login') }}" class="btn btn-success btn-lg px-5 shadow-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-5 ms-2 shadow-sm">Daftar</a>
                    </div>
                    <hr>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="feature-icon mb-2"><i class="fas fa-warehouse fa-2x text-primary"></i></div>
                            <h5 class="fw-bold">Manajemen Kandang</h5>
                            <p class="text-muted small">Pantau dan kelola kandang.</p>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-icon mb-2"><i class="fas fa-users fa-2x text-success"></i></div>
                            <h5 class="fw-bold">Data Pegawai</h5>
                            <p class="text-muted small">Kelola pegawai.</p>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-icon mb-2"><i class="fas fa-drumstick-bite fa-2x text-warning"></i></div>
                            <h5 class="fw-bold">Produksi & Ayam</h5>
                            <p class="text-muted small">Catat produksi dan data ayam.</p>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="mt-5 text-muted small">Copyright &copy; SIM Ayam Petelur 2026</footer>
        </div>
    </div>
</div>
<style>
.landing-bg {
    background: linear-gradient(135deg, #6dd5ed 0%, #2193b0 100%);
}
.feature-icon {
    background: #f8f9fa;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}
</style>
@endsection
