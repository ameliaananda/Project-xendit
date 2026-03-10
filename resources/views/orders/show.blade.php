@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <h3 class="mb-4">📋 Detail Order</h3>

        {{-- [REFACTOR] Info order dasar --}}
        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Order ID:</strong> {{ $order->external_id }}</p>

                <p><strong>Status:</strong>
                    @if ($order->status == 'pending')
                        <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                    @elseif($order->status == 'paid')
                        <span class="badge bg-success">Sudah Dibayar</span>
                    @elseif($order->status == 'expired')
                        <span class="badge bg-secondary">Expired</span>
                    @elseif($order->status == 'failed')
                        <span class="badge bg-danger">Gagal</span>
                    @endif
                </p>

                {{-- [FIX] Perbaiki: total_price → total_amount (sesuai kolom di database) --}}
                <p><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>

                @if ($order->payment_method)
                    <p><strong>Metode:</strong> {{ $order->payment_method }}</p>
                @endif

                @if ($order->paid_at)
                    <p><strong>Dibayar pada:</strong> {{ $order->paid_at->format('d-m-Y H:i') }}</p>
                @endif
            </div>
        </div>

        {{-- [REFACTOR] Info pembayaran jika status masih pending --}}
        @if ($order->status == 'pending')
            {{-- Virtual Account --}}
            @if ($order->va_number)
                <div class="alert alert-warning">
                    <h5>💳 Transfer ke Virtual Account:</h5>
                    <p>Bank: <strong>{{ $order->bank }}</strong></p>
                    <h4 class="text-success" style="letter-spacing: 2px;">{{ $order->va_number }}</h4>
                    <p class="text-muted mb-0">Transfer sesuai nominal ke Virtual Account di atas</p>
                </div>
            @endif

            {{-- QRIS --}}
            @if ($order->payment_method == 'QRIS' && $order->payment_channel_id)
                <div class="alert alert-warning text-center">
                    <h5>📱 Scan QR Code:</h5>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode($order->payment_channel_id) }}"
                        class="img-fluid my-2" alt="QRIS QR Code">
                    <p class="text-muted mb-0">Scan menggunakan e-wallet / mobile banking</p>
                </div>
            @endif

            {{-- [REFACTOR] Link bayar ulang jika belum ada metode pembayaran --}}
            @if (!$order->payment_method)
                <a href="{{ route('checkout', ['order_id' => $order->id]) }}" class="btn btn-success mb-4">
                    💳 Bayar Sekarang
                </a>
            @endif
        @endif

        <hr>

        {{-- [REFACTOR] Daftar item dalam order --}}
        <h5>🛍️ Produk:</h5>

        @foreach ($order->items as $item)
            <div class="card mb-2">
                <div class="card-body d-flex align-items-center gap-3">
                    @if ($item->product_image)
                        <img src="{{ asset('storage/' . $item->product_image) }}"
                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                    @endif
                    <div>
                        <strong>{{ $item->product_name }}</strong><br>
                        Harga: Rp {{ number_format($item->price, 0, ',', '.') }}<br>
                        Qty: {{ $item->quantity }}<br>
                        Subtotal: <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- [REFACTOR] Navigasi --}}
        <div class="mt-4">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">← Kembali ke Daftar Pesanan</a>
            <a href="{{ route('shop') }}" class="btn btn-primary">🛍️ Lanjut Belanja</a>
        </div>

    </div>
@endsection
