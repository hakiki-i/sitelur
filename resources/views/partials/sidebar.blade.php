<!-- Sidebar -->
<style>
    .sidebar-custom {
        background: linear-gradient(180deg, #1a233a 0%, #27314f 100%);
        box-shadow: 2px 0 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        position: sticky;
        top: 0;
        height: 100vh;
        overflow-y: auto;
        z-index: 1030;
    }
    /* Scrollbar minimalis untuk sidebar */
    .sidebar-custom::-webkit-scrollbar {
        width: 6px;
    }
    .sidebar-custom::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.02);
    }
    .sidebar-custom::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
    }
    .sidebar-custom::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }
    .sidebar-custom .nav-item .nav-link {
        color: rgba(255, 255, 255, 0.7);
        font-weight: 500;
        padding: 0.9rem 1.25rem;
        transition: all 0.2s ease;
        border-radius: 10px;
        margin: 0 12px 5px 12px;
    }
    .sidebar-custom .nav-item .nav-link i {
        margin-right: 8px;
        transition: transform 0.2s ease;
    }
    .sidebar-custom .nav-item .nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff;
        transform: translateX(4px);
    }
    .sidebar-custom .nav-item .nav-link:hover i {
        transform: scale(1.1);
    }
    .sidebar-custom .nav-item.active .nav-link {
        background: linear-gradient(90deg, rgba(78, 115, 223, 0.9) 0%, rgba(34, 74, 190, 0.9) 100%);
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        font-weight: 600;
    }
    .sidebar-custom .sidebar-brand {
        padding: 1.5rem 1rem;
        color: #fff;
        font-size: 1.2rem;
        font-weight: 800;
        letter-spacing: 0.5px;
    }
    .sidebar-custom .sidebar-brand-icon {
        background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 2rem;
        transition: transform 0.3s ease;
    }
    .sidebar-custom .sidebar-brand:hover .sidebar-brand-icon {
        transform: rotate(15deg) scale(1.1);
    }
    .sidebar-custom .sidebar-divider {
        border-top: 1px solid rgba(255,255,255,0.08);
        margin: 10px 15px;
    }
</style>

<ul class="navbar-nav sidebar-custom sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center mb-2" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-egg"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIM Ayam</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0 mb-3">
    
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    
    <!-- Nav Item - Pegawai -->
    <li class="nav-item {{ request()->is('pegawai*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pegawai.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Pegawai</span>
        </a>
    </li>
    
    <!-- Nav Item - Kandang -->
    <li class="nav-item {{ request()->is('kandang*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kandang.index') }}">
            <i class="fas fa-fw fa-warehouse"></i>
            <span>Kandang</span>
        </a>
    </li>
    
    <!-- Nav Item - Ayam -->
    <li class="nav-item {{ request()->is('ayam*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('ayam.index') }}">
            <i class="fas fa-fw fa-drumstick-bite"></i>
            <span>Ayam</span>
        </a>
    </li>
    
    <!-- Nav Item - Produksi -->
    <li class="nav-item {{ request()->is('produksi*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('produksi.index') }}">
            <i class="fas fa-fw fa-egg"></i>
            <span>Produksi</span>
        </a>
    </li>
    
    <!-- Nav Item - Harga Telur -->
    <li class="nav-item {{ request()->is('harga_telur*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('harga_telur.index') }}">
            <i class="fas fa-fw fa-money-bill-wave"></i>
            <span>Harga Telur</span>
        </a>
    </li>
    
    <!-- Nav Item - Penjualan -->
    <li class="nav-item {{ request()->is('penjualan*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('penjualan.index') }}">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Penjualan</span>
        </a>
    </li>
    
    <!-- Nav Item - Laporan -->
    <li class="nav-item {{ request()->is('laporan*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('laporan.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Laporan</span>
        </a>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block mt-3">
    
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline mt-2">
        <button class="rounded-circle border-0" style="background-color: rgba(255,255,255,0.2);" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
