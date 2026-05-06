@extends('layouts.landing')

@section('content')
<div class="landing-bg min-vh-100 d-flex align-items-center justify-content-center position-relative overflow-hidden">
    <!-- Background Decor -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: radial-gradient(circle at 10% 20%, rgba(255,255,255,0.1) 0%, transparent 20%), radial-gradient(circle at 90% 80%, rgba(255,255,255,0.1) 0%, transparent 20%); z-index: 0;"></div>
    
    <div class="container position-relative" style="z-index: 1;">
        <div class="row w-100 justify-content-center">
            <div class="col-lg-10 col-xl-8 text-center">
                <div class="card main-card shadow-lg border-0 animate__animated animate__zoomIn" style="background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px); border-radius: 30px;">
                    <div class="card-body p-sm-5 p-4">
                        <div class="mb-4">
                            <div class="icon-pulse d-inline-block bg-gradient-primary rounded-circle p-4 shadow-lg">
                                <i class="fas fa-egg fa-4x text-white"></i>
                            </div>
                        </div>
                        <h1 class="display-4 fw-extrabold text-gray-900 mb-3" style="font-weight: 900; letter-spacing: -1px;">SIM Ayam Petelur</h1>
                        <p class="lead mb-5 text-gray-600 px-md-5" style="font-size: 1.15rem; line-height: 1.7;">Sistem Informasi Manajemen Peternakan Ayam Petelur yang modern, efisien, dan komprehensif untuk memantau kandang, pegawai, produksi, dan kesehatan ayam Anda.</p>
                        
                        <div class="d-flex justify-content-center gap-3 mb-5 flex-wrap">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5 shadow-lg d-flex align-items-center" style="border-radius: 50px; font-weight: 700; padding: 15px 30px; transition: all 0.3s;">
                                <i class="fas fa-sign-in-alt me-2"></i> Masuk Sistem
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-5 d-flex align-items-center" style="border-radius: 50px; font-weight: 700; padding: 15px 30px; border-width: 2px; transition: all 0.3s;">
                                <i class="fas fa-user-plus me-2"></i> Buat Akun
                            </a>
                        </div>
                        
                        <div class="row mt-5 pt-4 border-top">
                            <div class="col-md-4 mb-4 mb-md-0">
                                <div class="feature-box p-3 rounded-4 transition-all">
                                    <div class="feature-icon mb-3 bg-primary-soft text-primary"><i class="fas fa-warehouse fa-2x"></i></div>
                                    <h5 class="fw-bold text-dark">Manajemen Kandang</h5>
                                    <p class="text-muted small mb-0">Pantau operasional dan kapasitas kandang secara real-time.</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4 mb-md-0">
                                <div class="feature-box p-3 rounded-4 transition-all">
                                    <div class="feature-icon mb-3 bg-success-soft text-success"><i class="fas fa-chart-line fa-2x"></i></div>
                                    <h5 class="fw-bold text-dark">Analitik Produksi</h5>
                                    <p class="text-muted small mb-0">Catat dan analisis tingkat produksi telur harian dengan mudah.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-box p-3 rounded-4 transition-all">
                                    <div class="feature-icon mb-3 bg-warning-soft text-warning"><i class="fas fa-drumstick-bite fa-2x"></i></div>
                                    <h5 class="fw-bold text-dark">Monitoring Ayam</h5>
                                    <p class="text-muted small mb-0">Kelola siklus hidup, populasi, dan kesehatan ayam.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="mt-4 text-white small opacity-75 fw-medium">Copyright &copy; SIM Ayam Petelur {{ date('Y') }}</footer>
            </div>
        </div>
    </div>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

.landing-bg {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    font-family: 'Inter', sans-serif;
}
.main-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.main-card:hover {
    box-shadow: 0 20px 40px rgba(0,0,0,0.2) !important;
}
.bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
}
.bg-primary-soft { background-color: rgba(78, 115, 223, 0.1); }
.bg-success-soft { background-color: rgba(28, 200, 138, 0.1); }
.bg-warning-soft { background-color: rgba(246, 194, 62, 0.1); }

.feature-box {
    cursor: default;
    transition: all 0.3s ease;
}
.feature-box:hover {
    background-color: #f8f9fc;
    transform: translateY(-5px);
}
.feature-icon {
    border-radius: 18px;
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    transition: all 0.3s ease;
}
.feature-box:hover .feature-icon {
    transform: scale(1.1);
}
.icon-pulse {
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(78, 115, 223, 0.7); }
    70% { transform: scale(1.05); box-shadow: 0 0 0 15px rgba(78, 115, 223, 0); }
    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(78, 115, 223, 0); }
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(78, 115, 223, 0.3) !important;
}
.btn-outline-primary:hover {
    transform: translateY(-2px);
    background-color: #4e73df;
    color: white !important;
}
</style>
@endsection
