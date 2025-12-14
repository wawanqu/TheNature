<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // inti data
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('price'); // simpan sebagai angka utuh (rupiah)
            $table->unsignedInteger('stock')->default(0);

            // visual & katalog
            $table->string('image_url')->nullable();
            $table->string('sku')->nullable()->index();
            $table->unsignedBigInteger('category_id')->nullable()->index();

            // status
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes(); // opsional: hapus lembut untuk keamanan data
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};