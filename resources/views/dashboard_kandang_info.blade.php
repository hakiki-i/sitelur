<style>
    .kandang-card {
        border-radius: 18px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .kandang-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .kandang-header {
        background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
        color: white;
        padding: 1rem 1.5rem;
        font-size: 1.1rem;
        letter-spacing: 0.5px;
        border-bottom: none;
    }
    .kandang-info-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px dashed rgba(0,0,0,0.05);
    }
    .kandang-info-item:last-child {
        border-bottom: none;
    }
    .kandang-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-right: 15px;
        background: rgba(0,0,0,0.03);
    }
    .k-val {
        font-weight: 800;
        font-size: 1.2rem;
        color: #3a3b45;
        line-height: 1;
    }
    .k-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        font-weight: 700;
        color: #858796;
        margin-bottom: 4px;
    }
</style>
<div class="row g-4 mb-4">
    @foreach($kandangList as $kandang)
    <div class="col-md-6 col-lg-4">
        <div class="card kandang-card h-100 bg-white">
            <div class="card-header kandang-header d-flex align-items-center justify-content-between">
                <span class="fw-bold"><i class="fas fa-warehouse me-2 opacity-75"></i>{{ $kandang->nama_kandang }}</span>
            </div>
            <div class="card-body py-3 px-4">
                <div class="kandang-info-item">
                    <div class="kandang-icon text-primary"><i class="fas fa-drumstick-bite"></i></div>
                    <div>
                        <div class="k-label">Jumlah Ayam</div>
                        <div class="k-val">{{ $kandang->jumlah_ayam }}</div>
                    </div>
                </div>
                <div class="kandang-info-item">
                    <div class="kandang-icon text-success"><i class="fas fa-birthday-cake"></i></div>
                    <div>
                        <div class="k-label">Umur Ayam Tertua</div>
                        <div class="k-val">{{ $kandang->umur_tertua }}</div>
                    </div>
                </div>
                <div class="kandang-info-item">
                    <div class="kandang-icon text-warning"><i class="fas fa-egg"></i></div>
                    <div>
                        <div class="k-label">Produksi Hari Ini</div>
                        <div class="k-val">{{ $kandang->produksi_hari_ini }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
