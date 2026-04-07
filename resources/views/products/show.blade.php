<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->name }} - Detail Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('shop') }}">🥭 Toko Online</a>
    </div>
</nav>

<div class="container mt-5">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/800x500' }}" class="card-img-top" style="object-fit:cover; height:420px;" alt="{{ $product->name }}">
                <div class="card-body">
                    <h3 class="card-title">{{ $product->name }}</h3>
                    <p class="text-muted">{{ $product->unit ?? 'pcs' }}</p>
                    <p class="fs-4 fw-bold">Rp {{ number_format($product->price) }} / {{ $product->unit ?? 'pcs' }}</p>
                    <p class="mb-1">Stok tersedia: <strong>{{ $product->stock }}</strong></p>
                    <p class="text-muted">Diperbarui: {{ $product->updated_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Deskripsi Produk</h4>
                    <p class="card-text text-muted">{{ $product->description ?? 'Belum ada deskripsi untuk produk ini.' }}</p>
                    <div class="mt-4 d-grid gap-3">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg" {{ $product->stock < 1 ? 'disabled' : '' }}>🛒 Masuk Keranjang</button>
                        </form>
                        <form action="{{ route('shop.bayar', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg" {{ $product->stock < 1 ? 'disabled' : '' }}>💳 Beli Sekarang</button>
                        </form>
                        <a href="{{ route('shop') }}" class="btn btn-secondary">← Kembali ke Toko</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
