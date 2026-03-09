<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pembayaran</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<h3 class="mb-4">💳 Pilih Metode Pembayaran</h3>

<div class="card p-4">

<h5>Total Pembayaran</h5>

<h3 class="text-success">
Rp {{ number_format($product->price) }}
</h3>

<hr>

<form action="{{ route('payment.process') }}" method="POST">

@csrf

<input type="hidden" name="product_id" value="{{ $product->id }}">

<div class="mb-3">

<label class="form-label">Metode Pembayaran</label>

<select name="payment_method" class="form-control">

<option value="qris">QRIS</option>

<option value="va_bca">BCA Virtual Account</option>

<option value="va_bni">BNI Virtual Account</option>

<option value="va_bri">BRI Virtual Account</option>

<option value="va_mandiri">Mandiri Virtual Account</option>

</select>

</div>

<button class="btn btn-success w-100">

Bayar Sekarang

</button>

</form>

</div>

</div>

</body>
</html>