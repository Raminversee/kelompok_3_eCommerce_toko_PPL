<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = [
        'kode_pesanan',
        'user_id',

        // alamat
        'nama_penerima',
        'telepon',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',

        // 🔥 KEUANGAN (UPDATED)
        'subtotal',
        'ongkir',
        'diskon',        // ✅ TAMBAH
        'total',
        'voucher_kode',  // ✅ TAMBAH

        // status
        'status',

        // bukti
        'bukti_transfer',
        'bukti_uploaded_at',
    ];

    protected $casts = [
        'bukti_uploaded_at' => 'datetime',
        'subtotal'          => 'integer',
        'ongkir'            => 'integer',
        'diskon'            => 'integer', // ✅ TAMBAH
        'total'             => 'integer',
    ];

    // ================= RELATION =================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    // ================= FORMAT =================
    public function getTotalFormatAttribute()
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    public function getSubtotalFormatAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    public function getDiskonFormatAttribute()
    {
        return 'Rp ' . number_format($this->diskon ?? 0, 0, ',', '.');
    }

    // ================= STATUS =================
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'diproses'            => 'Diproses',
            'dikirim'             => 'Dikirim',
            'selesai'             => 'Selesai',
            'dibatalkan'          => 'Dibatalkan',
            default               => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'menunggu_pembayaran' => 'yellow',
            'menunggu_verifikasi' => 'blue',
            'diproses'            => 'indigo',
            'dikirim'             => 'purple',
            'selesai'             => 'green',
            'dibatalkan'          => 'red',
            default               => 'gray',
        };
    }

    // ================= GENERATE KODE =================
    public static function generateKode(): string
    {
        do {
            $kode = 'PBS-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
        } while (self::where('kode_pesanan', $kode)->exists());

        return $kode;
    }
}