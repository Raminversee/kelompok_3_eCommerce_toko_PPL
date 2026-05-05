<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class RiwayatPesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Pesanan::where('user_id', auth()->id())
                        ->with('details.produk')
                        ->latest();

        // Filter berdasarkan status tab
        if ($request->status && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $pesanans = $query->paginate(10);

        return view('riwayat.index', compact('pesanans'));
    }

    public function show(Pesanan $pesanan)
    {
        // Pastikan pesanan milik user yang login
        abort_if($pesanan->user_id !== auth()->id(), 403);

        $pesanan->load('details.produk');

        return view('riwayat.show', compact('pesanan'));
    }
}