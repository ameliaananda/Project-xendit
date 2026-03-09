<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 🔥 TAMBAH KE KERANJANG
    public function add($id)
    {
        $product = Product::findOrFail($id);

        if ($product->stock < 1) {
            return back()->with('error', 'Stok habis');
        }

        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $id)
                    ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Produk masuk keranjang!');
    }

    // 🔥 LIHAT KERANJANG
    public function index()
    {
        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('cart.index', compact('carts'));
    }

    // 🔥 HAPUS ITEM
    public function remove($id)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $cart->delete();

        return back()->with('success', 'Item dihapus!');
    }

    // 🔥 UPDATE JUMLAH BARANG
public function update(Request $request, $id)
{
    $cart = Cart::findOrFail($id);

    if($request->action == 'plus'){
        $cart->quantity += 1;
    }

    if($request->action == 'minus' && $cart->quantity > 1){
        $cart->quantity -= 1;
    }

    $cart->save();

    return back();
}
}