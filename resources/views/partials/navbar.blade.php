<!-- Topbar Navbar -->
<header class="flex items-center justify-between px-6 py-3 bg-white/80 backdrop-blur-md border-b border-blue-100 shadow-sm sticky top-0 z-20">
    <!-- Left: Page Title / Breadcrumb -->
    <div class="flex items-center gap-3">
        <!-- Mobile sidebar toggle -->
        <button id="mobileSidebarToggle" class="sm:hidden w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 transition-colors">
            <i class="fas fa-bars"></i>
        </button>
        <div>
            <h1 class="text-base font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
            <p class="text-xs text-gray-400">SIM Ayam Petelur</p>
        </div>
    </div>

    <!-- Right: User Dropdown -->
    <div class="flex items-center gap-3" x-data="{ open: false }" @click.outside="open = false">
        <!-- Notification Bell (decoration) -->
        <button class="relative w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500 hover:bg-blue-100 transition-colors">
            <i class="fas fa-bell text-sm"></i>
        </button>

        <!-- User Avatar + Dropdown -->
        <div class="relative">
            <button @click="open = !open"
                class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-medium hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-md">
                <img class="w-6 h-6 rounded-lg object-cover"
                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=3b82f6&color=fff&bold=true&size=64"
                    alt="{{ Auth::user()->name ?? 'User' }}">
                <span class="hidden sm:block">{{ Auth::user()->name ?? 'User' }}</span>
                <i class="fas fa-chevron-down text-xs opacity-70 transition-transform duration-200" :class="{'rotate-180': open}"></i>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-blue-50 overflow-hidden z-50">

                <div class="px-4 py-3 border-b border-gray-50">
                    <p class="text-xs text-gray-400">Login sebagai</p>
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name ?? 'User' }}</p>
                </div>

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                    <i class="fas fa-user text-xs text-blue-400 w-4"></i>
                    <span>Profile</span>
                </a>

                <div class="border-t border-gray-50">
                    <form id="navbar-logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors">
                            <i class="fas fa-sign-out-alt text-xs w-4"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- End Topbar -->
