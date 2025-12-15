<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSuccessMail;


class CheckoutController extends Controller
{
    /**
     * Halaman checkout: menampilkan ringkasan keranjang
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        // kalau keranjang kosong
        if ($cartItems->isEmpty()) {
            return redirect()->route('landing')
                ->with('error', 'Keranjangmu masih kosong, silakan pilih produk dulu.');
        }

        // hitung total harga
        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

        // generate kode transaksi unik
        $countToday = Order::whereDate('created_at', now()->toDateString())->count() + 1;
        $orderNumber = str_pad(($countToday % 1000), 3, '0', STR_PAD_LEFT);
        $transactionNumber = 'TH-' . now()->format('dmY') . '-' . $orderNumber;

        // kode unik diambil dari 2 digit terakhir
        $uniqueCode = substr($transactionNumber, -2);
        $jumlahPembayaran = $total + $uniqueCode;

        // deskripsi ringkas isi keranjang
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

    /**
     * Simpan pesanan baru dari keranjang
     */
    public function store(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong');
        }

        // hitung total harga
        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->price);

        // generate kode transaksi
        $countToday = Order::whereDate('created_at', now()->toDateString())->count() + 1;
        $orderNumber = str_pad(($countToday % 1000), 3, '0', STR_PAD_LEFT);
        $kodeTransaksi = 'TH-' . now()->format('dmY') . '-' . $orderNumber;

        // jumlah pembayaran dengan kode unik
        $jumlahUnik = substr($kodeTransaksi, -2);
        $jumlahPembayaran = $total + $jumlahUnik;

        // simpan order utama
        $order = Order::create([
            'user_id'           => Auth::id(),
            'address'           => $request->input('address'),
            'notes'             => $request->input('notes'),
            'total'             => $total,
            'kode_transaksi'    => $kodeTransaksi,
            'jumlah_pembayaran' => $jumlahPembayaran,
            'status'            => 'Belum Dibayar',
            'jenis_pembayaran'  => $request->input('payment_method', 'QRIS'),
        ]);
		
		Mail::to($order->user->email)->send(new OrderSuccessMail($order));

		
        // simpan detail item pesanan (snapshot produk)
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id'          => $item->product_id,
                'product_name'        => $item->product->name,
                'product_description' => $item->product->description,
                'product_price'       => $item->product->price,
                'quantity'            => $item->quantity,
            ]);

            // kurangi stok produk
            $product = $item->product;
            $product->stock -= $item->quantity;
            $product->save();

            // hapus dari keranjang
            $item->delete();
        }

        return redirect()->route('orders.mine')
            ->with('success', 'Pesanan berhasil dibuat!')
            ->with('transaction_number', $kodeTransaksi);
    }
}