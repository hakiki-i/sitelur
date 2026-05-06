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
        body {
            font-family: 'Inter', sans-serif !important;
            background-color: #f4f7fc;
            color: #495057;
        }
        
        /* Modern Cards */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
            margin-bottom: 24px;
        }
        
        /* Elegant Card Headers */
        .card-header {
            background: #ffffff;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1.25rem 1.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }
        
        /* Override specific background colors for headers */
        .card-header.bg-primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important; color: white !important; }
        .card-header.bg-success { background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%) !important; color: white !important; }
        .card-header.bg-info { background: linear-gradient(135deg, #36b9cc 0%, #258391 100%) !important; color: white !important; }
        .card-header.bg-warning { background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%) !important; color: white !important; }
        .card-header.bg-danger { background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%) !important; color: white !important; }

        /* Modern Tables */
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 0 1px rgba(0,0,0,0.05);
            margin-bottom: 1rem;
        }
        .table {
            margin-bottom: 0;
            color: #5a5c69;
        }
        .table thead th {
            border-bottom: none;
            border-top: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.8px;
            padding: 1.2rem 1rem;
            background-color: #f8f9fc !important;
            color: #858796 !important;
        }
        .table tbody td {
            vertical-align: middle;
            padding: 1rem;
            border-bottom: 1px solid rgba(0,0,0,0.03);
            font-size: 0.9rem;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.015);
        }
        .table-hover tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }
        
        /* Modern Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
            letter-spacing: 0.3px;
        }
        .btn-sm {
            padding: 0.3rem 0.75rem;
            font-size: 0.8rem;
            border-radius: 6px;
        }
        .btn-primary { background-color: #4e73df; border-color: #4e73df; }
        .btn-primary:hover { background-color: #2e59d9; border-color: #2653d4; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(78, 115, 223, 0.3); }
        .btn-success { background-color: #1cc88a; border-color: #1cc88a; }
        .btn-success:hover { background-color: #17a673; border-color: #169b6b; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(28, 200, 138, 0.3); }
        .btn-info { background-color: #36b9cc; border-color: #36b9cc; color: white; }
        .btn-info:hover { background-color: #2c9faf; border-color: #2a96a5; color: white; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(54, 185, 204, 0.3); }
        .btn-warning { background-color: #f6c23e; border-color: #f6c23e; color: #fff; }
        .btn-warning:hover { background-color: #f4b619; border-color: #f3b30d; color: #fff; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(246, 194, 62, 0.3); }
        .btn-danger { background-color: #e74a3b; border-color: #e74a3b; }
        .btn-danger:hover { background-color: #e02d1b; border-color: #d82a1a; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(231, 74, 59, 0.3); }

        /* Form Inputs */
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #d1d3e2;
            padding: 0.6rem 1rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            font-size: 0.9rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #bac8f3;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        label {
            font-weight: 600;
            color: #5a5c69;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        /* Navbar */
        .navbar {
            background-color: #ffffff !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            color: #5a5c69 !important;
        }
        .topbar .nav-item .nav-link {
            height: 4.375rem;
            display: flex;
            align-items: center;
            padding: 0 .75rem;
        }

        /* Pagination */
        .pagination .page-link {
            border-radius: 6px;
            margin: 0 3px;
            border: none;
            color: #4e73df;
            font-weight: 600;
        }
        .pagination .page-item.active .page-link {
            background-color: #4e73df;
            color: white;
            box-shadow: 0 2px 5px rgba(78, 115, 223, 0.3);
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
