<div class="row g-4 mb-4">
    @foreach($kandangList as $kandang)
    <div class="col-md-6 col-lg-4">
        <div class="card shadow border-0 h-100">
            <div class="card-header bg-info text-white d-flex align-items-center justify-content-between">
                <span class="fw-bold"><i class="fas fa-warehouse me-2"></i>{{ $kandang->nama_kandang }}</span>
            </div>
            <div class="card-body py-4">
                <div class="d-flex align-items-center mb-3">
                    <span class="fs-2 text-primary me-3"><i class="fas fa-drumstick-bite"></i></span>
                    <div>
                        <div class="small text-muted">Jumlah Ayam</div>
                        <div class="fw-bold fs-4 text-dark">{{ $kandang->jumlah_ayam }}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <span class="fs-2 text-success me-3"><i class="fas fa-birthday-cake"></i></span>
                    <div>
                        <div class="small text-muted">Umur Ayam Tertua</div>
                        <div class="fw-bold fs-5 text-dark">{{ $kandang->umur_tertua }}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="fs-2 text-warning me-3"><i class="fas fa-egg"></i></span>
                    <div>
                        <div class="small text-muted">Produksi Hari Ini</div>
                        <div class="fw-bold fs-4 text-dark">{{ $kandang->produksi_hari_ini }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
