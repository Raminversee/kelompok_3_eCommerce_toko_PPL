<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('produks', function (Blueprint $table) {
            $table->boolean('is_published')->default(true)->after('gambar');
            $table->string('berat')->nullable()->after('is_published');
            $table->string('dimensi')->nullable()->after('berat');
            $table->string('material')->nullable()->after('dimensi');
        });
    }
    public function down(): void {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn(['is_published','berat','dimensi','material','min_stok']);
        });
    }
};