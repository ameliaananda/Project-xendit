<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout.
     *
     * Jika ada query param ?order_id, tampilkan ringkasan order yang sudah dibuat
     * (dari "Beli Sekarang"). Jika tidak, tampilkan ringkasan cart items.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // [REFACTOR] Jika ada order_id (dari "Beli Sekarang"), tampilkan order tersebut
        if ($request->has('order_id')) {
            $order = Order::with('items')
                ->where('id', $request->order_id)
                ->where('user_id', $user->id)
                ->where('status', 'pending')
                ->firstOrFail();

            return view('shop.checkout', [
                'order'      => $order,
                'items'      => $order->items,
                'grandTotal' => $order->total_amount,
                'fromCart'   => false,
            ]);
        }

        // [REFACTOR] Default: tampilkan cart items untuk checkout
        $carts = Cart::with('product')
            ->where('user_id', $user->id)
            ->get();

        // [REFACTOR] Cegah checkout jika cart kosong
        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang masih kosong!');
        }

        // [REFACTOR] Hitung grand total dari cart items
        $grandTotal = $carts->sum(function ($cart) {
            return $cart->product->price * $cart->quantity;
        });

        return view('shop.checkout', [
            'order'      => null,
            'carts'      => $carts,
            'grandTotal' => $grandTotal,
            'fromCart'   => true,
        ]);
    }

    /**
     * Buat Order + OrderItems dari isi keranjang (Cart).
     *
     * Setelah order dibuat, cart dikosongkan dan user diarahkan
     * ke halaman checkout dengan order_id untuk pilih metode bayar.
     */
    public function createOrder(Request $request)
    {
        $user  = Auth::user();

        // [REFACTOR] Ambil semua cart items milik user
        $carts = Cart::with('product')
            ->where('user_id', $user->id)
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang masih kosong!');
        }

        // [REFACTOR] Gunakan database transaction untuk konsistensi data
        $order = DB::transaction(function () use ($user, $carts) {

            // Hitung total dari semua item di cart
            $totalAmount = $carts->sum(function ($cart) {
                return $cart->product->price * $cart->quantity;
            });

            // Buat record Order
            $order = Order::create([
                'external_id'  => 'ORDER-' . time() . '-' . $user->id,
                'user_id'      => $user->id,
                'total_amount' => $totalAmount,
                'status'       => 'pending',
            ]);

            // [REFACTOR] Buat OrderItem untuk setiap item di cart (snapshot data produk)
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $cart->product->id,
                    'product_name'  => $cart->product->name,
                    'product_image' => $cart->product->image,
                    'price'         => $cart->product->price,
                    'quantity'      => $cart->quantity,
                    'subtotal'      => $cart->product->price * $cart->quantity,
                ]);
            }

            // [REFACTOR] Kosongkan cart setelah order berhasil dibuat
            Cart::where('user_id', $user->id)->delete();

            return $order;
        });

        // [REFACTOR] Redirect ke halaman checkout dengan order_id untuk pilih metode bayar
        return redirect()->route('checkout', ['order_id' => $order->id]);
    }
}
