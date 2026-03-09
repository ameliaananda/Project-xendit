<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<title>Pembayaran</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card p-4 text-center">

<h3 class="mb-4">💳 Pembayaran</h3>

@if($type == "qris")

<h5>Scan QRIS</h5>

<img 
src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ $qr_string }}"
class="img-fluid"
>

<p class="mt-3">
Silahkan scan menggunakan e-wallet / mobile banking
</p>

@endif


@if($type == "va")

<h5>Virtual Account</h5>

<p>Bank : <b>{{ $bank }}</b></p>

<h3 class="text-success">
{{ $va_number }}
</h3>

<p>Transfer sesuai nominal ke Virtual Account diatas</p>

@endif

<a href="/" class="btn btn-secondary mt-3">
Kembali
</a>

</div>

</div>

</body>
</html>