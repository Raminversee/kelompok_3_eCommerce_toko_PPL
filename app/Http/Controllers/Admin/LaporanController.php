<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dari    = $request->dari    ?? now()->startOfMonth()->format('Y-m-d');
        $sampai  = $request->sampai  ?? now()->format('Y-m-d');

        $query = Pesanan::where('status', 'selesai')
                        ->whereBetween('created_at', [$dari . ' 00:00:00', $sampai . ' 23:59:59']);

        $totalTransaksi   = $query->count();
        $totalPendapatan  = $query->sum('total');
        $rataRataTransaksi = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;

        // Produk terlaris
        $produkTerlaris = DetailPesanan::select(
                'produk_id',
                DB::raw('SUM(qty) as total_terjual'),
                DB::raw('SUM(subtotal) as total_pendapatan')
            )
            ->with('produk')
            ->whereHas('pesanan', function ($q) use ($dari, $sampai) {
                $q->where('status', 'selesai')
                  ->whereBetween('created_at', [$dari . ' 00:00:00', $sampai . ' 23:59:59']);
            })
            ->groupBy('produk_id')
            ->orderByDesc('total_terjual')
            ->take(10)
            ->get();

        return view('admin.laporan.index', compact(
            'dari', 'sampai',
            'totalTransaksi', 'totalPendapatan', 'rataRataTransaksi',
            'produkTerlaris'
        ));
    }

    public function exportExcel(Request $request)
{
    $dari   = $request->dari   ?? now()->startOfMonth()->format('Y-m-d');
    $sampai = $request->sampai ?? now()->format('Y-m-d');

    // Data transaksi lengkap
    $pesanans = \App\Models\Pesanan::with(['user', 'details.produk'])
        ->where('status', 'selesai')
        ->whereBetween('created_at', [$dari . ' 00:00:00', $sampai . ' 23:59:59'])
        ->orderBy('created_at', 'desc')
        ->get();

    // Produk terlaris
    $produkTerlaris = \App\Models\DetailPesanan::select(
            'produk_id',
            \Illuminate\Support\Facades\DB::raw('SUM(qty) as total_terjual'),
            \Illuminate\Support\Facades\DB::raw('SUM(subtotal) as total_pendapatan')
        )
        ->with('produk')
        ->whereHas('pesanan', function ($q) use ($dari, $sampai) {
            $q->where('status', 'selesai')
              ->whereBetween('created_at', [$dari . ' 00:00:00', $sampai . ' 23:59:59']);
        })
        ->groupBy('produk_id')
        ->orderByDesc('total_terjual')
        ->get();

    $totalPendapatan = $pesanans->sum('total');
    $totalTransaksi  = $pesanans->count();

    $filename = 'Laporan_Plazza_' . $dari . '_sd_' . $sampai . '.csv';

    $headers = [
        'Content-Type'        => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        'Pragma'              => 'no-cache',
        'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
        'Expires'             => '0',
    ];

    $callback = function () use ($pesanans, $produkTerlaris, $dari, $sampai, $totalPendapatan, $totalTransaksi) {
        $file = fopen('php://output', 'w');

        // BOM untuk Excel agar baca UTF-8 dengan benar
        fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // ─── HEADER LAPORAN ───────────────────────────────────────
        fputcsv($file, ['LAPORAN PENJUALAN PLAZZA BANGUNAN SUKSES']);
        fputcsv($file, ['Periode:', $dari . ' s/d ' . $sampai]);
        fputcsv($file, ['Dicetak:', now()->format('d/m/Y H:i')]);
        fputcsv($file, ['Total Transaksi:', $totalTransaksi]);
        fputcsv($file, ['Total Pendapatan:', 'Rp ' . number_format($totalPendapatan, 0, ',', '.')]);
        fputcsv($file, []); // baris kosong

        // ─── SHEET 1: DETAIL TRANSAKSI ───────────────────────────
        fputcsv($file, ['── DETAIL TRANSAKSI ──']);
        fputcsv($file, [
            'No',
            'Kode Pesanan',
            'Nama Pelanggan',
            'Email',
            'Produk',
            'Qty',
            'Harga Satuan',
            'Subtotal Item',
            'Ongkir',
            'Total Pesanan',
            'Tanggal',
        ]);

        $no = 1;
        foreach ($pesanans as $pesanan) {
            foreach ($pesanan->details as $detail) {
                fputcsv($file, [
                    $no++,
                    $pesanan->kode_pesanan,
                    $pesanan->user->name ?? '-',
                    $pesanan->user->email ?? '-',
                    $detail->nama_produk,
                    $detail->qty,
                    $detail->harga,
                    $detail->subtotal,
                    $pesanan->ongkir,
                    $pesanan->total,
                    $pesanan->created_at->format('d/m/Y H:i'),
                ]);
            }
        }

        fputcsv($file, []); // baris kosong
        fputcsv($file, []); // baris kosong

        // ─── SHEET 2: PRODUK TERLARIS ─────────────────────────────
        fputcsv($file, ['── PRODUK TERLARIS ──']);
        fputcsv($file, ['No', 'Nama Produk', 'SKU', 'Kategori', 'Total Terjual', 'Total Pendapatan']);

        foreach ($produkTerlaris as $i => $item) {
            fputcsv($file, [
                $i + 1,
                $item->produk->nama ?? 'Produk dihapus',
                $item->produk->sku ?? '-',
                $item->produk->kategori ?? '-',
                $item->total_terjual,
                $item->total_pendapatan,
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}