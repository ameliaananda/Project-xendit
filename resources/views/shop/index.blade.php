<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Toko Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('shop') }}">
            🥭 Toko Online
        </a>

       <div class="d-flex gap-2">

        <a href="{{ route('cart.index') }}" class="btn btn-light">
            🛒 Keranjang
            <span class="badge bg-danger">
            {{ count(session('cart', [])) }}
                </span>
                </a>

<a href="{{ route('orders.index') }}" class="btn btn-warning">
📦 Riwayat Pesanan
</a>

</div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container mt-5">

    <h3 class="mb-4 text-center">🛍️ Daftar Produk</h3>


    <!-- TAMBAH PRODUK KHUSUS ADMIN -->
    @auth
    @if(auth()->user()->role == 'admin')

    <div class="text-end mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-success">
            ➕ Tambah Produk
        </a>
    </div>

    @endif
    @endauth


    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">

                <!-- GAMBAR -->
                <img
                    src="{{ $product->image 
                        ? asset('storage/' . $product->image) 
                        : 'https://via.placeholder.com/300x200' }}"
                    class="card-img-top"
                    style="height:200px; object-fit:cover;"
                >

                <div class="card-body text-center">
                    <h5 class="card-title">{{ $product->name }}</h5>

                    <p class="fw-bold mb-1">
                        Rp {{ number_format($product->price) }} / kg
                    </p>

                    <p class="text-muted">
                        Stok: {{ $product->stock }}
                    </p>

                    <!-- MASUK KERANJANG -->
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100">
                            🛒 Masuk Keranjang
                        </button>
                    </form>

                    <!-- BELI SEKARANG -->
                    <form action="{{ route('shop.bayar', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            💳 Beli Sekarang
                            
                        </button>
                    </form>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

</body>
</html>