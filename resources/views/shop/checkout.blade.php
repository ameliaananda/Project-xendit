@extends('layouts.app')

@section('content')
    {{-- [REFACTOR] Halaman checkout yang terhubung dengan cart dan order --}}
    <div class="min-h-screen bg-gray-100 py-10">

        <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-xl p-8">

            <h2 class="text-2xl font-bold text-center mb-8">
                🛒 Checkout
            </h2>

            {{-- ================================= --}}
            {{-- RINGKASAN ORDER / CART ITEMS      --}}
            {{-- ================================= --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">Ringkasan Pesanan</h3>

                <table class="w-full border border-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="border p-2 text-left">Produk</th>
                            <th class="border p-2 text-center">Qty</th>
                            <th class="border p-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- [REFACTOR] Jika dari "Beli Sekarang" (order sudah dibuat) --}}
                        @if (isset($order) && $order)
                            @foreach ($items as $item)
                                <tr>
                                    <td class="border p-2">{{ $item->product_name }}</td>
                                    <td class="border p-2 text-center">{{ $item->quantity }}</td>
                                    <td class="border p-2 text-right">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach

                            {{-- [REFACTOR] Jika dari Cart (order belum dibuat) --}}
                        @elseif(isset($carts))
                            @foreach ($carts as $cart)
                                <tr>
                                    <td class="border p-2">{{ $cart->product->name }}</td>
                                    <td class="border p-2 text-center">{{ $cart->quantity }}</td>
                                    <td class="border p-2 text-right">
                                        Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                {{-- Total --}}
                <div class="flex justify-between items-center mt-4 p-3 bg-green-50 rounded-lg">
                    <span class="font-semibold text-lg">Total Bayar:</span>
                    <span class="font-bold text-xl text-green-600">
                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- ================================= --}}
            {{-- STEP 1: Buat Order dari Cart       --}}
            {{-- (hanya tampil jika checkout dari cart, bukan dari "Beli Sekarang") --}}
            {{-- ================================= --}}
            @if ($fromCart && !isset($order))
                <form action="{{ route('checkout.order') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition mb-4">
                        ✅ Konfirmasi Pesanan & Pilih Metode Bayar
                    </button>
                </form>
            @endif

            {{-- ================================= --}}
            {{-- STEP 2: Pilih Metode Pembayaran   --}}
            {{-- (tampil jika order sudah dibuat)   --}}
            {{-- ================================= --}}
            @if (isset($order) && $order)

                {{-- Error messages --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <h3 class="text-lg font-semibold mb-4">
                    💳 Pilih Metode Pembayaran
                </h3>

                {{-- QRIS --}}
                <h4 class="text-md font-medium mb-3 text-gray-600">QRIS (Scan Semua E-Wallet)</h4>

                <form action="{{ route('payment.process') }}" method="POST">
                    @csrf
                    {{-- [REFACTOR] Kirim order_id, bukan product_id --}}
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="payment_method" value="qris">

                    <button type="submit" class="w-full border rounded-lg p-4 hover:shadow-md transition mb-4">
                        <div class="flex items-center gap-4">
                            <img src="https://seeklogo.com/images/Q/qris-logo-4E9B9F3F23-seeklogo.com.png"
                                class="h-8 object-contain" />
                            <div class="text-left">
                                <div class="font-semibold">QRIS</div>
                                <div class="text-sm text-gray-500">
                                    Scan menggunakan semua aplikasi pembayaran
                                </div>
                            </div>
                        </div>
                    </button>
                </form>

                {{-- Virtual Account --}}
                <h4 class="text-md font-medium mb-3 text-gray-600">Virtual Account Bank</h4>

                @php
                    // [REFACTOR] Daftar bank VA yang tersedia
                    $banks = [
                        [
                            'code' => 'va_bca',
                            'name' => 'BCA Virtual Account',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg',
                        ],
                        [
                            'code' => 'va_bni',
                            'name' => 'BNI Virtual Account',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/id/5/55/BNI_logo.svg',
                        ],
                        [
                            'code' => 'va_bri',
                            'name' => 'BRI Virtual Account',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/2e/BRI_2020.svg',
                        ],
                        [
                            'code' => 'va_mandiri',
                            'name' => 'Mandiri Virtual Account',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg',
                        ],
                    ];
                @endphp

                @foreach ($banks as $bank)
                    <form action="{{ route('payment.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="hidden" name="payment_method" value="{{ $bank['code'] }}">

                        <button type="submit" class="w-full border rounded-lg p-4 hover:shadow-md transition mb-3">
                            <div class="flex items-center gap-4">
                                <img src="{{ $bank['logo'] }}" class="h-7" />
                                <span class="font-medium">{{ $bank['name'] }}</span>
                            </div>
                        </button>
                    </form>
                @endforeach

            @endif

        </div>

    </div>
@endsection
