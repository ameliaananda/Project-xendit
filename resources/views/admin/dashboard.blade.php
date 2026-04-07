@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Dashboard Admin</p>
                <h1 class="mt-2 text-3xl font-semibold text-slate-900">Selamat datang, {{ auth()->user()->name }}</h1>
                <p class="mt-2 text-slate-600">Kelola produk, lihat pesanan, dan pantau performa toko dari satu panel.</p>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-emerald-500 px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-emerald-200 hover:bg-emerald-600">➕ Tambah Produk</a>
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-800 px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-slate-300 hover:bg-slate-700">📦 Riwayat Pesanan</a>
            </div>
        </div>
    </div>

    <div class="grid gap-4 xl:grid-cols-4 lg:grid-cols-2">
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Total Produk</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ \App\Models\Product::count() }}</p>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Total Pesanan</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ \App\Models\Order::count() }}</p>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Total Pengguna</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ \App\Models\User::count() }}</p>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Pesanan Hari Ini</p>
            <p class="mt-4 text-4xl font-semibold text-slate-900">{{ \App\Models\Order::whereDate('created_at', today())->count() }}</p>
        </div>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold text-slate-900">Ringkasan Cepat</h2>
        <div class="mt-4 grid gap-4 md:grid-cols-3">
            <div class="rounded-3xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Produk Terbaru</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ \App\Models\Product::latest()->first()?->name ?? 'Tidak ada produk' }}</p>
            </div>
            <div class="rounded-3xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Pesanan Hari Ini</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ \App\Models\Order::whereDate('created_at', today())->count() }}</p>
            </div>
            <div class="rounded-3xl bg-slate-50 p-4">
                <p class="text-sm text-slate-500">Toko Online</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ config('app.name', 'Project Xendit') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

