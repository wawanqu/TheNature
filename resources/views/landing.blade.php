@extends('layouts.app')

@section('content')
    {{-- Konten Produk --}}
    @if($products->isEmpty())
        <div class="min-h-[300px] flex items-center justify-center 
                    bg-gradient-to-br from-blue-200 via-gray-100 to-green-100 
                    rounded-lg shadow-inner p-10 mt-8">
            <h2 class="text-2xl md:text-3xl font-Great_vibes text-green-500">
                Alam nan SIAP tuk sedia
            </h2>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-8">
            @foreach($products as $product)
                <div class="border border-green-200 rounded-lg shadow p-4 bg-green-50 hover:shadow-lg transition">
                    <img src="{{ $product->image_url ? asset($product->image_url) : 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                         alt="{{ $product->name }}" class="w-full h-40 object-cover mb-2 rounded">

                    <div class="font-bold text-green-800">{{ $product->name }}</div>
                    <div class="text-green-600">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    <div class="text-sm text-gray-600">Stok: {{ $product->stock }}</div>

                    {{-- Tombol untuk user biasa --}}
                    @if($product->stock > 0)
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded mt-2">
                                🛒 Tambah ke Keranjang
                            </button>
                        </form>
                    @else
                        <span class="bg-gray-400 text-white px-3 py-1 rounded mt-2 inline-block">
                            Stok Habis
                        </span>
                    @endif

                    {{-- Tombol tambahan untuk admin/super admin --}}
                    @can('manage-products')
                        <a href="{{ route('products.edit', $product->id) }}"
                           class="mt-2 block w-full px-4 py-2 bg-yellow-300 text-white font-bold rounded-lg shadow hover:bg-green-800">
                           🌱 Kelola Produk
                        </a>

                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                              onsubmit="return confirm('Yakin hapus produk ini?');" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full px-4 py-2 bg-red-700 text-white font-bold rounded-lg shadow hover:bg-red-800">
                                🗑️ Hapus Produk
                            </button>
                        </form>
                    @endcan
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">{{ $products->links() }}</div>
    @endif
@endsection