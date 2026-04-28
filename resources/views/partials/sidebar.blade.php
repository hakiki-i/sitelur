<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-egg"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIM Ayam Petelur</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Nav Item - Pegawai -->
    <li class="nav-item {{ request()->is('pegawai*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pegawai.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Pegawai</span></a>
    </li>
    <!-- Nav Item - Kandang -->
    <li class="nav-item {{ request()->is('kandang*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kandang.index') }}">
            <i class="fas fa-fw fa-warehouse"></i>
            <span>Kandang</span></a>
    </li>
    <!-- Nav Item - Ayam -->
    <li class="nav-item {{ request()->is('ayam*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('ayam.index') }}">
            <i class="fas fa-fw fa-drumstick-bite"></i>
            <span>Ayam</span></a>
    </li>
    <!-- Nav Item - Produksi -->
    <li class="nav-item {{ request()->is('produksi*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('produksi.index') }}">
            <i class="fas fa-fw fa-egg"></i>
            <span>Produksi</span></a>
    </li>
    <!-- Nav Item - Harga Telur -->
    <li class="nav-item {{ request()->is('harga_telur*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('harga_telur.index') }}">
            <i class="fas fa-fw fa-money-bill-wave"></i>
            <span>Harga Telur</span></a>
    </li>
    <!-- Nav Item - Penjualan -->
    <li class="nav-item {{ request()->is('penjualan*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('penjualan.index') }}">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Penjualan</span></a>
    </li>
    <!-- Nav Item - Laporan -->
    <li class="nav-item {{ request()->is('laporan*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('laporan.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Laporan</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
