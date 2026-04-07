@extends('admin.layout')

@section('title', 'Kelola Produk')

@section('content')
<div class="space-y-6">
    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Kelola Produk</p>
                <h1 class="mt-2 text-3xl font-semibold text-slate-900">Daftar Produk</h1>
                <p class="mt-2 text-slate-600">Edit, hapus, atau lihat detail produk yang tersedia di toko.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-emerald-500 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-600">➕ Tambah Produk</a>
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center justify-center rounded-2xl bg-slate-800 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-700">📦 Riwayat Pesanan</a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-3xl bg-emerald-50 p-4 text-emerald-800 shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="overflow-hidden rounded-3xl bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-slate-700">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">Produk</th>
                    <th class="px-4 py-3 text-left font-medium">Harga</th>
                    <th class="px-4 py-3 text-left font-medium">Satuan</th>
                    <th class="px-4 py-3 text-left font-medium">Stok</th>
                    <th class="px-4 py-3 text-left font-medium">Diperbarui</th>
                    <th class="px-4 py-3 text-right font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse($products as $product)
                    <tr>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/80x80?text=No+Image' }}" alt="{{ $product->name }}" class="h-16 w-16 rounded-2xl object-cover border border-slate-200" />
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $product->name }}</p>
                                    <p class="text-slate-500 truncate max-w-xs">{{ Illuminate\Support\Str::limit($product->description ?? 'Tidak ada deskripsi', 80) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-slate-900">Rp {{ number_format($product->price) }}</td>
                        <td class="px-4 py-4 text-slate-700">{{ $product->unit ?? 'pcs' }}</td>
                        <td class="px-4 py-4 text-slate-700">{{ $product->stock }}</td>
                        <td class="px-4 py-4 text-slate-500">{{ $product->updated_at->format('d M Y') }}</td>
                        <td class="px-4 py-4 text-right">
                            <div class="inline-flex items-center gap-2">
                                <button type="button" class="rounded-2xl bg-sky-500 px-3 py-2 text-sm font-semibold text-white hover:bg-sky-600" onclick="document.getElementById('detail-{{ $product->id }}').classList.remove('hidden')">Detail</button>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="rounded-2xl bg-amber-500 px-3 py-2 text-sm font-semibold text-white hover:bg-amber-600">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-2xl bg-rose-500 px-3 py-2 text-sm font-semibold text-white hover:bg-rose-600" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <div id="detail-{{ $product->id }}" class="hidden fixed inset-0 z-50 items-center justify-center overflow-y-auto bg-slate-900/70 p-4">
                        <div class="w-full max-w-3xl rounded-3xl bg-white p-6 shadow-2xl">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="text-2xl font-semibold text-slate-900">{{ $product->name }}</h2>
                                    <p class="mt-2 text-slate-600">{{ $product->description ?? 'Tidak ada deskripsi.' }}</p>
                                </div>
                                <button type="button" class="text-slate-500 hover:text-slate-900" onclick="document.getElementById('detail-{{ $product->id }}').classList.add('hidden')">✕</button>
                            </div>
                            <div class="mt-6 grid gap-6 lg:grid-cols-[220px_minmax(0,1fr)]">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/320x240?text=No+Image' }}" alt="{{ $product->name }}" class="h-72 w-full rounded-3xl object-cover border border-slate-200" />
                                <div class="space-y-3">
                                    <div class="rounded-3xl bg-slate-50 p-4">
                                        <p class="text-sm text-slate-500">Harga</p>
                                        <p class="mt-2 text-2xl font-semibold text-slate-900">Rp {{ number_format($product->price) }} / {{ $product->unit ?? 'pcs' }}</p>
                                    </div>
                                    <div class="grid gap-3 sm:grid-cols-2">
                                        <div class="rounded-3xl bg-slate-50 p-4">
                                            <p class="text-sm text-slate-500">Stok</p>
                                            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $product->stock }}</p>
                                        </div>
                                        <div class="rounded-3xl bg-slate-50 p-4">
                                            <p class="text-sm text-slate-500">Terakhir diperbarui</p>
                                            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $product->updated_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 text-right">
                                <button type="button" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800" onclick="document.getElementById('detail-{{ $product->id }}').classList.add('hidden')">Tutup</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-slate-500">Belum ada produk. Tambahkan produk baru untuk mulai berjualan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
