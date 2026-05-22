@extends('layouts.app')
@section('title', 'Detail Pesanan ' . $pesanan->kode_pesanan)

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">

    {{-- Back --}}
    <a href="{{ route('riwayat.index') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-navy-700 mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Riwayat
    </a>

    {{-- Header --}}
    <div class="bg-white border border-gray-200 rounded-3xl p-6 mb-4 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">ORDER ID</p>
                <p class="text-xl font-bold text-gray-900">{{ $pesanan->kode_pesanan }}</p>
                <p class="text-sm text-gray-400 mt-0.5">{{ $pesanan->created_at->format('d F Y, H:i') }} WIB</p>
            </div>
            @php
                $badgeColor = [
                    'menunggu_pembayaran'  => 'bg-yellow-100 text-yellow-700',
                    'menunggu_verifikasi'  => 'bg-blue-100 text-blue-700',
                    'diproses'             => 'bg-indigo-100 text-indigo-700',
                    'dikirim'              => 'bg-purple-100 text-purple-700',
                    'selesai'              => 'bg-green-100 text-green-700',
                    'dibatalkan'           => 'bg-red-100 text-red-700',
                ][$pesanan->status] ?? 'bg-gray-100 text-gray-700';
            @endphp
            <span class="text-sm font-bold px-4 py-1.5 rounded-full {{ $badgeColor }}">
                {{ $pesanan->status_label }}
            </span>
        </div>

        {{-- Produk-produk --}}
        <div class="border-t border-gray-100 pt-4 space-y-3">
            @foreach($pesanan->details as $item)
            <div class="flex items-center gap-3">
                <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                    @if($item->produk && $item->produk->gambar)
                        <img src="{{ asset('storage/' . $item->produk->gambar) }}"
                             class="w-full h-full object-cover" alt="{{ $item->nama_produk }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-800 text-sm">{{ $item->nama_produk }}</p>
                    <p class="text-xs text-gray-500">Qty: {{ $item->qty }} × Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                </div>
                <p class="font-bold text-gray-900 text-sm">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>

        {{-- Ringkasan Harga --}}
        <div class="border-t border-gray-100 mt-4 pt-4 space-y-2">
            <div class="flex justify-between text-sm text-gray-500">
                <span>Subtotal</span>
                <span>Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-500">
                <span>Ongkos Kirim</span>
                <span>Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between font-bold text-gray-900 text-base border-t border-gray-100 pt-2 mt-2">
                <span>Total</span>
                <span class="text-navy-700">{{ $pesanan->total_format }}</span>
            </div>
        </div>
    </div>

    {{-- Alamat Pengiriman --}}
    <div class="bg-white border border-gray-200 rounded-3xl p-6 mb-4 shadow-sm">
        <p class="font-bold text-gray-900 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-navy-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Alamat Pengiriman
        </p>
        <p class="font-semibold text-gray-800">{{ $pesanan->nama_penerima }}</p>
        <p class="text-sm text-gray-500 mt-0.5">{{ $pesanan->telepon }}</p>
        <p class="text-sm text-gray-600 mt-1">{{ $pesanan->alamat }}, {{ $pesanan->kota }}, {{ $pesanan->provinsi }} {{ $pesanan->kode_pos }}</p>
    </div>

    {{-- Bukti Bayar / Aksi --}}
    @if($pesanan->status === 'menunggu_pembayaran')
    <a href="{{ route('pembayaran.upload', $pesanan->id) }}"
       class="block w-full text-center bg-navy-700 text-white font-bold py-4 rounded-2xl hover:bg-navy-800 transition-colors">
        Upload Bukti Transfer
    </a>
    @elseif($pesanan->bukti_transfer)
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 text-sm text-blue-700 text-center">
        Bukti transfer telah dikirim. Menunggu verifikasi tim keuangan.
    </div>
    @endif

</div>
@endsection