<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // tampilkan isi keranjang
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }

    // tambah produk ke keranjang
    public function store(Request $request, $id)
    {
        if (!Auth::check()) {
            // kalau belum login, arahkan ke register
            if ($request->ajax()) {
                return response()->json(['error' => 'Silakan daftar/login dulu'], 401);
            }
            return redirect()->route('register')
                ->with('error', 'Silakan daftar dulu untuk menambahkan ke keranjang');
        }

        $product = Product::findOrFail($id);

        $item = Cart::where('user_id', Auth::id())
                    ->where('product_id', $product->id)
                    ->first();

        if ($item) {
            $item->quantity += 1;
            $item->save();
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
                'quantity'   => 1,
            ]);
        }

        // kalau request AJAX, balikan JSON supaya tetap di landing page
        if ($request->ajax()) {
            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
            return response()->json([
                'success'    => 'Produk ditambahkan ke keranjang',
                'cart_count' => $cartCount,
            ]);
        }

        // fallback biasa (non-AJAX)
        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang');
    }

    // update jumlah / keterangan
    public function update(Request $request, $id)
    {
        $item = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        $item->update([
            'quantity'    => $request->input('quantity', $item->quantity),
            'description' => $request->input('description', $item->description),
        ]);

        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui');
    }

    // hapus produk dari keranjang
    public function destroy($id)
    {
        $item = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $item->delete();

        return redirect()->route('landing')->with('success', 'Produk dihapus dari keranjang');
    }

    public function cancel()
    {
        Cart::where('user_id', Auth::id())->delete();
        return redirect()->route('landing')->with('success', 'Transaksi dibatalkan, keranjang dikosongkan');
    }

    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();
        return redirect()->route('landing')->with('success', 'Keranjang berhasil dikosongkan.');
    }
}