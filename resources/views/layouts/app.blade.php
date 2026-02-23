<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventory Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #eef2ff;
            --success: #059669;
            --danger: #dc2626;
            --warning: #d97706;
            --info: #0891b2;
            --bg: #f1f5f9;
            --sidebar-bg: #1e293b;
            --sidebar-text: #94a3b8;
            --sidebar-active: #e2e8f0;
            --card-shadow: 0 4px 24px rgba(0,0,0,0.06);
        }
        * { font-family: 'Inter', sans-serif; }
        body { background: var(--bg); min-height: 100vh; }
        .navbar {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;
            box-shadow: 0 2px 16px rgba(0,0,0,0.12);
        }
        .navbar-brand { font-weight: 800; font-size: 1.35rem; letter-spacing: -0.5px; }
        .navbar-brand i { color: #818cf8; }
        .sidebar {
            background: white;
            min-height: calc(100vh - 56px);
            box-shadow: 2px 0 20px rgba(0,0,0,0.04);
            border-right: 1px solid #e2e8f0;
        }
        .sidebar .nav-link {
            color: #475569;
            padding: 11px 18px;
            border-radius: 10px;
            margin: 3px 12px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        .sidebar .nav-link:hover {
            background: var(--primary-light);
            color: var(--primary);
            transform: translateX(3px);
        }
        .sidebar .nav-link.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(79,70,229,0.3);
        }
        .sidebar .nav-link i { width: 22px; text-align: center; }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover { box-shadow: 0 8px 32px rgba(0,0,0,0.08); }
        .stat-card {
            border-left: 4px solid;
            transition: transform 0.25s ease;
            position: relative;
            overflow: hidden;
        }
        .stat-card::after {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.06;
        }
        .stat-card:hover { transform: translateY(-4px); }
        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 20px;
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79,70,229,0.3);
        }
        .table { border-radius: 12px; overflow: hidden; }
        .table thead th {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
        }
        .table tbody tr { transition: background 0.15s ease; }
        .table tbody tr:hover { background: #f8fafc; }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 10px 14px;
            border: 2px solid #e2e8f0;
            transition: all 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }
        .modal-content { border-radius: 16px; border: none; }
        .modal-header { border-bottom: 1px solid #f1f5f9; }
        .badge { font-weight: 600; padding: 5px 10px; border-radius: 6px; }
        .alert { border-radius: 12px; border: none; }
        .sidebar-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            padding: 15px 22px 6px;
            font-weight: 700;
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-warehouse me-2"></i>Inventory System
            </a>
            <div class="navbar-nav ms-auto">
                @auth
                    <span class="nav-link text-white opacity-75">
                        <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm ms-2" style="border-radius:8px;">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            @auth
            <div class="col-md-2 sidebar p-0">
                <nav class="nav flex-column mt-2">
                    <div class="sidebar-label">Main</div>
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <div class="sidebar-label mt-2">Inventory</div>
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                        <i class="fas fa-box me-2"></i>Products
                    </a>
                    <a class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                        <i class="fas fa-cash-register me-2"></i>Sales
                    </a>
                    <a class="nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}" href="{{ route('purchases.index') }}">
                        <i class="fas fa-truck me-2"></i>Purchases
                    </a>
                    <div class="sidebar-label mt-2">Accounting</div>
                    <a class="nav-link {{ request()->routeIs('journal.*') ? 'active' : '' }}" href="{{ route('journal.index') }}">
                        <i class="fas fa-book me-2"></i>Journal
                    </a>
                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                        <i class="fas fa-chart-bar me-2"></i>Reports
                    </a>
                </nav>
            </div>
            <div class="col-md-10 p-4">
            @else
            <div class="col-12 p-4">
            @endauth
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach($errors->all() as $error)
                            <p class="mb-0"><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</p>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
