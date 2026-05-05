<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PembayaranController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

    // ─── Public Promo ────────────────────────────────────────────
        Route::get('/promo', [App\Http\Controllers\PromoController::class, 'index'])->name('promo.index');

    // ─── Voucher (User) ──────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/voucher/apply',  [App\Http\Controllers\VoucherController::class, 'apply'])->name('voucher.apply');
    Route::post('/voucher/remove', [App\Http\Controllers\VoucherController::class, 'remove'])->name('voucher.remove');
});

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', [ProdukController::class, 'home'])->name('home');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{slug}', [ProdukController::class, 'show'])->name('produk.show');

/*
|--------------------------------------------------------------------------
| USER (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |----------------------------------------
    | KERANJANG
    |----------------------------------------
    */
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::patch('/keranjang/update/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::delete('/keranjang/kosongkan', [KeranjangController::class, 'kosongkan'])->name('keranjang.kosongkan');

    /*
    |----------------------------------------
    | CHECKOUT
    |----------------------------------------
    */
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'proses'])->name('checkout.proses');

    // ✅ 🔥 FIX UTAMA — BELI LANGSUNG
    Route::post('/beli-langsung', [CheckoutController::class, 'beliLangsung'])
        ->name('beli.langsung');

    /*
    |----------------------------------------
    | PEMBAYARAN
    |----------------------------------------
    */
    Route::get('/pembayaran/{id}/upload', [PembayaranController::class, 'upload'])->name('pembayaran.upload');
    Route::post('/pembayaran/{id}/kirim', [PembayaranController::class, 'kirim'])->name('pembayaran.kirim');

    /*
    |----------------------------------------
    | RIWAYAT PESANAN
    |----------------------------------------
    */
    Route::get('/riwayat', [App\Http\Controllers\RiwayatPesananController::class, 'index'])
        ->name('riwayat.index');

    Route::get('/riwayat/{pesanan}', [App\Http\Controllers\RiwayatPesananController::class, 'show'])
        ->name('riwayat.show');

    /*
    |----------------------------------------
    | PROFIL
    |----------------------------------------
    */
    Route::get('/profil', [App\Http\Controllers\ProfilController::class, 'index'])->name('profil.index');
    Route::post('/profil', [App\Http\Controllers\ProfilController::class, 'update'])->name('profil.update');
    Route::post('/profil/password', [App\Http\Controllers\ProfilController::class, 'ubahPassword'])->name('profil.password');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'is_admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('produk', App\Http\Controllers\Admin\ProdukController::class);

        Route::get('stok', [App\Http\Controllers\Admin\StokController::class, 'index'])
            ->name('stok.index');

        /*
        |----------------------------------------
        | PESANAN
        |----------------------------------------
        */
        Route::get('pesanan', [App\Http\Controllers\Admin\PesananController::class, 'index'])
            ->name('pesanan.index');

        Route::get('pesanan/{pesanan}', [App\Http\Controllers\Admin\PesananController::class, 'show'])
            ->name('pesanan.show');

        Route::patch('pesanan/{pesanan}/status', [App\Http\Controllers\Admin\PesananController::class, 'updateStatus'])
            ->name('pesanan.updateStatus');

        /*
        |----------------------------------------
        | VERIFIKASI
        |----------------------------------------
        */
        Route::get('verifikasi', [App\Http\Controllers\Admin\VerifikasiController::class, 'index'])
            ->name('verifikasi.index');

        Route::post('verifikasi/{pesanan}/approve', [App\Http\Controllers\Admin\VerifikasiController::class, 'approve'])
            ->name('verifikasi.approve');

        Route::post('verifikasi/{pesanan}/tolak', [App\Http\Controllers\Admin\VerifikasiController::class, 'tolak'])
            ->name('verifikasi.tolak');

            /*
        |----------------------------------------
        | Export Excel Laporan
        |----------------------------------------
        */
        Route::get('laporan/export', [App\Http\Controllers\Admin\LaporanController::class, 'exportExcel'])
            ->name('laporan.export');

        /*
        |----------------------------------------
        | LAPORAN
        |----------------------------------------
        */
        Route::get('laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])
            ->name('laporan.index');

        /*
        |----------------------------------------
        | USER MANAGEMENT
        |----------------------------------------
        */
        Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
        Route::post('users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
        Route::patch('users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggleStatus');
        Route::post('users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.resetPassword');
        Route::delete('users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
        // Promo
        Route::resource('promo', App\Http\Controllers\Admin\PromoController::class);
        // Voucher
Route::resource('voucher', App\Http\Controllers\Admin\VoucherController::class);
Route::get('voucher/generate-kode', [App\Http\Controllers\Admin\VoucherController::class, 'generateKode'])
     ->name('voucher.generateKode');

    });