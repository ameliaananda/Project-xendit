<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Pesanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<h3 class="mb-4">📦 Pesanan Saya</h3>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

@if($orders->isEmpty())

<div class="alert alert-warning">
Belum ada pesanan
</div>

<a href="{{ route('shop') }}" class="btn btn-primary">
Kembali Belanja
</a>

@else

<table class="table table-bordered">
<thead class="table-success">
<tr>
<th>ID Order</th>
<th>Total</th>
<th>Status</th>
<th>Tanggal</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($orders as $order)

<tr>
<td>{{ $order->external_id }}</td>

<td>
Rp {{ number_format($order->total_amount) }}
</td>

<td>
<span class="badge bg-warning">
{{ $order->status }}
</span>
</td>

<td>
{{ $order->created_at->format('d-m-Y') }}
</td>

<td>
<a href="{{ route('orders.show',$order->id) }}" class="btn btn-sm btn-primary">
Detail
</a>
</td>

</tr>

@endforeach

</tbody>
</table>

@endif

</div>

</body>
</html>