<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'kode', 'nama', 'tipe', 'nilai',
        'min_belanja', 'maks_diskon', 'kuota',
        'terpakai', 'tanggal_mulai', 'tanggal_selesai', 'is_active',
    ];

    protected $casts = [
        'is_active'       => 'boolean',
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    // Cek apakah voucher masih valid
    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        if ($this->tanggal_mulai && $this->tanggal_mulai->gt(now())) return false;
        if ($this->tanggal_selesai && $this->tanggal_selesai->lt(now())) return false;
        if ($this->kuota !== null && $this->terpakai >= $this->kuota) return false;
        return true;
    }

    // Hitung nominal diskon berdasarkan subtotal
    public function hitungDiskon(float $subtotal): float
    {
        if ($subtotal < $this->min_belanja) return 0;

        if ($this->tipe === 'persen') {
            $diskon = $subtotal * ($this->nilai / 100);
            if ($this->maks_diskon) {
                $diskon = min($diskon, $this->maks_diskon);
            }
            return $diskon;
        }

        // nominal
        return min($this->nilai, $subtotal);
    }

    public function getNilaiFormatAttribute(): string
    {
        if ($this->tipe === 'persen') {
            return $this->nilai . '%';
        }
        return 'Rp ' . number_format($this->nilai, 0, ',', '.');
    }
}