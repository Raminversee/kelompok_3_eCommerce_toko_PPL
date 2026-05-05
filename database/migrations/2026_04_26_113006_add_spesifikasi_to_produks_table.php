<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->json('spesifikasi')->nullable()->after('deskripsi');
            $table->decimal('harga_coret', 12, 2)->nullable()->after('harga');
            $table->integer('diskon_persen')->nullable()->after('harga_coret');
        });
    }

    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn(['spesifikasi', 'harga_coret', 'diskon_persen']);
        });
    }
};