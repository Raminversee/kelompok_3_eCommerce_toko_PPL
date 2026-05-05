<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::where('status', 'menunggu_verifikasi')
                        ->with('user')
                        ->latest();

        if ($request->search) {
            $query->where('kode_pesanan', 'like', '%' . $request->search . '%');
        }

        $pesanans = $query->get();

        return view('admin.verifikasi.index', compact('pesanans'));
    }

    public function approve(Pesanan $pesanan)
    {
        $pesanan->update(['status' => 'diproses']);

        return back()->with('success', "Pesanan {$pesanan->kode_pesanan} berhasil diverifikasi.");
    }

    public function tolak(Pesanan $pesanan)
    {
        $pesanan->update([
            'status'          => 'menunggu_pembayaran',
            'bukti_transfer'  => null,
            'bukti_uploaded_at' => null,
        ]);

        return back()->with('error', "Bukti transfer pesanan {$pesanan->kode_pesanan} ditolak.");
    }
}