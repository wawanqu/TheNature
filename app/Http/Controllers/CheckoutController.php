<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;

class CheckoutController extends Controller
{	
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();
        // kalau keranjang kosong
        if ($cartItems->isEmpty()) {
            return redirect()->route('landing')
                ->with('error', 'Keranjangmu masih kosong, silakan pilih produk dulu.');
        }

        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);
        $countToday = Order::whereDate('created_at', now()->toDateString())->count() + 1;
        $orderNumber = str_pad(($countToday % 1000), 3, '0', STR_PAD_LEFT);
        $transactionNumber = 'TH-' . now()->format('dmY') . '-' . $orderNumber;
        $uniqueCode = substr($transactionNumber, -2);
        $jumlahPembayaran = $total + $uniqueCode;

        $cartDescription = $cartItems
            ->map(fn($item) => $item->product->name . ' x ' . $item->quantity)
            ->implode(', ');

        return view('checkout.index', [
            'cartItems'         => $cartItems,
            'total'             => $total,
            'transactionNumber' => $transactionNumber,
            'uniqueCode'        => $uniqueCode,
            'jumlahPembayaran'  => $jumlahPembayaran,
            'jenisPembayaran'   => 'QRIS',
            'cartDescription'   => $cartDescription,
            'waktuTransaksi'    => now()->setTimezone('Asia/Jakarta')->format('d-m-Y H:i'), // WIB
        ]);
    }
	
    public function store(Request $request)
    {
        // Ambil item keranjang user
        $cartItems = Cart::where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong');
        }

        // Hitung total harga dari keranjang
        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

        // Generate kode transaksi: TH-ddmmyyyy-XXX
        $countToday = Order::whereDate('created_at', now()->toDateString())->count() + 1;
        $orderNumber = str_pad(($countToday % 1000), 3, '0', STR_PAD_LEFT);
        $kodeTransaksi = 'TH-' . now()->format('dmY') . '-' . $orderNumber;

        // Hitung jumlah pembayaran (total + kode unik)
        $jumlahUnik = substr($kodeTransaksi, -2);
        $jumlahPembayaran = $total + $jumlahUnik;

        // Simpan order utama
        $order = Order::create([
            'user_id'           => auth()->id(),
            'address'           => $request->input('address'),
            'notes'             => $request->input('notes'),
            'total'             => $total,
            'kode_transaksi'    => $kodeTransaksi,
            'jumlah_pembayaran' => $jumlahPembayaran,
            'status'            => 'Belum Dibayar',
            'jenis_pembayaran'  => $request->input('payment_method'),
        ]);

        // Simpan detail item pesanan (snapshot produk)
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id'         => $item->product_id,
                'product_name'       => $item->product->name,          // snapshot nama
                'product_description'=> $item->product->description,  // snapshot keterangan
                'product_price'      => $item->product->price,         // snapshot harga
                'quantity'           => $item->quantity,
            ]);

            // Kurangi stok produk
            $product = $item->product;
            $product->stock -= $item->quantity;
            $product->save();

            // Hapus dari keranjang
            $item->delete();
        }

        return redirect()->route('orders.mine')
                         ->with('success', 'Pesanan berhasil dibuat!')
                         ->with('transaction_number', $kodeTransaksi);
    }
}