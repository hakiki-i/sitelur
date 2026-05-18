<!-- Sidebar -->
<aside id="sidebar" class="w-64 flex-shrink-0 flex flex-col h-screen overflow-y-auto z-30"
    style="background: linear-gradient(180deg, #1e3a8a 0%, #1d4ed8 50%, #2563eb 100%); box-shadow: 4px 0 20px rgba(30,58,138,0.3);">

    <!-- Brand -->
    <div class="flex items-center justify-between px-5 py-5 border-b border-white/10" id="sidebarBrandContainer">
        <a href="/" class="sidebar-text flex items-center gap-3 group">
            <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center shadow-inner group-hover:bg-white/30 transition-all duration-200">
                <i class="fas fa-egg text-yellow-300 text-lg"></i>
            </div>
            <span id="sidebarBrandText" class="text-white font-bold text-base tracking-wide">SIM Ayam</span>
        </a>
        <button id="sidebarToggleBtn" class="text-white/50 hover:text-white transition-colors p-1 rounded-lg hover:bg-white/10 flex-shrink-0">
            <i class="fas fa-bars text-sm"></i>
        </button>
    </div>

    <!-- Nav Items -->
    <nav class="flex-1 px-3 py-4 space-y-1">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                {{ request()->is('dashboard') ? 'bg-white/20 text-white shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i class="fas fa-tachometer-alt w-5 text-center text-base shrink-0
                {{ request()->is('dashboard') ? 'text-blue-200' : 'text-white/60 group-hover:text-white' }}"></i>
            <span class="sidebar-text text-sm font-medium">Dashboard</span>
            @if(request()->is('dashboard'))
                <span class="sidebar-text ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
            @endif
        </a>

        <!-- Pegawai -->
        <a href="{{ route('pegawai.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                {{ request()->is('pegawai*') ? 'bg-white/20 text-white shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i class="fas fa-users w-5 text-center text-base shrink-0
                {{ request()->is('pegawai*') ? 'text-blue-200' : 'text-white/60 group-hover:text-white' }}"></i>
            <span class="sidebar-text text-sm font-medium">Pegawai</span>
            @if(request()->is('pegawai*'))
                <span class="sidebar-text ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
            @endif
        </a>

        <!-- Kandang -->
        <a href="{{ route('kandang.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                {{ request()->is('kandang*') ? 'bg-white/20 text-white shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i class="fas fa-warehouse w-5 text-center text-base shrink-0
                {{ request()->is('kandang*') ? 'text-blue-200' : 'text-white/60 group-hover:text-white' }}"></i>
            <span class="sidebar-text text-sm font-medium">Kandang</span>
            @if(request()->is('kandang*'))
                <span class="sidebar-text ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
            @endif
        </a>

        <!-- Ayam -->
        <a href="{{ route('ayam.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                {{ request()->is('ayam*') ? 'bg-white/20 text-white shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i class="fas fa-drumstick-bite w-5 text-center text-base shrink-0
                {{ request()->is('ayam*') ? 'text-blue-200' : 'text-white/60 group-hover:text-white' }}"></i>
            <span class="sidebar-text text-sm font-medium">Ayam</span>
            @if(request()->is('ayam*'))
                <span class="sidebar-text ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
            @endif
        </a>

        <!-- Produksi -->
        <a href="{{ route('produksi.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                {{ request()->is('produksi*') ? 'bg-white/20 text-white shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i class="fas fa-egg w-5 text-center text-base shrink-0
                {{ request()->is('produksi*') ? 'text-blue-200' : 'text-white/60 group-hover:text-white' }}"></i>
            <span class="sidebar-text text-sm font-medium">Produksi</span>
            @if(request()->is('produksi*'))
                <span class="sidebar-text ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
            @endif
        </a>

        <!-- Harga Telur -->
        <a href="{{ route('harga_telur.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                {{ request()->is('harga_telur*') ? 'bg-white/20 text-white shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i class="fas fa-money-bill-wave w-5 text-center text-base shrink-0
                {{ request()->is('harga_telur*') ? 'text-blue-200' : 'text-white/60 group-hover:text-white' }}"></i>
            <span class="sidebar-text text-sm font-medium">Harga Telur</span>
            @if(request()->is('harga_telur*'))
                <span class="sidebar-text ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
            @endif
        </a>

        <!-- Penjualan -->
        <a href="{{ route('penjualan.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                {{ request()->is('penjualan*') ? 'bg-white/20 text-white shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i class="fas fa-shopping-cart w-5 text-center text-base shrink-0
                {{ request()->is('penjualan*') ? 'text-blue-200' : 'text-white/60 group-hover:text-white' }}"></i>
            <span class="sidebar-text text-sm font-medium">Penjualan</span>
            @if(request()->is('penjualan*'))
                <span class="sidebar-text ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
            @endif
        </a>

        <!-- Laporan -->
        <div x-data="{ open: {{ request()->is('laporan*') ? 'true' : 'false' }} }" class="overflow-hidden">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all duration-200 group
                    {{ request()->is('laporan*') ? 'bg-white/20 text-white shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-file-alt w-5 text-center text-base shrink-0
                        {{ request()->is('laporan*') ? 'text-blue-200' : 'text-white/60 group-hover:text-white' }}"></i>
                    <span class="sidebar-text text-sm font-medium">Laporan</span>
                </div>
                <i class="fas fa-chevron-down text-xs transition-transform duration-200 sidebar-text text-white/50" :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open" x-transition class="mt-1 space-y-1 sidebar-text" style="display: {{ request()->is('laporan*') ? 'block' : 'none' }};">
                <a href="{{ route('laporan.index', ['filter_jenis' => 'produksi']) }}"
                    class="block pl-11 pr-3 py-2 text-sm rounded-lg transition-colors {{ request('filter_jenis', 'produksi') == 'produksi' && request()->is('laporan') ? 'bg-white/10 text-white font-semibold' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    Produksi
                </a>
                <a href="{{ route('laporan.index', ['filter_jenis' => 'penjualan']) }}"
                    class="block pl-11 pr-3 py-2 text-sm rounded-lg transition-colors {{ request('filter_jenis') == 'penjualan' ? 'bg-white/10 text-white font-semibold' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                    Penjualan
                </a>
            </div>
        </div>

        <!-- Agen -->
        <a href="{{ route('agen.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                {{ request()->is('agen*') ? 'bg-white/20 text-white shadow-md' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i class="fas fa-store w-5 text-center text-base shrink-0
                {{ request()->is('agen*') ? 'text-blue-200' : 'text-white/60 group-hover:text-white' }}"></i>
            <span class="sidebar-text text-sm font-medium">Master Agen</span>
            @if(request()->is('agen*'))
                <span class="sidebar-text ml-auto w-1.5 h-1.5 rounded-full bg-blue-300"></span>
            @endif
        </a>
    </nav>

    <!-- Sidebar Footer -->
    <div class="px-4 py-4 border-t border-white/10">
        <div class="sidebar-text flex items-center gap-2 text-white/50 text-xs">
            <i class="fas fa-circle text-blue-400 text-xs"></i>
            <span>SIM Ayam Petelur v1.0</span>
        </div>
    </div>
</aside>
<!-- End Sidebar -->
