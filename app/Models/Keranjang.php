<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $fillable = ['user_id', 'produk_id', 'qty'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->qty * $this->produk->harga;
    }

    public function getSubtotalFormatAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }
}