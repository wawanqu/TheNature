<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();

        // hitung total transaksi
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->quantity * $item->product->price;
        }

        // generate nomor transaksi
        $date = now()->format('dmY');
        $dailyCount = str_pad((Cart::whereDate('created_at', now())->count() + 1) % 1000, 3, '0', STR_PAD_LEFT);
        $transactionNumber = "TH-{$date}-{$dailyCount}";

        // kode unik = 2 digit terakhir nomor transaksi
        $uniqueCode = (int)substr($transactionNumber, -2);

        return view('checkout.index', [
            'cartItems' => $cartItems,
            'total' => $total,
            'transactionNumber' => $transactionNumber,
            'uniqueCode' => $uniqueCode,
            'cartDescription' => $cartItems->pluck('description')->implode(', ')
        ]);
    }

    	
	public function store(Request $request)
	{
		// Ambil item keranjang dulu
    $cartItems = Cart::where('user_id', auth()->id())->get();

    $order = Order::create([
    'user_id' => auth()->id(),
    'address' => $request->input('address'),
    'payment_method' => $request->input('payment_method'),
    'notes' => $request->input('notes'),
    'total' => $cartItems->sum(fn($item) => $item->quantity * $item->product->price),
    'unique_code' => rand(01,99), // atau sesuai logika transaksi
	]);

    $cartItems = Cart::where('user_id', auth()->id())->get();

    foreach ($cartItems as $item) {
        // simpan ke order_items
        $order->items()->create([
            'product_id'  => $item->product_id,
            'quantity'    => $item->quantity,
            'description' => $item->description,
        ]);

        // kurangi stok produk
        $product = $item->product;
        $product->stock -= $item->quantity;
        $product->save();

        // hapus dari keranjang
        $item->delete();
    }

    return redirect()->route('orders.mine')->with('success', 'Pesanan berhasil dibuat!');
}
}