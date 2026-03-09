<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    // menampilkan riwayat transaksi
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }


    // detail transaksi
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

public function buyNow($id)
{
    $product = Product::findOrFail($id);

    // buat order
    $order = Order::create([
        'external_id' => 'ORDER-' . time(),
        'user_id' => Auth::id(),
        'total_amount' => $product->price,
        'status' => 'pending'
    ]);

    // buat order item
    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'product_name' => $product->name,
        'product_image' => $product->image,
        'price' => $product->price,
        'quantity' => 1,
        'subtotal' => $product->price * 1
    ]);

    return redirect()->route('orders.index')
        ->with('success', 'Pesanan berhasil dibuat');
}
  

}