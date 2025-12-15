<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth; 

class OrderController extends Controller
{	
	public function mine()
    {
        $orders = Order::where('user_id', Auth::id())
                       ->with('product')
                       ->get();

        return view('orders.mine', compact('orders'));
    }

    public function index()
    {
        $orders = Order::with(['user','product'])->get();
        return view('orders.admin', compact('orders'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:Belum dibayar,Lunas,Diproses,Selesai,Dibatalkan'
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->route('orders.admin')->with('success', 'Status pesanan berhasil diperbarui!');
    }
}