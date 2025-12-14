@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4 text-orange-600">
    Kelola Produk - {{ isset($product) ? 'Update' : 'Tambah' }}
	</h1>

    @if ($errors->any())
        <div class="bg-red-200 p-2 mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li class="text-red-700">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" 
          method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div>
            <label for="name" class="block font-semibold">Nama Produk</label>
            <input type="text" name="name" id="name" 
                   value="{{ old('name', $product->name ?? '') }}"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label for="price" class="block font-semibold">Harga</label>
            <input type="number" name="price" id="price" 
                   value="{{ old('price', $product->price ?? '') }}"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label for="stock" class="block font-semibold">Stok</label>
            <input type="number" name="stock" id="stock" 
                   value="{{ old('stock', $product->stock ?? 0) }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label for="description" class="block font-semibold">Deskripsi</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full border rounded px-3 py-2">{{ old('description', $product->description ?? '') }}</textarea>
        </div>

        <div>
            <label for="image" class="block font-semibold">Upload Gambar</label>
            <input type="file" name="image" id="image"
                   class="w-full border rounded px-3 py-2">
            @if(isset($product) && $product->image_url)
                <p class="mt-2">Gambar saat ini:</p>
                <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded">
            @endif
        </div>

        <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded">
            {{ isset($product) ? 'Update Produk' : 'Simpan Produk' }}
        </button>
        <a href="{{ route('products.index') }}" class="ml-2 text-gray-600">Batal</a>
    </form>
</div>
@endsection