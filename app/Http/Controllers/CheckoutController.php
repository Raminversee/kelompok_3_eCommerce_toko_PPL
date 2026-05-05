<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * BELI LANGSUNG
     */
    public function beliLangsung(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'qty'       => 'required|integer|min:1|max:999',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        if ($produk->stok < $request->qty) {
            return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $produk->stok);
        }

        // Kosongkan keranjang lama
        Keranjang::where('user_id', Auth::id())->delete();

        // Tambahkan produk langsung
        Keranjang::create([
            'user_id'   => Auth::id(),
            'produk_id' => $produk->id,
            'qty'       => $request->qty,
        ]);

        return redirect()
            ->route('checkout.index')
            ->with('success', 'Produk siap di-checkout.');
    }

    /**
     * HALAMAN CHECKOUT
     */
    public function index()
    {
        $items = Keranjang::with('produk')
            ->where('user_id', Auth::id())
            ->get();

        if ($items->isEmpty()) {
            return redirect()
                ->route('keranjang.index')
                ->with('error', 'Keranjang Anda kosong.');
        }

        $subtotal     = $items->sum('subtotal');
        $ongkir       = 50000;
        $diskon       = (float) session('voucher_diskon', 0);
        $voucher_kode = session('voucher_kode');
        $total        = max(0, $subtotal + $ongkir - $diskon);
        $user         = Auth::user();

        return view('checkout.index', compact(
            'items',
            'subtotal',
            'ongkir',
            'diskon',
            'voucher_kode',
            'total',
            'user'
        ));
    }

    /**
     * PROSES CHECKOUT
     */
    public function proses(Request $request)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'telepon'       => 'required|string|max:20',
            'alamat'        => 'required|string',
            'kota'          => 'required|string|max:100',
            'provinsi'      => 'required|string|max:100',
            'kode_pos'      => 'required|string|max:10',
        ]);

        $items = Keranjang::with('produk')
            ->where('user_id', Auth::id())
            ->get();

        if ($items->isEmpty()) {
            return redirect()
                ->route('keranjang.index')
                ->with('error', 'Keranjang Anda kosong.');
        }

        $pesananId = null;

        DB::transaction(function () use ($request, $items, &$pesananId) {

            $subtotal     = $items->sum('subtotal');
            $ongkir       = 50000;
            $diskon       = (float) session('voucher_diskon', 0);
            $voucher_kode = session('voucher_kode');
            $total        = max(0, $subtotal + $ongkir - $diskon);

            $pesanan = Pesanan::create([
                'kode_pesanan'  => Pesanan::generateKode(),
                'user_id'       => Auth::id(),
                'nama_penerima' => $request->nama_penerima,
                'telepon'       => $request->telepon,
                'alamat'        => $request->alamat,
                'kota'          => $request->kota,
                'provinsi'      => $request->provinsi,
                'kode_pos'      => $request->kode_pos,
                'subtotal'      => $subtotal,
                'ongkir'        => $ongkir,
                'diskon'        => $diskon,
                'voucher_kode'  => $voucher_kode,
                'total'         => $total,
                'status'        => 'menunggu_pembayaran',
            ]);

            foreach ($items as $item) {

                if ($item->produk->stok < $item->qty) {
                    throw new \Exception('Stok produk ' . $item->produk->nama . ' tidak mencukupi.');
                }

                DetailPesanan::create([
                    'pesanan_id'  => $pesanan->id,
                    'produk_id'   => $item->produk_id,
                    'nama_produk' => $item->produk->nama,
                    'sku'         => $item->produk->sku,
                    'qty'         => $item->qty,
                    'harga'       => $item->produk->harga,
                    'subtotal'    => $item->subtotal,
                ]);

                $item->produk->decrement('stok', $item->qty);
            }

            // Kosongkan keranjang
            Keranjang::where('user_id', Auth::id())->delete();

            // Update voucher
            if ($voucher_kode) {
                Voucher::where('kode', $voucher_kode)->increment('terpakai');

                session()->forget([
                    'voucher_kode',
                    'voucher_diskon'
                ]);
            }

            $pesananId = $pesanan->id;
        });

        return redirect()
            ->route('pembayaran.upload', $pesananId)
            ->with('success', 'Pesanan berhasil dibuat. Silakan upload bukti pembayaran.');
    }
}