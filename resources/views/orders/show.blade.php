@extends('layouts.app')

@section('content')
<div class="container">

    <h3>Detail Order</h3>

    <p>Status:
        @if($order->status == 'pending')
            <span class="badge bg-warning">Menunggu Pembayaran</span>
        @elseif($order->status == 'paid')
            <span class="badge bg-success">Sudah Dibayar</span>
        @endif
    </p>

    <p>Total: Rp {{ number_format($order->total_price) }}</p>
    <p>Metode: {{ $order->payment_method }}</p>

    @if($order->status == 'pending' && $order->payment_method != 'QRIS')
        <div class="alert alert-warning">
            <h5>Transfer ke Virtual Account:</h5>
            <h4>{{ $order->payment_channel_id }}</h4>
        </div>
    @endif

    @if($order->status == 'pending' && $order->payment_method == 'QRIS')
        <div class="alert alert-warning">
            <h5>Scan QR berikut:</h5>
            <textarea class="form-control">{{ $order->payment_channel_id }}</textarea>
        </div>
    @endif

    <hr>

    <h5>Produk:</h5>

    @foreach($order->items as $item)
        <div class="card mb-2">
            <div class="card-body">
                <strong>{{ $item->product_name }}</strong><br>
                Harga: Rp {{ number_format($item->price) }}<br>
                Qty: {{ $item->quantity }}<br>
                Subtotal: Rp {{ number_format($item->subtotal) }}
            </div>
        </div>
    @endforeach

</div>
@endsection