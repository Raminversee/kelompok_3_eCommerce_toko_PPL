<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'foto',
        'role',
        'password',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at'     => 'datetime',
        'is_active'         => 'boolean',
        // ❌ HAPUS 'password' => 'hashed'
    ];

    // ✅ CEK ADMIN
    // ===============================
    // ROLE
    // ===============================

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdminPembelian(): bool
    {
        return $this->role === 'admin_pembelian';
    }

    public function isAdminPenjualan(): bool
    {
        return $this->role === 'admin_penjualan';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, [
            'super_admin',
            'admin_pembelian',
            'admin_penjualan',
        ]);
    }

    // ✅ URL FOTO
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return asset('storage/' . $this->foto);
        }
        return '';
    }

    // RELASI
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }
}