<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Data pengiriman
            $table->string('nama_penerima');
            $table->string('telepon');
            $table->text('alamat');
            $table->string('kota');
            $table->string('provinsi');
            $table->string('kode_pos');
            // Pembayaran
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('ongkir', 12, 2)->default(50000);
            $table->decimal('total', 12, 2)->default(0);
            $table->enum('status', [
                'menunggu_pembayaran',
                'menunggu_verifikasi',
                'diproses',
                'dikirim',
                'selesai',
                'dibatalkan',
            ])->default('menunggu_pembayaran');
            $table->string('bukti_transfer')->nullable();
            $table->timestamp('bukti_uploaded_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pesanans'); }
};