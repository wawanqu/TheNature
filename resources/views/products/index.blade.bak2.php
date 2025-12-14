@if(session('success'))
        <div class="bg-green-200 p-2 mb-4">{{ session('success') }}</div>
    @endif

    @if($products->isEmpty())
        <p>Belum ada produk tersedia.</p>
    @else
        <div class="grid grid-cols-3 gap-6">
    @foreach ($products as $product)
        <div class="border border-green-200 rounded-lg shadow p-4 bg-green-50 hover:shadow-lg transition">
            <img src="{{ $product->image_url ?? 'https://via.placeholder.com/200x150?text=The+Nature' }}" 
                 alt="{{ $product->name }}" class="w-full h-40 object-cover mb-2 rounded">

            <div class="font-bold text-green-800">{{ $product->name }}</div>
            <div class="text-green-600">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            <div class="text-sm text-gray-600">
                Stok: {{ $product->stock > 0 ? $product->stock : 'Habis' }}
            </div>

            {{-- Tombol keranjang / stok habis --}}
            @if($product->stock > 0)
                <a href="#" class="bg-green-600 text-white px-3 py-1 rounded mt-2 inline-flex items-center hover:bg-green-700">
                    🛒 Tambah ke Keranjang
                </a>
            @else
                <span class="bg-gray-400 text-white px-3 py-1 rounded mt-2 inline-block">
                    Stok Habis
                </span>
            @endif

            {{-- Tombol admin --}}
            @can('add-product')
                <a href="{{ route('products.edit', $product->id) }}"
                   class="mt-2 block w-full px-4 py-2 bg-green-700 text-white font-bold rounded-lg shadow hover:bg-green-800">
                   🌱 Revisi Produk
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
    @endif