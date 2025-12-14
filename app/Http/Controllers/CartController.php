<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    // tampilkan isi keranjang
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();
        return view('cart.index', compact('cartItems'));
    }

    // tambah produk ke keranjang
    public function store($id)
    {
    $product = Product::findOrFail($id);

    $item = Cart::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->first();

    if ($item) {
        // kalau produk sudah ada, tambahkan quantity
        $item->quantity += 1;
        $item->save();
    } else {
        // kalau belum ada, buat baris baru
        Cart::create([
            'user_id'    => auth()->id(),
            'product_id' => $product->id,
            'quantity'   => 1,
        ]);
        }

    return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang');
}
    // update jumlah / keterangan
    public function update(Request $request, $id)
    {
        $item = Cart::where('user_id', auth()->id())->where('id', $id)->firstOrFail();

        $item->update([
            'quantity'    => $request->input('quantity', $item->quantity),
            'description' => $request->input('description', $item->description),
        ]);

        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui');
    }

    // hapus produk dari keranjang
    public function destroy($id)
    {
        $item = Cart::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $item->delete();

        return redirect()->route('landing')->with('success', 'Produk dihapus dari keranjang');
    }

    public function cancel()
    {
    Cart::where('user_id', auth()->id())->delete();
    return redirect()->route('landing')->with('success', 'Transaksi dibatalkan, keranjang dikosongkan');
    }
	public function clear()
    {
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('landing')->with('success', 'Keranjang berhasil dikosongkan.');
    }


}