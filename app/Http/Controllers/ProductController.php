<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;


use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function cekXendit()
{
    dd(env('XENDIT_SECRET_KEY'));
}



/**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function shop()
    {
    $products = Product::all();
    return view('shop.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'stock' => 'required|numeric',
        'description' => 'nullable',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('products', 'public');
    }

    Product::create($data);

    return redirect()->route('products.index')
                     ->with('success', 'Produk berhasil ditambahkan');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Tidak dipakai
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
    public function customerIndex()
{
    $products = \App\Models\Product::all();
    return view('shop.index', compact('products'));
}

public function bayar(Product $product)
{
    Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));

    $apiInstance = new InvoiceApi();

    $createInvoice = new CreateInvoiceRequest([
        'external_id' => 'INV-' . uniqid(),
        'amount' => $product->price,
        'description' => 'Pembelian produk ' . $product->name,
        'success_redirect_url' => route('shop'),
    ]);

    $invoice = $apiInstance->createInvoice($createInvoice);

    return redirect($invoice->getInvoiceUrl());
}


}