@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Katalog Produk - The Nature</h1>

    @if(session('success'))
        <div class="bg-green-200 p-2 mb-4">{{ session('success') }}</div>
    @endif

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

                    {{-- Tombol Revisi Produk hanya untuk admin/super_admin --}}
                    @can('add-product')
                        <a href="{{ route('products.edit', $product->id) }}"
                           class="mt-2 block w-full px-4 py-2 border booder-orange-600 text-blue-600 hover:bg-orange-250 font-bold rounded-lg shadow ">
                           Revisi Produk
                        </a>
                    @endcan
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection