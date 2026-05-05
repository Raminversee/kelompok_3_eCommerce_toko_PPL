<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
        'sku',
        'kategori',
        'deskripsi',
        'spesifikasi',
        'harga',
        'harga_coret',
        'diskon_persen',
        'stok',
        'min_stok',
        'gambar',
        'berat',
        'dimensi',
        'material',
        'is_promo',
        'is_new',
        'is_active',
        'is_published',
    ];

    protected $casts = [
        'harga'          => 'decimal:2',
        'harga_coret'    => 'decimal:2',
        'is_promo'       => 'boolean',
        'is_new'         => 'boolean',
        'is_active'      => 'boolean',
        'is_published'   => 'boolean',
        'spesifikasi'    => 'array', // tetap dipakai
    ];

    /*
    |--------------------------------------------------------------------------
    | 🔥 SAFE ACCESSOR (ANTI ERROR ARRAY)
    |--------------------------------------------------------------------------
    */

    public function getSpesifikasiTextAttribute(): string
    {
        if (is_array($this->spesifikasi)) {
            return implode(', ', $this->spesifikasi);
        }

        return (string) $this->spesifikasi;
    }

    /*
    |--------------------------------------------------------------------------
    | 🔥 FORMAT HARGA
    |--------------------------------------------------------------------------
    */

    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format((float)$this->harga, 0, ',', '.');
    }

    public function getHargaCoretFormatAttribute(): ?string
    {
        if (!$this->harga_coret) return null;

        return 'Rp ' . number_format((float)$this->harga_coret, 0, ',', '.');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔥 GAMBAR (SAFE)
    |--------------------------------------------------------------------------
    */

    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar && file_exists(public_path('storage/' . $this->gambar))) {
            return asset('storage/' . $this->gambar);
        }

        return 'https://via.placeholder.com/500x500?text=No+Image';
    }

    /*
    |--------------------------------------------------------------------------
    | 🔥 STATUS LABEL
    |--------------------------------------------------------------------------
    */

    public function getStatusLabelAttribute(): string
    {
        if (!$this->is_active) return 'Nonaktif';
        if (!$this->is_published) return 'Draft';

        return 'Aktif';
    }

    /*
    |--------------------------------------------------------------------------
    | 🔥 SCOPE
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query
            ->where('is_active', true)
            ->where('is_published', true);
    }
}