<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Admin: Daftar semua produk (halaman manage products).
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Customer: Halaman toko — tampilkan semua produk yang tersedia.
     */
    public function shop()
    {
        $products = Product::all();
        return view('shop.index', compact('products'));
    }

    /**
     * Admin: Form tambah produk baru.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Admin: Simpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
            'description' => 'nullable',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Admin: Form edit produk.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Admin: Update data produk.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);

        $product->update([
            'name'  => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Admin: Hapus produk.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    // [CLEANUP] Fungsi cekXendit(), bayar(), dan customerIndex() telah dihapus.
    // - cekXendit(): hanya dd() untuk debug, tidak diperlukan
    // - bayar(): dead code yang pakai Invoice API + env() langsung
    // - customerIndex(): duplikat dari shop()
}
