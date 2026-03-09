@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow mt-6">

<h2 class="text-2xl font-bold text-center mb-6">
Keranjang Belanja
</h2>

@if($carts->count() > 0)

<table class="w-full border border-gray-300 text-center">

<thead style="background:#2563eb;color:white;">
<tr>
<th class="border p-3">Produk</th>
<th class="border p-3">Harga</th>
<th class="border p-3">Jumlah</th>
<th class="border p-3">Total</th>
<th class="border p-3">Aksi</th>
</tr>
</thead>

<tbody>

@php $grandTotal = 0; @endphp

@foreach($carts as $cart)

@php
$total = $cart->product->price * $cart->quantity;
$grandTotal += $total;
@endphp

<tr>

<td class="border p-3">
{{ $cart->product->name }}
</td>

<td class="border p-3">
Rp {{ number_format($cart->product->price,0,',','.') }}
</td>

<td class="border p-3">

<div style="display:flex;justify-content:center;align-items:center;gap:10px;">

<form action="{{ route('cart.update',$cart->id) }}" method="POST">
@csrf
<input type="hidden" name="action" value="minus">
<button type="submit"
style="background:#e5e7eb;padding:4px 10px;border-radius:5px;">
-
</button>
</form>

<b>{{ $cart->quantity }}</b>

<form action="{{ route('cart.update',$cart->id) }}" method="POST">
@csrf
<input type="hidden" name="action" value="plus">
<button type="submit"
style="background:#16a34a;color:white;padding:4px 10px;border-radius:5px;">
+
</button>
</form>

</div>

</td>

<td class="border p-3" style="color:green;font-weight:bold;">
Rp {{ number_format($total,0,',','.') }}
</td>

<td class="border p-3">

<form action="{{ route('cart.remove',$cart->id) }}" method="POST">
@csrf
@method('DELETE')

<button style="background:#ef4444;color:white;padding:5px 10px;border-radius:5px;">
Hapus
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

<div style="display:flex;justify-content:space-between;margin-top:25px;align-items:center;">

<a href="/shop"
style="background:#6b7280;color:white;padding:10px 15px;border-radius:6px;">
← Kembali Belanja
</a>

<h3>
Grand Total :
<span style="color:red">
Rp {{ number_format($grandTotal,0,',','.') }}
</span>
</h3>

<a href="/checkout"
style="background:#16a34a;color:white;padding:10px 15px;border-radius:6px;">
Checkout →
</a>

</div>

@else

<p class="text-center text-gray-500">
Keranjang masih kosong
</p>

@endif

</div>

@endsection