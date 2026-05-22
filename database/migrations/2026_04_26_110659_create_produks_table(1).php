<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('sku')->unique()->nullable();
            $table->enum('kategori', [
                'Kran & Shower',
                'Wastafel & Bak Cuci',
                'Dudukan Kloset',
                'Handle Pintu',
                'Gembok',
                'Aksesoris Kamar Mandi',
            ]);
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 12, 2);
            $table->integer('stok')->default(0);
            $table->string('gambar')->nullable();
            $table->boolean('is_promo')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};