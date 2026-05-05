<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::with('user', 'details')->latest();

        if ($request->status && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where('kode_pesanan', 'like', '%' . $request->search . '%');
        }

        $pesanans = $query->paginate(20);

        $stats = [
            'total_penjualan' => Pesanan::where('status', 'selesai')->sum('total'),
            'pesanan_baru'    => Pesanan::whereDate('created_at', today())->count(),
            'siap_kirim'      => Pesanan::where('status', 'diproses')->count(),
        ];

        return view('admin.pesanan.index', compact('pesanans', 'stats'));
    }

    public function show(Pesanan $pesanan)
    {
        $pesanan->load('user', 'details.produk');
        return view('admin.pesanan.show', compact('pesanan'));
    }

    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status' => 'required|in:menunggu_pembayaran,menunggu_verifikasi,diproses,dikirim,selesai,dibatalkan',
        ]);

        $current = $pesanan->status;
        $next = $request->status;

        // 🔒 RULE FLOW (ANTI LONCAT)
        $allowedTransitions = [
            'menunggu_pembayaran' => ['menunggu_verifikasi', 'dibatalkan'],
            'menunggu_verifikasi' => ['diproses', 'dibatalkan'],
            'diproses'            => ['dikirim'],
            'dikirim'             => ['selesai'],
        ];

        if (isset($allowedTransitions[$current]) && !in_array($next, $allowedTransitions[$current])) {
            return back()->with('error', 'Perubahan status tidak valid!');
        }

        $pesanan->update([
            'status' => $next
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}