<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RoleController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Di sini kita definisikan semua route utama aplikasi.
| Landing page langsung katalog produk, autentikasi, dan manajemen produk.
|--------------------------------------------------------------------------
*/


// Halaman depan / landing langsung katalog produk
Route::get('/', [LandingController::class, 'index'])->name('landing');


// Autentikasi sederhana
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman QRIS (selalu tampil di menu, tanpa controller)
Route::get('/qris', function () {
    return view('qris');
})->name('qris.index');

// Halaman keranjang
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Tambah produk ke keranjang
Route::post('/cart/{id}', [CartController::class, 'store'])->name('cart.store');

// Update jumlah produk
Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');

// Hapus produk dari keranjang
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

// Batal transaksi (kosongkan keranjang)
Route::post('/cart/cancel', [CartController::class, 'cancel'])->name('cart.cancel');

Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Halaman checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
// Halaman Pesanan Saya
Route::get('/orders/mine', [OrderController::class, 'mine'])->name('orders.mine');

// Manajemen Produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index'); // opsional, tanpa nama route agar tidak duplikat

// Tambah produk (Kelola Produk - create)
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// Hapus produk
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

// Update produk (Kelola Produk - edit/update)
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

// Tambah produk ke keranjang
Route::middleware('auth')->group(function () {
    Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
});

// Tambah role user
Route::middleware(['auth', 'can:manage-roles'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles/{user}', [RoleController::class, 'update'])->name('roles.update');
});

// Tambah manage-orders
Route::middleware(['auth', 'can:manage-orders'])->group(function () {
    Route::get('/orders/admin', [OrderController::class, 'index'])->name('orders.admin');
    Route::post('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
});