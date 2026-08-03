<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-main: #0d0e12;
            --bg-sidebar: #111318;
            --bg-card: #16181f;
            --bg-elevated: #1c1f28;
            --border-subtle: #24272f;
            --accent: #e63946;
            --accent-hover: #d62839;
            --accent-soft: rgba(230,57,70,.12);
            --gold: #e0cf13;
            --text-primary: #f1f2f4;
            --text-secondary: #8b8f9a;
            --text-muted: #5a5e68;
            --radius: 12px;
        }

        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            background: var(--bg-main);
            color: var(--text-primary);
            font-family: 'Inter', -apple-system, sans-serif;
            font-size: 14.5px;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            min-height: 100vh;
            width: 264px;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border-subtle);
            padding: 22px 16px;
            display: flex;
            flex-direction: column;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: 32px;
            padding: 8px 10px;
        }
        .brand:hover { text-decoration: none; }
        .brand img {
            width: 42px;
            height: 42px;
            object-fit: contain;
            border-radius: 9px;
        }
        .brand span {
            color: var(--gold);
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -.3px;
        }

        .nav-section-label {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            padding: 6px 14px;
            margin-top: 8px;
        }

        .sidebar a.nav-link-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            margin-bottom: 3px;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            transition: all .18s ease;
        }
        .sidebar a.nav-link-item i {
            font-size: 17px;
            width: 20px;
            text-align: center;
        }
        .sidebar a.nav-link-item:hover {
            background: var(--bg-elevated);
            color: var(--text-primary);
        }
        .sidebar a.nav-link-item.active {
            background: var(--accent-soft);
            color: var(--accent);
            font-weight: 600;
        }
        .sidebar a.nav-link-item.active i { color: var(--accent); }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid var(--border-subtle);
        }
        .btn-logout {
            width: 100%;
            background: transparent;
            border: 1px solid var(--border-subtle);
            color: var(--text-secondary);
            border-radius: 10px;
            padding: 10px;
            font-size: 14px;
            font-weight: 500;
            transition: all .18s ease;
        }
        .btn-logout:hover {
            background: var(--accent-soft);
            border-color: var(--accent);
            color: var(--accent);
        }

        /* ===== MAIN AREA ===== */
        .flex-fill { background: var(--bg-main); min-height: 100vh; }

        h1,h2,h3,h4,h5,h6 { color: var(--text-primary); font-weight: 700; letter-spacing: -.3px; }
        p, label, span { color: var(--text-primary); }

        /* ===== TOP BAR ===== */
        .admin-topbar {
            background: var(--bg-sidebar);
            border-bottom: 1px solid var(--border-subtle);
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .breadcrumb-text { color: var(--text-muted); font-size: 13.5px; }
        .breadcrumb-text strong { color: var(--text-primary); font-weight: 600; }

        .btn-viewsite {
            background: var(--bg-elevated);
            border: 1px solid var(--border-subtle);
            color: var(--text-primary);
            border-radius: 8px;
            padding: 7px 16px;
            font-size: 13.5px;
            font-weight: 500;
            transition: all .18s ease;
        }
        .btn-viewsite:hover {
            background: var(--accent-soft);
            border-color: var(--accent);
            color: var(--accent);
        }

        .admin-avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent), #b8202b);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #fff;
            font-size: 15px;
        }

        .content-body { padding: 28px 32px; }

        /* ===== CARDS ===== */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius);
            color: var(--text-primary);
        }
        .card-header {
            background: transparent;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-subtle);
            font-weight: 600;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius);
            padding: 22px;
            transition: transform .2s ease, border-color .2s ease;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            border-color: #333743;
        }
        .stat-label {
            color: #ffffff;
            font-size: 12.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .6px;
        }
        .stat-value {
            font-size: 26px;
            font-weight: 800;
            margin-top: 6px;
            letter-spacing: -.5px;
        }
        .stat-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* ===== TABLE ===== */
        .table { color: var(--text-primary) !important; border-color: var(--border-subtle); }
        .table thead th {
            background: #000000 !important;
            color: var(--text-secondary) !important;
            border-color: var(--border-subtle);
            font-size: 12.5px;
            text-transform: uppercase;
            letter-spacing: .5px;
            font-weight: 600;
            padding: 14px 16px;
        }
        .table tbody td {
            background: #000000 !important;
            color: var(--text-primary) !important;
            border-color: var(--border-subtle);
            padding: 14px 16px;
            vertical-align: middle;
        }
        .table-hover tbody tr:hover td { background: var(--bg-elevated) !important; }

        /* ===== INPUTS ===== */
        .form-control {
            background: var(--bg-elevated);
            color: var(--text-primary);
            border: 1px solid var(--border-subtle);
            border-radius: 9px;
            padding: 9px 14px;
        }
        .form-control::placeholder { color: var(--text-muted); }
        .form-control:focus {
            background: var(--bg-elevated);
            color: var(--text-primary);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-soft);
        }
   /* ===== SELECT ===== */

