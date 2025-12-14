@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="bg-green-200 p-4 mb-4 rounded">
            <strong>Selamat transaksi {{ session('transaction_number') }} Anda berhasil!</strong>
        </div>
    @endif

    <h2 class="mb-4">Lanjutkan Pembayaran</h2>
    <p>Saat ini hanya metode <strong>QRIS</strong> yang dapat digunakan.</p>
    <p>Kode QRIS Kami, pastikan nama toko: <strong>Wakuraa, Toserba Pakaian</strong>.</p>
    <img src="{{ asset('images/qris_statis.png') }}" alt="QRIS Wakuraa" class="w-64 h-64 my-4">
    <p>Pastikan Anda membayar sesuai jumlah pembayaran yaitu 
       <strong>Rp {{ number_format($orders->first()->total + $orders->first()->unique_code,0,',','.') }}</strong>.
    </p>

    <h3 class="mt-6">Riwayat Transaksi</h3>
    <table class="table-auto w-full mt-2 border">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">Kode Transaksi</th>
                <th class="px-4 py-2">Tanggal</th>
                <th class="px-4 py-2">Total</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td class="border px-4 py-2">{{ $order->transaction_number }}</td>
                    <td class="border px-4 py-2">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                    <td class="border px-4 py-2">Rp {{ number_format($order->total + $order->unique_code,0,',','.') }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($order->status) }}</td>
                </tr>
            @endforeach
	<ul>
    	@foreach($order->items as $item)
        <li>{{ $item->product->name }} x {{ $item->quantity }}</li>
    	@endforeach
	</ul>
        </tbody>
    </table>
</div>
@endsection
<h3>Detail Pesanan</h3>
<ul>
    @foreach($order->items as $item)
        <li>{{ $item->product->name }} x {{ $item->quantity }}</li>
    @endforeach
</ul>