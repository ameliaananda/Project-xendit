<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Toko Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fa;
        }
        .navbar-admin {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .sidebar {
            background: white;
            border-right: 1px solid #e0e0e0;
            padding: 20px 0;
            min-height: calc(100vh - 60px);
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            border-left: 4px solid transparent;
            transition: all 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #f5f7fa;
            border-left-color: #667eea;
            color: #667eea;
            font-weight: 600;
        }
        .main-content {
            padding: 30px;
        }
        .card-stat {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #667eea;
        }
        .card-stat h6 {
            color: #999;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .card-stat .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }
        .btn-admin {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.2s;
        }
        .btn-admin:hover {
            transform: translateY(-2px);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-admin">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
                🛍️ Admin Panel
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">{{ auth()->user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="row g-0" style="min-height: calc(100vh - 60px);">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <a href="{{ route('admin.dashboard') }}" class="active">📊 Dashboard</a>
            <a href="{{ route('admin.products.index') }}">📦 Kelola Produk</a>
            <a href="{{ route('admin.products.create') }}">➕ Tambah Produk</a>
            <a href="{{ route('shop') }}">👀 Lihat Toko</a>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 main-content">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12">
                        <h2 class="fw-bold mb-1">Dashboard</h2>
                        <p class="text-muted">Selamat datang kembali, {{ auth()->user()->name }}! 👋</p>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="card-stat">
                            <h6>Total Produk</h6>
                            <div class="stat-value">{{ \App\Models\Product::count() }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card-stat">
                            <h6>Total Pesanan</h6>
                            <div class="stat-value">{{ \App\Models\Order::count() }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card-stat">
                            <h6>Total Pengguna</h6>
                            <div class="stat-value">{{ \App\Models\User::count() }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card-stat">
                            <h6>Pesanan Hari Ini</h6>
                            <div class="stat-value">{{ \App\Models\Order::whereDate('created_at', today())->count() }}</div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="fw-bold mb-3">Aksi Cepat</h5>
                        <a href="{{ route('admin.products.create') }}" class="btn-admin me-2">➕ Tambah Produk Baru</a>
                        <a href="{{ route('admin.products.index') }}" class="btn-admin">📦 Kelola Produk</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

