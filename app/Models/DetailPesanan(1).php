<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $fillable = [
        'pesanan_id', 'produk_id',
        'nama_produk', 'sku', 'qty', 'harga', 'subtotal',
    ];

    public function produk()  { return $this->belongsTo(Produk::class); }
    public function pesanan() { return $this->belongsTo(Pesanan::class); }

    public function getHargaFormatAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function getSubtotalFormatAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }
}