@extends('admin.layout')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="space-y-6">
    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Riwayat Pesanan</p>
                <h1 class="mt-2 text-3xl font-semibold text-slate-900">Semua Pesanan</h1>
                <p class="mt-2 text-slate-600">Lihat detail pesanan pelanggan dan status pembayaran.</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Kembali ke Produk</a>
        </div>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Jumlah pesanan</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $orders->total() }}</p>
            </div>
            <p class="text-sm text-slate-500">Menampilkan {{ $orders->count() }} pesanan terakhir.</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-3xl bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-slate-700">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">Order</th>
                    <th class="px-4 py-3 text-left font-medium">Pelanggan</th>
                    <th class="px-4 py-3 text-left font-medium">Total</th>
                    <th class="px-4 py-3 text-left font-medium">Status</th>
                    <th class="px-4 py-3 text-left font-medium">Tanggal</th>
                    <th class="px-4 py-3 text-right font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-4 py-4 text-slate-900">{{ $order->external_id ?? '#'.$order->id }}</td>
                        <td class="px-4 py-4 text-slate-700">{{ $order->user?->name ?? 'Pengguna hilang' }}</td>
                        <td class="px-4 py-4 text-slate-900">Rp {{ number_format($order->total_amount) }}</td>
                        <td class="px-4 py-4">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $order->status === 'paid' ? 'bg-emerald-100 text-emerald-700' : ($order->status === 'failed' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="px-4 py-4 text-slate-500">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center rounded-2xl bg-slate-900 px-4 py-2 text-white hover:bg-slate-700">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-slate-500">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-sm">
        {{ $orders->links() }}
    </div>
</div>
@endsection
