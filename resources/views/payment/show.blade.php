<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    {{-- [REFACTOR] Halaman hasil pembayaran — tampilkan QR atau VA sesuai tipe --}}
    <div class="container mt-5">

        <div class="card p-4 text-center shadow-sm" style="max-width: 500px; margin: 0 auto;">

            <h3 class="mb-4">💳 Pembayaran</h3>

            {{-- [REFACTOR] Tampilkan info order --}}
            <p class="text-muted mb-1">Order ID: <strong>{{ $order->external_id }}</strong></p>
            <p class="mb-4">Total: <strong class="text-success">Rp {{ number_format($amount, 0, ',', '.') }}</strong>
            </p>

            <hr>

            {{-- ================================= --}}
            {{-- QRIS: Tampilkan QR Code           --}}
            {{-- ================================= --}}
            @if ($type == 'qris')
                <h5 class="mt-3">Scan QRIS</h5>

                {{-- [REFACTOR] Generate QR code image dari qr_string --}}
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode($qr_string) }}"
                    class="img-fluid my-3" alt="QRIS QR Code">

                <p class="text-muted">
                    Silahkan scan menggunakan e-wallet / mobile banking
                </p>
            @endif

            {{-- ================================= --}}
            {{-- VA: Tampilkan Nomor Virtual Account --}}
            {{-- ================================= --}}
            @if ($type == 'va')
                <h5 class="mt-3">Virtual Account</h5>

                <p>Bank: <strong>{{ $bank }}</strong></p>

                {{-- [REFACTOR] VA number ditampilkan dengan style yang jelas --}}
                <div class="bg-light border rounded p-3 my-3">
                    <h3 class="text-success mb-0" style="letter-spacing: 2px;">
                        {{ $va_number }}
                    </h3>
                </div>

                <p class="text-muted">
                    Transfer sesuai nominal ke Virtual Account di atas
                </p>
            @endif

            <hr>

            {{-- [REFACTOR] Link ke halaman riwayat pesanan --}}
            <div class="d-flex gap-2 justify-content-center mt-3">
                <a href="{{ route('orders.index') }}" class="btn btn-primary">
                    📦 Lihat Pesanan Saya
                </a>
                <a href="{{ route('shop') }}" class="btn btn-secondary">
                    🛍️ Lanjut Belanja
                </a>
            </div>

        </div>

    </div>

</body>

</html>
