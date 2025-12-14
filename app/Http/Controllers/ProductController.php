<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    // Form tambah produk
    public function create()
    {
        if (Gate::denies('manage-products')) {
            abort(403, 'Anda tidak punya akses untuk menambah produk');
        }

        return view('products.kelola'); // view gabungan
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        if (Gate::denies('manage-products')) {
            abort(403, 'Anda tidak punya akses untuk menambah produk');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'nullable|integer',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $path = '/storage/'.$path;
        }

        Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'stock'       => $request->stock ?? 0,
            'description' => $request->description ?? null,
            'image_url'   => $path,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Form edit produk
    public function edit(Product $product)
    {
        if (Gate::denies('manage-products')) {
            abort(403, 'Anda tidak punya akses untuk mengedit produk');
        }

        return view('products.kelola', compact('product')); // view sama
    }

    // Update produk
    public function update(Request $request, Product $product)
    {
        if (Gate::denies('manage-products')) {
            abort(403, 'Anda tidak punya akses untuk mengedit produk');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'nullable|integer',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $path = $product->image_url;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $path = '/storage/'.$path;
        }

        $product->update([
            'name'        => $request->name,
            'price'       => $request->price,
            'stock'       => $request->stock ?? 0,
            'description' => $request->description ?? null,
            'image_url'   => $path,
        ]);

        return redirect()->route('landing')->with('success', 'Produk berhasil diperbarui!');
    }

	// Hapus Produk
	public function destroy(Product $product)
	{
		$product->delete();
		return redirect()->route('landing')
                     ->with('success', 'Produk berhasil dihapus.');
	}

    // Daftar produk
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }
}