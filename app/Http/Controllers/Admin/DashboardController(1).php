<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik
        $totalProduk      = Produk::count();
        $pesananHariIni   = Pesanan::whereDate('created_at', today())->count();
        $menungguVerifikasi = Pesanan::where('status', 'menunggu_verifikasi')->count();
        $pendapatanBulanIni = Pesanan::where('status', 'selesai')
                                     ->whereMonth('created_at', now()->month)
                                     ->sum('total');

        // Pesanan terbaru (5 terakhir)
        $pesananTerbaru = Pesanan::with('user', 'details.produk')
                                 ->latest()
                                 ->take(5)
                                 ->get();

        // Stok menipis (stok < minimum stok, ambil dari Produk)
        $stokMenipis = Produk::whereColumn('stok', '<', DB::raw('COALESCE(min_stok, 10)'))
                             ->orderBy('stok')
                             ->take(4)
                             ->get();

   return view('admin.dashboard', compact(
    'totalProduk',
    'pesananHariIni',
    'menungguVerifikasi',
    'pendapatanBulanIni',
    'pesananTerbaru',
    'stokMenipis'
));
    }
}