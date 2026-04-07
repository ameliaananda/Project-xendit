<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen">
        <header class="bg-slate-900 text-white shadow">
            <div class="max-w-7xl mx-auto flex flex-col gap-4 px-4 py-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="text-lg font-semibold tracking-tight">🛍️ Admin Panel</a>
                    <span class="inline-flex items-center rounded-full bg-slate-700 px-3 py-1 text-sm text-slate-200">{{ auth()->user()->name }}</span>
                </div>
                <div class="flex flex-wrap items-center gap-2 text-sm">
                    <a href="{{ route('admin.dashboard') }}" class="rounded-full px-4 py-2 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-700 text-white' : 'bg-slate-800/80 text-slate-200 hover:bg-slate-700' }}">Dashboard</a>
                    <a href="{{ route('admin.products.index') }}" class="rounded-full px-4 py-2 {{ request()->routeIs('admin.products.*') ? 'bg-slate-700 text-white' : 'bg-slate-800/80 text-slate-200 hover:bg-slate-700' }}">Produk</a>
                    <a href="{{ route('admin.orders.index') }}" class="rounded-full px-4 py-2 {{ request()->routeIs('admin.orders.*') ? 'bg-slate-700 text-white' : 'bg-slate-800/80 text-slate-200 hover:bg-slate-700' }}">Pesanan</a>
                    <a href="{{ route('shop') }}" class="rounded-full bg-emerald-500 px-4 py-2 text-white hover:bg-emerald-600">Lihat Toko</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="rounded-full bg-slate-700 px-4 py-2 text-slate-200 hover:bg-slate-600">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto grid gap-6 px-4 py-6 sm:px-6 lg:grid-cols-[260px_minmax(0,1fr)] lg:px-8">
            <aside class="space-y-6">
                <div class="rounded-3xl bg-white p-5 shadow-sm">
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Menu Admin</p>
                    <nav class="mt-4 space-y-2">
                        <a href="{{ route('admin.dashboard') }}" class="block rounded-2xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-slate-100 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">Dashboard</a>
                        <a href="{{ route('admin.products.index') }}" class="block rounded-2xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.products.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">Kelola Produk</a>
                        <a href="{{ route('admin.products.create') }}" class="block rounded-2xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.products.create') ? 'bg-slate-100 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">Tambah Produk</a>
                        <a href="{{ route('admin.orders.index') }}" class="block rounded-2xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.orders.*') ? 'bg-slate-100 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">Riwayat Pesanan</a>
                    </nav>
                </div>
            </aside>

            <main class="space-y-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
''