<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;

class StokController extends Controller
{
    public function index()
    {
        $produks = Produk::orderBy('stok')->get();

        return view('admin.stok.index', compact('produks'));
    }
}