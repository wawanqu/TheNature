<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrisController extends Controller
{
    public function index()
    {
        // Menampilkan halaman QRIS dengan gambar kode QR
        return view('qris.index');
    }
}