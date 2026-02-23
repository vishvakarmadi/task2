<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventory System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f5f5f5; }
        .sidebar {
            background: #fff;
            min-height: calc(100vh - 56px);
            border-right: 1px solid #dee2e6;
        }
        .sidebar .nav-link {
            color: #555;
            padding: 10px 16px;
            margin: 2px 8px;
            border-radius: 6px;
            font-size: 14px;
        }
        .sidebar .nav-link:hover { background: #f0f0f0; color: #333; }
        .sidebar .nav-link.active { background: #0d6efd; color: #fff; }
        .sidebar .nav-link i { width: 20px; }
        .sidebar-heading {
            font-size: 11px;
            text-transform: uppercase;
            color: #999;
            padding: 12px 18px 4px;
            font-weight: 600;
        }
        .card { border: 1px solid #e9ecef; border-radius: 8px; }
        .stat-card { border-left: 3px solid; }
        .table thead th {
            background: #f8f9fa;
            font-size: 13px;
            font-weight: 600;
            color: #666;
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid px-3">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-warehouse me-1"></i> Inventory System
            </a>
            <div class="navbar-nav ms-auto">
                @auth
                    <span class="nav-link text-light">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm ms-2">Logout</button>
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
                    <div class="sidebar-heading">Menu</div>
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-home me-2"></i>Dashboard
                    </a>
                    <div class="sidebar-heading mt-1">Inventory</div>
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                        <i class="fas fa-box me-2"></i>Products
                    </a>
                    <a class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                        <i class="fas fa-shopping-cart me-2"></i>Sales
                    </a>
                    <a class="nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}" href="{{ route('purchases.index') }}">
                        <i class="fas fa-truck me-2"></i>Purchases
                    </a>
                    <div class="sidebar-heading mt-1">Accounting</div>
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
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
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
