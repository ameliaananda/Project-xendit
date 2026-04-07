<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Admin: Daftar semua produk (halaman manage products).
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.kelola-product', compact('products'));
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
     * Customer: Detail produk.
     */
    public function detail(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Admin: Show produk (redirect ke daftar) untuk rute resource admin.
     */
    public function show(Product $product)
    {
        return redirect()->route('admin.products.index');
    }

    /**
     * Admin: Form tambah produk baru.
     */
    public function create()
    {
        return view('admin.create-product');
    }

    /**
     * Admin: Simpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'unit'        => 'required|string|max:50',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Admin: Form edit produk.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('admin.edit-product', compact('product'));
    }

    /**
     * Admin: Update data produk.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'unit'        => 'required|string|max:50',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Admin: Hapus produk.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
