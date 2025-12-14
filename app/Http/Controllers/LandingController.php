<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class LandingController extends Controller
{
    /**
     * Tampilkan landing page dengan katalog produk.
     */
    public function index()
    {
        // Ambil data produk dari database
        $products = Product::paginate(9); // bisa diubah jumlah per halaman sesuai kebutuhan

        // Kirim ke view landing.blade.php
        return view('landing', compact('products'));
    }
}