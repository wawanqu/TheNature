@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="bg-green-200 p-4 mb-4 rounded">
            <strong>Selamat transaksi {{ session('transaction_number') }} Anda berhasil!</strong>
        </div>
    @endif

    {{-- Informasi pembayaran --}}
    <h2 class="mb-4">Lanjutkan Pembayaran</h2>
    <p>Saat ini hanya metode <strong>QRIS</strong> yang dapat digunakan.</p>
    <p>Kode QRIS Kami, pastikan nama toko: <strong>Wakuraa, Toserba Pakaian</strong>.</p>
    <img src="{{ asset('images/qris_statis.png') }}" alt="QRIS Wakuraa" class="w-64 h-64 my-4">
    <p>
        Pastikan Anda membayar sesuai jumlah pembayaran yaitu
        <strong>Rp {{ number_format($orders->first()->jumlah_pembayaran,0,',','.') }}</strong>.
    </p>

    {{-- Riwayat transaksi --}}
    <h3 class="mt-6">Riwayat Transaksi</h3>
    <table class="table-auto w-full mt-2 border">
        <thead>
            <tr class="bg-lime-300">
                <th class="px-4 py-2">Kode Transaksi</th>
                <th class="px-4 py-2">Tanggal (WIB)</th>
                <th class="px-4 py-2">Jumlah Pembayaran</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Jenis Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td class="border px-4 py-2">{{ $order->kode_transaksi }}</td>
                    <td class="border px-4 py-2">
                        {{ $order->created_at->setTimezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB
                    </td>
                    <td class="border px-4 py-2">Rp {{ number_format($order->jumlah_pembayaran,0,',','.') }}</td>
                    <td class="border px-4 py-2">
                        @switch($order->status)
                            @case('Belum Dibayar')
                                <span class="badge bg-warning text-dark">{{ $order->status }}</span>
                                @break
                            @case('Lunas')
                                <span class="badge bg-success">{{ $order->status }}</span>
                                @break
                            @case('Diproses')
                                <span class="badge bg-info text-dark">{{ $order->status }}</span>
                                @break
                            @case('Dikirim')
                                <span class="badge bg-primary">{{ $order->status }}</span>
                                @break
                            @case('Selesai')
                                <span class="badge bg-success">{{ $order->status }}</span>
                                @break
                            @case('Dibatalkan')
                                <span class="badge bg-danger">{{ $order->status }}</span>
                                @break
                            @default
                                {{ $order->status }}
                        @endswitch
                    </td>
                    <td class="border px-4 py-2">{{ $order->jenis_pembayaran }}</td>
                </tr>
                {{-- Detail item pesanan --}}
                <tr>
                    <td colspan="5" class="border px-4 py-2">
                        <h4 class="font-semibold">Detail Pesanan</h4>
                        <ul class="list-disc ml-6">
                            @foreach($order->items as $item)
                                <li>{{ $item->product->name }} x {{ $item->quantity }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada pesanan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection