@extends('admin.layout')

@section('title', 'Detail Pesanan')

@section('content')
<div class="space-y-6">
    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Detail Pesanan</p>
                <h1 class="mt-2 text-3xl font-semibold text-slate-900">{{ $order->external_id ?? '#'.$order->id }}</h1>
                <p class="mt-2 text-slate-600">Pesanan oleh {{ $order->user?->name ?? 'Pengguna' }} — {{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Kembali ke Pesanan</a>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Status Pesanan</p>
            <p class="mt-3 text-2xl font-semibold text-slate-900">{{ ucfirst($order->status) }}</p>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Total Bayar</p>
            <p class="mt-3 text-2xl font-semibold text-slate-900">Rp {{ number_format($order->total_amount) }}</p>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Metode Pembayaran</p>
            <p class="mt-3 text-2xl font-semibold text-slate-900">{{ $order->payment_method ?? 'Belum dipilih' }}</p>
        </div>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold text-slate-900">Item Pesanan</h2>
        <div class="mt-5 space-y-4">
            @foreach($order->items as $item)
                <div class="rounded-3xl border border-slate-200 p-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-lg font-semibold text-slate-900">{{ $item->product_name }}</p>
                            <p class="text-sm text-slate-500">Harga: Rp {{ number_format($item->price) }} | Qty: {{ $item->quantity }}</p>
                        </div>
                        <p class="text-lg font-semibold text-slate-900">Rp {{ number_format($item->subtotal) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
