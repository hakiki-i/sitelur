<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="{{ asset('sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        body, .sidebar, .navbar, .card, .btn, .form-control, .table {
            font-family: 'Inter', Arial, sans-serif !important;
        }
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
        }
        .sidebar {
            background: linear-gradient(180deg, #3730a3 0%, #6366f1 100%) !important;
        }
        .sidebar .nav-item.active, .sidebar .nav-item:hover {
            background: rgba(255,255,255,0.08) !important;
            border-radius: 0.5rem;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 24px 0 rgba(80,80,160,0.08), 0 1.5px 4px 0 rgba(80,80,160,0.04);
        }
        .btn-primary, .btn-success, .btn-danger, .btn-warning, .btn-info {
            border-radius: 0.5rem;
            box-shadow: 0 2px 8px 0 rgba(80,80,160,0.08);
            transition: transform 0.1s;
        }
        .btn-primary:hover, .btn-success:hover, .btn-danger:hover, .btn-warning:hover, .btn-info:hover {
            transform: translateY(-2px) scale(1.03);
        }
        .form-control, .table {
            border-radius: 0.5rem;
        }
        .navbar {
            background: linear-gradient(90deg, #6366f1 0%, #818cf8 100%) !important;
            color: #fff !important;
            box-shadow: 0 2px 8px 0 rgba(80,80,160,0.08);
        }
        .navbar .nav-link, .navbar .navbar-brand, .navbar .dropdown-item {
            color: #fff !important;
        }
        .navbar .dropdown-menu {
            background: #fff;
        }
        .navbar .dropdown-item {
            color: #3730a3 !important;
        }
        .table thead th {
            background: #6366f1;
            color: #fff;
            border: none;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f1f5f9;
        }
        .table-hover tbody tr:hover {
            background-color: #e0e7ff;
        }
    </style>
    @stack('styles')
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('partials.sidebar')
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('partials.navbar')
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            @include('partials.footer')
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- jQuery -->
    <script src="{{ asset('sbadmin/vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- SB Admin 2 JS -->
    <script src="{{ asset('sbadmin/js/sb-admin-2.min.js') }}"></script>
    <!-- Alpine.js for modal and interactivity -->
    <script src="https://unpkg.com/alpinejs" defer></script>
    @stack('scripts')
</body>
</html>
