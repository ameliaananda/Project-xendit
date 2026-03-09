<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Menampilkan riwayat pesanan milik user yang sedang login.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Detail pesanan — termasuk daftar item yang dibeli.
     */
    public function show(Order $order)
    {
        // [REFACTOR] Eager load items agar tidak N+1 query
        $order->load('items');

        return view('orders.show', compact('order'));
    }

    /**
     * "Beli Sekarang" — buat Order + OrderItem untuk 1 produk,
     * lalu redirect ke halaman checkout untuk pilih metode bayar.
     *
     * [REFACTOR] Sebelumnya langsung redirect ke orders tanpa proses pembayaran.
     * Sekarang redirect ke checkout agar user bisa pilih metode bayar.
     */
    public function buyNow($id)
    {
        $product = Product::findOrFail($id);

        // [CHECK] Pastikan stok tersedia sebelum buat order
        if ($product->stock < 1) {
            return back()->with('error', 'Stok produk habis!');
        }

        // Buat order
        $order = Order::create([
            'external_id'  => 'ORDER-' . time() . '-' . Auth::id(),
            'user_id'      => Auth::id(),
            'total_amount' => $product->price,
            'status'       => 'pending',
        ]);

        // Buat order item (snapshot data produk saat transaksi)
        OrderItem::create([
            'order_id'      => $order->id,
            'product_id'    => $product->id,
            'product_name'  => $product->name,
            'product_image' => $product->image,
            'price'         => $product->price,
            'quantity'      => 1,
            'subtotal'      => $product->price,
        ]);

        // [REFACTOR] Redirect ke checkout dengan order_id, agar user pilih metode bayar
        return redirect()->route('checkout', ['order_id' => $order->id]);
    }
}
