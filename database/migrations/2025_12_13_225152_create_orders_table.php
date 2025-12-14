<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('kode_transaksi')->nullable();     // kode transaksi unik
            $table->integer('jumlah_pembayaran')->nullable(); // total + 2 digit akhir kode transaksi
            $table->string('status')->default('Belum Dibayar'); // status pesanan
            $table->string('jenis_pembayaran')->nullable();   // jenis pembayaran (qris, transfer, dll)

            $table->string('address')->nullable();            // alamat pengiriman
            $table->integer('total');                         // total harga produk
            $table->text('notes')->nullable();                // catatan tambahan
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
				
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};