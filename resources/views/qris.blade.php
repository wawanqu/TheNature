@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Pembayaran QRIS</h1>
    <p class="mb-2">Scan kode QRIS berikut untuk melakukan pembayaran:</p>
    <p class="mb-2">*Pastikan merchant di QRIS yan anda Scan adalah Wakuraa, Toserba Pakaian, bukan yang lain.</p>

    {{-- Gambar QRIS --}}
    <img src="{{ asset('images/qris_statis.png') }}" alt="QRIS" 
         class="w-64 h-64 object-contain mt-4 mx-auto">

    {{-- Info tambahan --}}
    <div class="mt-6 text-center">
        <p class="text-gray-700">Pastikan nominal sesuai, dengan tambahan kode unique sebelum melakukan pembayaran.</p>
        
    </div>
</div>
@endsection