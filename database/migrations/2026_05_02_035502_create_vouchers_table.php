<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->enum('tipe', ['persen', 'nominal'])->default('nominal');
            $table->decimal('nilai', 15, 2);                     // 20 = 20% atau Rp 20.000
            $table->decimal('min_belanja', 15, 2)->default(0);   // minimum belanja
            $table->decimal('maks_diskon', 15, 2)->nullable();   // max diskon untuk tipe persen
            $table->integer('kuota')->nullable();                 // null = unlimited
            $table->integer('terpakai')->default(0);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tambah kolom diskon & voucher ke tabel pesanans
        Schema::table('pesanans', function (Blueprint $table) {
            $table->string('voucher_kode')->nullable()->after('total');
            $table->decimal('diskon', 15, 2)->default(0)->after('voucher_kode');
        });
    }

    public function down(): void {
        Schema::dropIfExists('vouchers');
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn(['voucher_kode', 'diskon']);
        });
    }
};