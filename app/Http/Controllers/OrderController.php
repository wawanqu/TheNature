<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Tampilkan riwayat semua pesanan user.
     */
    public function mine()
    {
        // Ambil semua pesanan milik user, urutkan terbaru paling atas
        $orders = Order::where('user_id', auth()->id())
                       ->latest()
                       ->get();

        // Kirim ke view orders.mine
        return view('orders.mine', [
            'orders' => $orders,
            'paymentNotice' => 'Sementara ini, Pembayaran hanya menggunakan QRIS, bisa lihat Navigasi di atas',
        ]);
    }
}