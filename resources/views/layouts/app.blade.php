<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — SIM Ayam Petelur</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="{{ asset('sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Vite (Tailwind) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 50%, #e0e7ff 100%); min-height: 100vh; }
        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); }
        #sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
        /* Sidebar collapse transition */
        #sidebar { transition: width 0.3s ease; }
        #main-content { transition: margin-left 0.3s ease; }
        .sidebar-text.hidden { display: none !important; }

        /* Custom styles for Laravel's Bootstrap 5 Paginator fallback */
        .pagination { display: flex; list-style: none; padding-left: 0; margin: 0; gap: 0.25rem; }
        .page-item { display: inline; }
        .page-link, .page-item span {
            position: relative; display: block; padding: 0.5rem 0.75rem; font-size: 0.875rem; font-weight: 500;
            color: #2563eb; background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 0.5rem; text-decoration: none;
            transition: all 0.15s ease-in-out;
        }
        .page-item a.page-link:hover { background-color: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
        .page-item.active .page-link, .page-item.active span { background-color: #2563eb; color: #ffffff; border-color: #2563eb; z-index: 10; }
        .page-item.disabled .page-link, .page-item.disabled span { color: #9ca3af; background-color: #f9fafb; border-color: #e5e7eb; cursor: not-allowed; }

        .d-flex { display: flex !important; }
        .justify-content-between { justify-content: space-between !important; }
        .align-items-center { align-items: center !important; }
        .flex-fill { flex: 1 1 auto !important; }
        .d-none { display: none !important; }
        .small { font-size: 0.875rem; }
        .text-muted { color: #64748b !important; }

        @media (max-width: 575.98px) {
            .d-sm-none { display: flex !important; }
            .d-sm-flex { display: none !important; }
        }
        @media (min-width: 576px) {
            .d-sm-none { display: none !important; }
            .d-sm-flex { display: flex !important; }
            .align-items-sm-center { align-items: center !important; }
            .justify-content-sm-between { justify-content: space-between !important; }
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('partials.sidebar')
        <script>
            (function() {
                const sidebar = document.getElementById('sidebar');
                const sidebarTexts = document.querySelectorAll('.sidebar-text');
                if (localStorage.getItem('sidebar-collapsed') === 'true') {
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-16');
                    sidebarTexts.forEach(el => el.classList.add('hidden'));
                }
            })();
        </script>

        <!-- Main Content -->
        <div id="main-content" class="flex flex-col flex-1 overflow-hidden">
            <!-- Topbar -->
            @include('partials.navbar')

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>

            <!-- Footer -->
            @include('partials.footer')
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <button id="scrollTopBtn" onclick="window.scrollTo({top:0,behavior:'smooth'})"
        class="fixed bottom-6 right-6 w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-full shadow-lg flex items-center justify-center opacity-0 transition-all duration-300 hover:scale-110 z-50">
        <i class="fas fa-angle-up"></i>
    </button>

    <!-- jQuery -->
    <script src="{{ asset('sbadmin/vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript -->
    <script src="{{ asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script>
        // Scroll to top button
        window.addEventListener('scroll', function(e) {
            const btn = document.getElementById('scrollTopBtn');
            const main = document.querySelector('main');
            if (main && main.scrollTop > 100) {
                btn.style.opacity = '1';
            } else {
                btn.style.opacity = '0';
            }
        }, true);

        // Sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            const mobileBtn = document.getElementById('mobileSidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            
            function toggleSidebar() {
                sidebar.classList.toggle('w-64');
                sidebar.classList.toggle('w-16');
                sidebarTexts.forEach(el => el.classList.toggle('hidden'));
                
                const isCollapsed = sidebar.classList.contains('w-16');
                localStorage.setItem('sidebar-collapsed', isCollapsed ? 'true' : 'false');
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', toggleSidebar);
            }
            if (mobileBtn) {
                mobileBtn.addEventListener('click', toggleSidebar);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
