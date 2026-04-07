@extends('admin.layout')

@section('title', 'Edit Produk')

@section('content')
<div class="space-y-6">
    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Edit Produk</p>
                <h1 class="mt-2 text-3xl font-semibold text-slate-900">{{ $product->name }}</h1>
            </div>
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">← Kembali</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="rounded-3xl bg-rose-50 p-5 text-rose-700 shadow-sm">
            <p class="font-semibold">Terjadi kesalahan:</p>
            <ul class="mt-3 list-disc space-y-1 pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid gap-6 lg:grid-cols-2">
                <label class="space-y-2">
                    <span class="text-sm font-semibold text-slate-700">Nama Produk</span>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-400 focus:outline-none" required>
                </label>
                <label class="space-y-2">
                    <span class="text-sm font-semibold text-slate-700">Satuan Produk</span>
                    <input type="text" name="unit" value="{{ old('unit', $product->unit) }}" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-400 focus:outline-none" placeholder="contoh: kg / pcs" required>
                </label>
                <label class="space-y-2">
                    <span class="text-sm font-semibold text-slate-700">Harga Produk</span>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" step="0.01" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-400 focus:outline-none" required>
                </label>
                <label class="space-y-2">
                    <span class="text-sm font-semibold text-slate-700">Stok Produk</span>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-400 focus:outline-none" required>
                </label>
            </div>

            <label class="space-y-2">
                <span class="text-sm font-semibold text-slate-700">Deskripsi Produk</span>
                <textarea name="description" rows="5" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-400 focus:outline-none">{{ old('description', $product->description) }}</textarea>
            </label>

            <div class="grid gap-6 lg:grid-cols-[200px_minmax(0,1fr)]">
                <div class="space-y-2">
                    <span class="text-sm font-semibold text-slate-700">Gambar Produk</span>
                    <input type="file" name="image" accept="image/*" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-slate-400 focus:outline-none">
                </div>
                @if($product->image)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-sm text-slate-500">Gambar saat ini</p>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="mt-3 h-56 w-full rounded-3xl object-cover" />
                    </div>
                @endif
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                <a href="{{ route('admin.products.index') }}" class="rounded-3xl border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</a>
                <button type="submit" class="rounded-3xl bg-amber-500 px-6 py-3 text-sm font-semibold text-white hover:bg-amber-600">Perbarui Produk</button>
            </div>
        </form>
    </div>
</div>
@endsection
