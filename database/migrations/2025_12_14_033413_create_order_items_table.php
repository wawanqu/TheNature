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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // relasi ke orders dan products
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');

            // jumlah produk yang dibeli
            $table->integer('quantity');

            // snapshot data produk saat transaksi
            $table->string('product_name');                   // nama produk
            $table->text('product_description')->nullable();  // keterangan produk
            $table->decimal('product_price', 12, 2);          // harga satuan produk

            $table->timestamps();

            // foreign key
            $table->foreign('order_id')
                  ->references('id')->on('orders')
                  ->onDelete('cascade');

            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};