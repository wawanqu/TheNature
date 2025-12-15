@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Kelola Pesanan</h1>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead class="bg-green-500 text-white">
            <tr>
                <th class="border px-4 py-2">ID Pesanan</th>
                <th class="border px-4 py-2">Nama</th>
                <th class="border px-4 py-2">Produk</th>
                <th class="border px-4 py-2">Jumlah</th>
                <th class="border px-4 py-2">Total</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td class="border px-4 py-2">{{ $order->id }}</td>
                    <td class="border px-4 py-2">
					{{ $order->user->name ?? '' }}
					@empty($order->user)
					<span class="text-red-500 italic">User tidak ditemukan</span>
					@endempty
					</td>
					<td class="border px-4 py-2">
					@if($order->items->isNotEmpty())
					<ul class="list-disc ml-4">
					@foreach($order->items as $item)
					<li>
                    {{ $item->product_name }}
                    x {{ $item->quantity }}
                    (Rp {{ number_format($item->product_price,0,',','.') }})
					</li>
					@endforeach
					</ul>
					@else
					<span class="text-red-500 italic">Produk tidak ditemukan</span>
					@endif
					</td>
                    <td class="border px-4 py-2">{{ $order->quantity }}</td>
                    <td class="border px-4 py-2">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($order->status) }}</td>
                    <td class="border px-4 py-2">
                        <form action="{{ route('orders.update', $order) }}" method="POST" class="flex items-center space-x-2">
                            @csrf
                            <select name="status" class="border rounded px-2 py-1">
							<option value="Belum Dibayar" {{ $order->status == 'Belum Dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
							<option value="Lunas" {{ $order->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
							<option value="Diproses" {{ $order->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
							<option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
							<option value="Dibatalkan" {{ $order->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
							</select>
							
                            <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Update</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
