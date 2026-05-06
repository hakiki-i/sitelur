@extends('layouts.app')

@section('content')
<style>
    .prod-stat-card {
        border: none;
        border-radius: 18px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #ffffff;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.02);
    }
    .prod-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }
    .icon-box-prod {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .bg-gradient-daily { background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); color: white; }
    .bg-gradient-weekly { background: linear-gradient(135deg, #36b9cc 0%, #258391 100%); color: white; }
    .bg-gradient-monthly { background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%); color: white; }
    
    .prod-title {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 700;
        color: #858796;
        margin-bottom: 4px;
    }
    .prod-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: #3a3b45;
        margin-bottom: 0;
        line-height: 1.2;
    }
    .header-title {
        font-weight: 800;
        color: #3a3b45;
        position: relative;
        padding-bottom: 10px;
        display: inline-block;
    }
    .header-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        border-radius: 2px;
    }
    .table-card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    .badge-status {
        padding: 0.5em 0.8em;
        font-weight: 600;
        letter-spacing: 0.5px;
        border-radius: 6px;
    }
    .btn-action {
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-action:hover {
        transform: translateY(-2px);
    }
</style>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2">
        <h2 class="h3 mb-0 header-title">Status Produksi</h2>
    </div>

    <div class="row g-4 mb-4">
        <!-- Produksi Harian -->
        <div class="col-md-4">
            <div class="card prod-stat-card h-100">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="icon-box-prod bg-gradient-daily me-3">
                        <i class="fas fa-egg"></i>
                    </div>
                    <div>
                        <div class="prod-title">Produksi Hari Ini</div>
                        <div class="prod-value">{{ $produksiHarian }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Produksi Mingguan -->
        <div class="col-md-4">
            <div class="card prod-stat-card h-100">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="icon-box-prod bg-gradient-weekly me-3">
                        <i class="fas fa-calendar-week"></i>
                    </div>
                    <div>
                        <div class="prod-title">Produksi Mingguan</div>
                        <div class="prod-value">{{ $produksiMingguan }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Produksi Bulanan -->
        <div class="col-md-4">
            <div class="card prod-stat-card h-100">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="icon-box-prod bg-gradient-monthly me-3">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <div class="prod-title">Produksi Bulanan</div>
                        <div class="prod-value">{{ $produksiBulanan }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Produksi -->
    <div class="card table-card mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4 text-gray-800">Daftar Produksi Terbaru</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tanggal</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Kandang</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Jumlah Telur</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Telur Layak</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Telur Tidak Layak</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Status</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listProduksi as $produksi)
                            <tr>
                                <td class="fw-medium text-dark">{{ $produksi->tanggal }}</td>
                                <td class="fw-medium text-dark">{{ $produksi->kandang->nama_kandang ?? '-' }}</td>
                                <td class="fw-bold text-primary">{{ $produksi->jumlah }}</td>
                                <td class="text-success fw-medium">{{ $produksi->telur_layak ?? '-' }}</td>
                                <td class="text-danger fw-medium">{{ $produksi->telur_tidak_layak ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-status {{ $produksi->status == 'final' ? 'bg-success' : ($produksi->status == 'draft' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                        {{ ucfirst($produksi->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($produksi->status != 'final' && $produksi->status != 'approved' && $produksi->status != 'rejected')
                                        <div class="d-flex justify-content-center gap-2">
                                            <form method="POST" action="{{ route('produksi.validasi', $produksi->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success btn-action shadow-sm" onclick="return confirm('Setujui data produksi ini?')"><i class="fas fa-check me-1"></i> Approve</button>
                                            </form>
                                            <form method="POST" action="{{ route('produksi.reject', $produksi->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger btn-action shadow-sm" onclick="return confirm('Tolak data produksi ini?')"><i class="fas fa-times me-1"></i> Reject</button>
                                            </form>
                                        </div>
                                    @elseif($produksi->status == 'approved' || $produksi->status == 'final')
                                        <span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i>Approved</span>
                                    @elseif($produksi->status == 'rejected')
                                        <span class="text-danger fw-bold"><i class="fas fa-times-circle me-1"></i>Rejected</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-4 border-top pt-3">
                <form method="get" class="d-flex align-items-center gap-2">
                    <label for="perPage" class="form-label mb-0 small text-muted fw-bold text-uppercase">Tampil</label>
                    <select name="perPage" id="perPage" class="form-select form-select-sm" style="border-radius: 8px; font-weight: 600; width: 70px;" onchange="this.form.submit()">
                        <option value="10" {{ request('perPage', 25) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('perPage', 25) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('perPage', 25) == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('perPage', 25) == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span class="small text-muted fw-bold text-uppercase">Data</span>
                </form>
                <div>
                    {!! $listProduksi->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
