<?php
namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    // Apply voucher — dipanggil via AJAX dari halaman checkout
    public function apply(Request $request)
    {
        $request->validate(['kode' => 'required|string']);

        $kode    = strtoupper(trim($request->kode));
        $voucher = Voucher::where('kode', $kode)->first();

        if (!$voucher) {
            return response()->json(['success' => false, 'message' => 'Kode voucher tidak ditemukan.']);
        }

        if (!$voucher->isValid()) {
            return response()->json(['success' => false, 'message' => 'Voucher sudah tidak berlaku atau kuota habis.']);
        }

        // Hitung subtotal keranjang saat ini
        $items    = Keranjang::with('produk')->where('user_id', Auth::id())->get();
        $subtotal = $items->sum('subtotal');

        if ($subtotal < $voucher->min_belanja) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum belanja Rp ' . number_format($voucher->min_belanja, 0, ',', '.') . ' untuk menggunakan voucher ini.',
            ]);
        }

        $diskon = $voucher->hitungDiskon($subtotal);

        // Simpan ke session
        session(['voucher_kode' => $kode, 'voucher_diskon' => $diskon]);

        return response()->json([
            'success'  => true,
            'message'  => 'Voucher berhasil diterapkan!',
            'kode'     => $kode,
            'diskon'   => $diskon,
            'diskon_format' => 'Rp ' . number_format($diskon, 0, ',', '.'),
        ]);
    }

    // Hapus voucher dari session
    public function remove()
    {
        session()->forget(['voucher_kode', 'voucher_diskon']);
        return response()->json(['success' => true]);
    }
}