.form-select{
    background: var(--bg-elevated);
    color: var(--text-primary);
    border: 1px solid var(--border-subtle);
    border-radius: 9px;
    padding: 9px 14px;
}

.form-select:focus{
    background: var(--bg-elevated);
    color: var(--text-primary);
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-soft);
}

/* Only dropdown options */
.form-select option{
    background: var(--bg-elevated);
    color: #ffffff;
}

/* Selected option */
.form-select option:checked{
    background: var(--accent);
    color: #ffffff;
}


        /* ===== BUTTONS ===== */
        .btn-primary {
            background: var(--accent);
            border: none;
            border-radius: 9px;
            font-weight: 600;
            padding: 9px 18px;
        }
        .btn-primary:hover { background: var(--accent-hover); }
        .btn-danger { background: #dc3545; border-radius: 9px; font-weight: 500; }
        .btn-warning { color: #fff; border-radius: 9px; }
        .btn-outline-light { border-radius: 9px; }

        /* ===== ALERTS ===== */
        .alert {
            border-radius: 10px;
            border: none;
            font-size: 14px;
            padding: 12px 18px;
        }
        .alert-success { background: rgba(40,167,69,.15); color: #4ade80; }
        .alert-danger { background: rgba(220,53,69,.15); color: #f87171; }

        /* ===== DROPDOWN ===== */
        .dropdown-menu { background: var(--bg-elevated); border: 1px solid var(--border-subtle); border-radius: 10px; }
        .dropdown-item { color: var(--text-primary); }
        .dropdown-item:hover { background: var(--bg-card); }

        /* ===== PAGINATION ===== */
        .page-link {
            background: var(--bg-card);
            color: var(--text-primary);
            border-color: var(--border-subtle);
        }
        .page-link:hover { background: var(--bg-elevated); color: var(--text-primary); }
        .page-item.active .page-link { background: var(--accent); border-color: var(--accent); }

        /* ===== LINKS ===== */
        a { color: #6ea8fe; }
        a:hover { color: #9ec5fe; }

        /* ===== BADGES ===== */
        .badge { border-radius: 6px; font-weight: 600; padding: 5px 10px; }
    </style>

</head>

<body>

<div class="d-flex">

    <div class="sidebar">

        <a href="{{ route('admin.dashboard') }}" class="brand">
            <img src="{{ asset('images/logo.jpg') }}" alt="TrackForge Logo">
            <span>TrackForge</span>
        </a>

        <div class="nav-section-label">Main</div>

        <a href="{{ route('admin.dashboard') }}" class="nav-link-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section-label">Catalog</div>

        <a href="{{ route('admin.products.index') }}" class="nav-link-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Products
        </a>
        <a href="{{ route('brands.index') }}" class="nav-link-item {{ request()->routeIs('brands.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Brands
        </a>
        <a href="{{ route('admin.categories.index') }}" class="nav-link-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="bi bi-folder2-open"></i> Categories
        </a>

        <div class="nav-section-label">Sales</div>

        <a href="{{ route('admin.orders.index') }}" class="nav-link-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i> Orders
        </a>

        <a href="{{ route('admin.coupons.index') }}" class="nav-link-item {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
            <i class="bi bi-ticket-perforated"></i> Coupons
        </a>
        <a href="{{ route('admin.newsletter.index') }}" class="nav-link-item {{ request()->routeIs('admin.newsletter.*') ? 'active' : '' }}">
            <i class="bi bi-envelope-paper"></i> Newsletter
        </a>

        <div class="nav-section-label">System</div>

        <a href="{{ route('admin.settings.edit') }}" class="nav-link-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="bi bi-gear"></i> Settings
        </a>
        <a href="{{ route('admin.reviews.index') }}" class="nav-link-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="bi bi-star"></i> Reviews
        </a>

        <div class="text-center small mt-3 mb-2" style="color: var(--text-muted); font-size: 11px;">
            Developed by Hafsa
        </div>

        <div class="sidebar-footer">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="btn-logout">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </div>

    </div>

    <div class="flex-fill">

        <div class="admin-topbar">
            <div class="breadcrumb-text">
                Admin / <strong>@yield('title', 'Dashboard')</strong>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="btn-viewsite">
                    <i class="bi bi-box-arrow-up-right me-1"></i> View Site
                </a>
                <div class="admin-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </div>

        <div class="content-body">

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
