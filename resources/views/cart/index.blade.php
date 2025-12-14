@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">🛒 Keranjang Belanja Anda</h2>
    <p class="text-muted">Senang belanja di sini? Yuk cek pesananmu!</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($cartItems->isEmpty())
        <p>Keranjang masih kosong. <a href="{{ route('landing') }}">⬅️ Kembali ke toko</a></p>
    @else
        <div class="row">
            @foreach($cartItems as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->product->name }}</h5>
                            <p class="card-text">Harga: Rp {{ number_format($item->product->price,0,',','.') }}</p>

                            <!-- Form update jumlah & keterangan -->
                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                @csrf @method('PATCH')

                                <div class="d-flex align-items-center mb-2">
                                    <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}" class="btn btn-sm btn-outline-secondary">-</button>
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control mx-2" style="width:70px;">
                                    <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="btn btn-sm btn-outline-secondary">+</button>
                                </div>

                                <input type="text" name="description"
                                       value="{{ $item->description }}"
                                       placeholder="contoh: tanpa sambal, ukuran besar"
                                       class="form-control mb-2">

                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            </form>

                            <!-- Hapus item -->
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="mt-2">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    <<div class="d-flex gap-2 mt-4">
					<!-- Tombol Lanjutkan Pembayaran -->
						<a href="{{ route('checkout.index') }}"
						class="btn fw-bold px-4 py-2"
						style="background-color:#28a745; color:white; border:none; border-radius:6px;">
						Lanjutkan Pembayaran
						</a>

					<!-- Tombol Batalkan Transaksi -->
						<a href="{{ route('cart.clear') }}"
						class="btn fw-bold px-4 py-2"
						style="background-color:#dc3545; color:white; border:none; border-radius:6px;">
						Batalkan Transaksi
						</a>
					</div>
		</div>
                </div>
            @endforeach
        </div>
        
    @endif
</div>
@endsection