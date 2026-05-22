<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Promo;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $items = Keranjang::with('produk')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $items->sum(function ($item) {
            return $item->qty * $item->produk->harga;
        });

        // ✅ Ambil diskon & voucher_kode dari session
        $diskon       = (float) session('voucher_diskon', 0);
        $voucher_kode = session('voucher_kode');

        // ✅ Ambil promo aktif untuk ditampilkan di dropdown
        $promos = Promo::aktif()->get();

        return view('keranjang.index', compact(
            'items',
            'subtotal',
            'diskon',
            'voucher_kode',
            'promos'
        ));
    }

    public function tambah(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $qty    = $request->qty ?? 1;

        $item = Keranjang::where('user_id', Auth::id())
            ->where('produk_id', $id)
            ->first();

        if ($item) {
            $item->qty += $qty;
            $item->save();
        } else {
            Keranjang::create([
                'user_id'   => Auth::id(),
                'produk_id' => $id,
                'qty'       => $qty,
            ]);
        }

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $item = Keranjang::where('user_id', Auth::id())->findOrFail($id);

        $item->update(['qty' => $request->qty]);

        return response()->json([
            'subtotal' => 'Rp ' . number_format($item->qty * $item->produk->harga, 0, ',', '.'),
        ]);
    }

    public function hapus($id)
    {
        Keranjang::where('user_id', Auth::id())->findOrFail($id)->delete();

        return back()->with('success', 'Produk dihapus');
    }

    public function kosongkan()
    {
        Keranjang::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Keranjang dikosongkan');
    }
}
