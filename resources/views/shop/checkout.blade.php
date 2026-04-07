@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-xl mx-auto px-4">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-green-50 rounded-full mb-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <h1 class="text-xl font-semibold text-gray-900">Checkout</h1>
            <p class="text-sm text-gray-500 mt-1">Lengkapi pembayaran Anda</p>
        </div>

        {{-- Progress --}}
        <div class="flex items-center justify-center gap-2 mb-8">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <span class="text-sm text-green-600 font-medium">Keranjang</span>
            </div>
            <div class="w-8 h-px bg-gray-300"></div>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-gray-900 flex items-center justify-center">
                    <span class="text-xs font-semibold text-white">2</span>
                </div>
                <span class="text-sm text-gray-900 font-medium">Checkout</span>
            </div>
            <div class="w-8 h-px bg-gray-200"></div>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center">
                    <span class="text-xs font-semibold text-gray-400">3</span>
                </div>
                <span class="text-sm text-gray-400">Pembayaran</span>
            </div>
        </div>

        <div class="space-y-3">

            {{-- Ringkasan Pesanan --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-800">Ringkasan pesanan</span>
                </div>
                <div class="px-5 py-4">
                    @if (isset($order) && $order)
                        @foreach ($items as $item)
                            <div class="flex items-center gap-3 py-3 border-b border-gray-100 last:border-0">
                                @if($item->product_image)
                                    <img src="{{ asset('storage/' . $item->product_image) }}" class="w-12 h-12 rounded-lg object-cover border border-gray-100 flex-shrink-0"/>
                                @else
                                    <div class="w-12 h-12 bg-gray-50 rounded-lg border border-gray-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $item->product_name }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Qty: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($item->subtotal) }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">@ Rp {{ number_format($item->price) }}</p>
                                </div>
                            </div>
                        @endforeach
                    @elseif(isset($carts))
                        @foreach ($carts as $cart)
                            <div class="flex items-center gap-3 py-3 border-b border-gray-100 last:border-0">
                                @if($cart->product->image)
                                    <img src="{{ asset('storage/' . $cart->product->image) }}" class="w-12 h-12 rounded-lg object-cover border border-gray-100 flex-shrink-0"/>
                                @else
                                    <div class="w-12 h-12 bg-gray-50 rounded-lg border border-gray-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $cart->product->name }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Qty: {{ $cart->quantity }} {{ $cart->product->unit ?? 'pcs' }}</p>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($cart->product->price * $cart->quantity) }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">@ Rp {{ number_format($cart->product->price) }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    {{-- Total --}}
                    <div class="flex items-center justify-between pt-4 mt-1">
                        <span class="text-sm font-medium text-gray-700">Total pembayaran</span>
                        <span class="text-lg font-semibold text-green-600">Rp {{ number_format($grandTotal) }}</span>
                    </div>
                </div>
            </div>

            {{-- Konfirmasi dari Cart --}}
            @if ($fromCart && !isset($order))
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <form action="{{ route('checkout.order') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium py-3 px-5 rounded-lg transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Konfirmasi pesanan & lanjut ke pembayaran
                        </button>
                    </form>
                </div>
            @endif

            {{-- Metode Pembayaran --}}
            @if (isset($order) && $order)

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-xl px-5 py-4">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm font-medium text-red-800">Terjadi kesalahan</p>
                        </div>
                        <ul class="text-sm text-red-700 space-y-1 pl-6">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-800">Pilih metode pembayaran</span>
                    </div>

                    <div class="px-5 py-4 space-y-2">

                        {{-- Label QRIS --}}
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider pb-1">QRIS</p>

                        <form action="{{ route('payment.process') }}" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <input type="hidden" name="payment_method" value="qris">
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg border border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition-all text-left">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 border border-gray-200">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">QRIS
                                        <span class="ml-1.5 text-xs font-medium text-green-700 bg-green-50 px-2 py-0.5 rounded-full">Semua e-wallet</span>
                                    </p>
                                    <p class="text-xs text-gray-400 mt-0.5">Scan dengan semua aplikasi pembayaran</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </form>

                        {{-- Divider Virtual Account --}}
                        <div class="flex items-center gap-3 py-1">
                            <div class="flex-1 h-px bg-gray-100"></div>
                            <span class="text-xs text-gray-400 font-medium">Virtual Account Bank</span>
                            <div class="flex-1 h-px bg-gray-100"></div>
                        </div>

                        @php
                            $banks = [
                                ['code' => 'va_bca',     'name' => 'BCA Virtual Account',     'short' => 'BCA', 'desc' => 'Bank Central Asia'],
                                ['code' => 'va_bni',     'name' => 'BNI Virtual Account',     'short' => 'BNI', 'desc' => 'Bank Negara Indonesia'],
                                ['code' => 'va_bri',     'name' => 'BRI Virtual Account',     'short' => 'BRI', 'desc' => 'Bank Rakyat Indonesia'],
                                ['code' => 'va_mandiri', 'name' => 'Mandiri Virtual Account', 'short' => 'MDR', 'desc' => 'Bank Mandiri'],
                            ];
                        @endphp

                        @foreach ($banks as $bank)
                            <form action="{{ route('payment.process') }}" method="POST">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="hidden" name="payment_method" value="{{ $bank['code'] }}">
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg border border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition-all text-left">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 border border-gray-200">
                                        <span class="text-xs font-semibold text-gray-600">{{ $bank['short'] }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $bank['name'] }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">Transfer ke rekening virtual {{ $bank['desc'] }}</p>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </form>
                        @endforeach

                    </div>
                </div>
            @endif

            {{-- Back --}}
            <div class="text-center pt-2 pb-4">
                <a href="{{ route('shop') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke toko
                </a>
            </div>

        </div>
    </div>
</div>
@endsection