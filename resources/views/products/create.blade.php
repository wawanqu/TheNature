@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Tambah Produk Baru</h1>

    {{-- tampilkan error validasi --}}
    @if ($errors->any())
        <div class="bg-red-200 p-2 mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li class="text-red-700">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- tampilkan pesan sukses --}}
    @if(session('success'))
        <div class="bg-green-200 p-2 mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block font-semibold">Nama Produk</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label for="price" class="block font-semibold">Harga</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}"
                   class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label for="stock" class="block font-semibold">Stok</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label for="description" class="block font-semibold">Deskripsi</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
        </div>

        <div>
            <label for="image" class="block font-semibold">Upload Gambar</label>
            <input type="file" name="image" id="image"
                   class="w-full border rounded px-3 py-2">
            <p class="text-sm text-gray-500">Format: jpeg, png, jpg, gif, webp (maks 2MB)</p>
        </div>

        <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded">
            Simpan Produk
        </button>
        <a href="{{ route('products.index') }}" class="ml-2 text-gray-600">Batal</a>
    </form>
</div>
@endsection