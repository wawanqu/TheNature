@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">🧾 Checkout</h2>

    <!-- Nomor Transaksi -->
    <p><strong>Nomor Transaksi:</strong> {{ $transactionNumber }}</p>

    <!-- Total Transaksi -->
    <p><strong>Total Transaksi:</strong> Rp {{ number_format($total,0,',','.') }}</p>

    <!-- Jumlah Pembayaran -->
    <p><strong>Jumlah Pembayaran:</strong> Rp {{ number_format($jumlahPembayaran,0,',','.') }}</p>

    <!-- Waktu Transaksi -->
    <p><strong>Waktu Transaksi:</strong> {{ $waktuTransaksi }} WIB</p>

    <!-- Detail Pesanan -->
    <h4 class="mt-4">Detail Pesanan</h4>
    <ul>
        @foreach($cartItems as $item)
            <li>{{ $item->product->name }} x {{ $item->quantity }}</li>
        @endforeach
    </ul>

    <!-- Form Checkout -->
    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <!-- Alamat Pengiriman -->
        <div class="mb-3">
            <label for="address" class="form-label">Alamat Pengiriman</label>
            <input type="text" name="address" id="address" class="form-control"
                   placeholder="Masukkan alamat lengkap Anda" required>
        </div>

        <!-- Deskripsi Pesanan -->
        <div class="mb-3">
            <label for="notes" class="form-label">Deskripsi Pesanan</label>
            <textarea name="notes" id="notes" class="form-control"
                placeholder="Tambahkan catatan lanjutan untuk pesanan Anda">{{ $cartDescription }}</textarea>
        </div>

        <!-- Pilihan Pembayaran -->
        <div class="mb-4">
            <label class="form-label">Metode Pembayaran</label><br>
            <div>
                <input type="radio" name="payment_method" value="qris" id="qris" required>
                <label for="qris"><strong>QRIS</strong></label>
            </div>
            <div>
                <input type="radio" name="payment_method" value="transfer" id="transfer">
                <label for="transfer">Transfer Bank</label>
            </div>
            <div>
                <input type="radio" name="payment_method" value="ewallet" id="ewallet">
                <label for="ewallet">E‑Wallet</label>
            </div>
        </div>

        <!-- Tombol aksi -->
        <div class="d-flex gap-2">
            <button type="submit"
                class="btn fw-bold px-4 py-2"
                style="background-color:#28a745; color:white; border:none; border-radius:6px;">
                Lanjutkan Pembayaran
            </button>

            <a href="{{ route('cart.index') }}"
               class="btn fw-bold px-4 py-2"
               style="background-color:#dc3545; color:white; border:none; border-radius:6px;">
                Hapus
            </a>
        </div>
    </form>
</div>
@endsection