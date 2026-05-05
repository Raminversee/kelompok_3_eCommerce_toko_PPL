<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Promo extends Model
{
    protected $fillable = [
        'judul', 'slug', 'deskripsi', 'gambar',
        'badge_text', 'badge_color',
        'tanggal_mulai', 'tanggal_selesai',
        'is_active', 'urutan',
    ];

    protected $casts = [
        'is_active'       => 'boolean',
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];

    // Auto generate slug
    public static function boot()
    {
        parent::boot();
        static::creating(function ($promo) {
            if (empty($promo->slug)) {
                $promo->slug = Str::slug($promo->judul) . '-' . time();
            }
        });
    }

    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar && file_exists(public_path('storage/' . $this->gambar))) {
            return asset('storage/' . $this->gambar);
        }
        return 'https://via.placeholder.com/800x400?text=Promo';
    }

    public function getIsAktifSekarangAttribute(): bool
    {
        $now = now()->toDateString();
        if ($this->tanggal_mulai && $this->tanggal_mulai->gt(now())) return false;
        if ($this->tanggal_selesai && $this->tanggal_selesai->lt(now())) return false;
        return $this->is_active;
    }

    public function scopeAktif($query)
    {
        return $query->where('is_active', true)
                     ->where(function ($q) {
                         $q->whereNull('tanggal_mulai')->orWhere('tanggal_mulai', '<=', now());
                     })
                     ->where(function ($q) {
                         $q->whereNull('tanggal_selesai')->orWhere('tanggal_selesai', '>=', now());
                     })
                     ->orderBy('urutan');
    }
}