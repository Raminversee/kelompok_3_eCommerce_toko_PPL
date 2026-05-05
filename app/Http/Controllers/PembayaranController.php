<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    // Halaman upload bukti transfer
    public function upload($id)
    {
        $pesanan = Pesanan::with('details.produk')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        // Cegah akses kalau status bukan menunggu pembayaran
        if ($pesanan->status !== 'menunggu_pembayaran') {
            return redirect()->route('riwayat.index')
                ->with('info', 'Pesanan ini sudah diproses.');
        }

        return view('pembayaran.upload', compact('pesanan'));
    }

    // Proses upload bukti transfer
    public function kirim(Request $request, $id)
    {
        $request->validate([
            'bukti_transfer' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120', // 5MB
            ],
        ], [
            'bukti_transfer.required' => 'File bukti transfer wajib diunggah.',
            'bukti_transfer.mimes'    => 'Format file harus JPG, PNG, atau PDF.',
            'bukti_transfer.max'      => 'Ukuran file maksimal 5 MB.',
        ]);

        $pesanan = Pesanan::where('user_id', Auth::id())
            ->findOrFail($id);

        // Hapus file lama kalau ada
        if ($pesanan->bukti_transfer) {
            Storage::disk('public')->delete($pesanan->bukti_transfer);
        }

        // Simpan file baru
        $path = $request->file('bukti_transfer')
            ->store('bukti_transfer', 'public');

        // Update data pesanan
        $pesanan->update([
            'bukti_transfer'    => $path,
            'bukti_uploaded_at'=> now(),
            'status'            => 'menunggu_verifikasi',
        ]);

        return redirect()->route('riwayat.show', $pesanan->id)
            ->with('success', 'Bukti transfer berhasil dikirim! Admin akan memverifikasi dalam 1×24 jam.');
    }
}