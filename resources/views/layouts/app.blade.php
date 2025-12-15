<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Nature</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    {{-- Header global --}}
    <header class="bg-gradient-to-r from-yellow-200 to-green-200 p-6 text-center shadow">
       

    <div class="ml-4 leading-tight font-bold text-blue-600 text-3xl">
	<img src="{{ asset('images/Wakuraa.png') }}" alt="Logo" class="h-16 w-16">
        <div>The</div>
        <div class="pl-1">Nature</div>
    </div>

        {{-- Navigasi --}}
        <div class="flex justify-center space-x-6 mt-4">
            <a href="{{ route('qris.index') }}" class="text-purple-700 font-semibold">QRIS Kami ❤️</a>

            @auth
                {{-- Menu User Biasa --}}
                <a href="{{ route('cart.index') }}">Keranjang</a>
				<a href="{{ route('checkout.index') }}">Checkout</a>
                <a href="{{ route('orders.mine') }}">Pesanan Saya</a>

                {{-- Menu Admin --}}
                @can('manage-products')
                    <a href="{{ route('products.create') }}">Tambah Produk</a>
				@endcan


                @can('manage-orders')
				{{--   <a href="{{ route('orders.index') }}">Administrasi Order</a> --}}
                @endcan

                {{-- Menu Super Admin --}}
                @can('manage-roles')
				<li class="nav-item">
				<a class="nav-link" href="{{ route('roles.index') }}">
				Kelola Peran
				</a>
				</li>
                @endcan
				

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                {{-- Menu Guest --}}
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Daftar</a>
            @endauth
        </div>

        {{-- Link kembali ke toko (hanya selain landing) --}}
        @if(!Route::is('landing'))
            <div class="mt-2">
                <a href="{{ route('landing') }}" class="text-orange-900 text-sm lowercase underline">
                    ← kembali ke toko
                </a>
            </div>
        @endif
    </header>

    {{-- Konten utama --}}
    <main class="container mx-auto p-6 flex-grow">
        @yield('content')
    </main>

    {{-- Footer sederhana --}}
    <footer class="bg-green-200 text-center p-4 text-sm text-green-800">
        © {{ date('Y') }} The Nature — Hidup selaras dengan alam
    </footer>
</body>
</html>