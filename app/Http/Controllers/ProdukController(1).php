<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // HOME
    public function home()
    {
        $produkTerbaru = Produk::active()
            ->latest()
            ->take(8)
            ->get();

        $kategoris = config('plazza.kategoris');

        return view('home', compact('produkTerbaru', 'kategoris'));
    }

    // KATALOG PRODUK
    public function index(Request $request)
    {
        $query = Produk::active();
        $kategoris = config('plazza.kategoris');

        // 🔥 FILTER KATEGORI (slug → db)
        if ($request->filled('kategori')) {

            $kat = collect($kategoris)->firstWhere('slug', $request->kategori);

            if ($kat) {
                $query->whereRaw('LOWER(kategori) = ?', [strtolower($kat['db'])]);
            }
        }

        // 🔥 SEARCH (q)
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->q . '%')
                  ->orWhere('sku', 'like', '%' . $request->q . '%');
            });
        }

        // 🔥 HARGA
        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', $request->harga_min);
        }

        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', $request->harga_max);
        }

        // 🔥 STOK
        if ($request->boolean('stok_ada')) {
            $query->where('stok', '>', 0);
        }

        // 🔥 SORT
        match ($request->get('sort', 'terbaru')) {
            'harga_asc'  => $query->orderBy('harga', 'asc'),
            'harga_desc' => $query->orderBy('harga', 'desc'),
            default      => $query->latest(),
        };

        $produks = $query->paginate(9)->withQueryString();

        return view('produk.index', compact('produks', 'kategoris'));
    }

    // DETAIL
    public function show($slug)
    {
        $produk = Produk::active()
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Produk::active()
            ->where('kategori', $produk->kategori)
            ->where('id', '!=', $produk->id)
            ->take(4)
            ->get();

        return view('produk.show', compact('produk', 'related'));
    }
}