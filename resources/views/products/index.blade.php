@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Katalog Produk - The Nature</h1>

    @if(session('success'))
        <div class="bg-green-200 p-2 mb-4">{{ session('success') }}</div>
    @endif

    {{-- Tombol Kelola Produk (admin) --}}
    @can('add-product')
        <a href="{{ route('products.create') }}" 
           class="bg-orange-900 text-white px-4 py-2 rounded mb-4 inline-block font-bold">
            Kelola Produk
        </a>
    @endcan

    @if($products->isEmpty())
        <p>Belum ada produk tersedia.</p>
    @else
        <div class="grid grid-cols-3 gap-6">
            @foreach ($products as $product)
                <div class="border rounded-lg shadow p-4">
                    <img src="{{ $product->image_url ?? 'https://via.placeholder.com/200x150?text=The+Nature' }}" 
                         alt="{{ $product->name }}" class="w-full h-40 object-cover mb-2">
                    <div class="font-bold">{{ $product->name }}</div>
                    <div class="text-green-700">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    <div class="text-sm text-gray-600">
                        Stok: {{ $product->stock > 0 ? $product->stock : 'Habis' }}
                    </div>

                    @if($product->stock > 0)
                        <a href="#" class="bg-green-700 text-white px-3 py-1 rounded mt-2 inline-block">
                            Tambah ke Keranjang
                        </a>
                    @else
                        <span class="bg-gray-400 text-white px-3 py-1 rounded mt-2 inline-block">
                            Stok Habis
                        </span>
                    @endif

                    {{-- Tombol Kelola Produk hanya untuk admin/superadmin --}}
                    @can('add-product')
					<a href="{{ route('products.edit', $product->id) }}"
           class="mt-2 inline-block px-3 py-1 bg-orange-500 text-white font-bold rounded shadow">
           Kelola Produk
        </a>
					@endcan
                </div>
            @endforeach
        </div>
    @endif

    {{-- Bagian QRIS selalu muncul untuk semua user --}}
    <div class="mt-10 p-6 border rounded-lg shadow bg-gray-50">
        <h2 class="text-xl font-bold mb-4">Pembayaran QRIS</h2>
        <p class="mb-2">Scan kode QRIS berikut untuk melakukan pembayaran:</p>
        <img src="{{ asset('images/qris.png') }}" alt="QRIS" class="w-48 h-48 object-contain">
    </div>
</div>
@endsection