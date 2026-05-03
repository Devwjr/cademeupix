<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CadêMeuPix')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #198754;
            --primary-dark: #146c43;
            --primary-light: #d1e7dd;
            --secondary-color: #212529;
            --accent-color: #20c997;
        }
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        .bg-success { background-color: #198754 !important; }
        .bg-success-dark { background-color: #146c43 !important; }
        .text-success { color: #198754 !important; }
        .text-accent { color: #20c997 !important; }
        .btn-success {
            background-color: #198754;
            border-color: #198754;
            color: #fff;
        }
        .btn-success:hover {
            background-color: #146c43;
            border-color: #146c43;
            color: #fff;
        }
        .btn-outline-primary {
            color: #198754;
            border-color: #198754;
        }
        .btn-outline-primary:hover {
            background-color: #198754;
            color: #fff;
        }
        .btn-success {
            background-color: #198754;
            border-color: #198754;
        }
        .btn-success:hover {
            background-color: #146c43;
            border-color: #146c43;
        }
        .navbar {
            background: linear-gradient(135deg, #198754 0%, #20c997 100%) !important;
            box-shadow: 0 2px 10px rgba(25,135,84,0.3);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: -0.5px;
        }
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            transition: all 0.3s;
        }
        .nav-link:hover {
            color: #fff !important;
            transform: translateY(-1px);
        }
        .nav-link.active {
            color: #fff !important;
            border-bottom: 2px solid #fff;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        }
        .card-header {
            background-color: #198754;
            color: #fff;
            border-radius: 12px 12px 0 0 !important;
            border: none;
            padding: 1rem 1.25rem;
        }
        .btn-close-white {
            filter: brightness(0) invert(1);
        }
        .badge {
            font-weight: 600;
            padding: 0.4em 0.8em;
        }
        .table thead th {
            background-color: #198754;
            color: #fff;
            border: none;
            font-weight: 600;
            padding: 0.75rem 1rem;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(25,135,84,0.08);
        }
        .form-control:focus, .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.25rem rgba(25,135,84,0.25);
        }
        .page-link {
            color: #198754;
            border-color: #dee2e6;
        }
        .page-link:hover {
            background-color: #d1e7dd;
            border-color: #198754;
            color: #146c43;
        }
        .page-item.active .page-link {
            background-color: #198754;
            border-color: #198754;
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            border-radius: 8px;
        }
        .dropdown-item:hover {
            background-color: #d1e7dd;
            color: #146c43;
        }
        .alert {
            border: none;
            border-radius: 10px;
        }
        .toast {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .input-group-text {
            background-color: #d1e7dd;
            border-color: #198754;
            color: #146c43;
        }
        a {
            color: #198754;
            text-decoration: none;
        }
        a:hover {
            color: #146c43;
        }
        .footer {
            background-color: #198754;
            color: #fff;
            padding: 2rem 0;
            margin-top: 4rem;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @auth
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="bi bi-wallet2 me-2"></i>CadêMeuPix
            </a>
            <button class="navbar-toggler border-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}" href="{{ route('clientes.index') }}">
                            <i class="bi bi-people me-1"></i> Clientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dividas.*') ? 'active' : '' }}" href="{{ route('dividas.index') }}">
                            <i class="bi bi-currency-dollar me-1"></i> Dívidas
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><span class="dropdown-item-text text-muted small">{{ auth()->user()->email }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i> Sair
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endauth

    <main class="@auth py-4 @else min-vh-100 d-flex align-items-center @endauth">
        @yield('content')
    </main>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        @if(session('success'))
            <div class="toast show align-items-center text-bg-success border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="toast show align-items-center text-bg-danger border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-circle me-2"></i> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
        @if(session('info'))
            <div class="toast show align-items-center text-bg-info border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-info-circle me-2"></i> {{ session('info') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
