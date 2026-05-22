@extends('layouts.app')
@section('title', 'Detail Pesanan — Plazza Bangunan Sukses')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">

    @if(session('success'))
    <div class="mb-5 bg-green-50 border border-green-200 text-green-700
                rounded-xl px-5 py-4 flex items-center gap-3">
        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1
                  1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1
                  1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span class="font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Kode Pesanan --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-8 text-center mb-5">
        <div class="text-5xl mb-4">🎉</div>
        <h1 class="text-2xl font-bold text-gray-900 mb-1">Pesanan Berhasil Dibuat!</h1>
        <p class="text-gray-400 text-sm mb-4">Kode Pesanan:</p>
        <p class="text-2xl font-bold text-navy-700 mb-3">
            #{{ $pesanan->kode_pesanan }}
        </p>
        <span class="inline-block bg-yellow-100 text-yellow-700 text-sm font-bold
                     px-4 py-1 rounded-full">
            {{ $pesanan->status_label }}
        </span>
    </div>

    {{-- Detail Produk --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6 mb-5">
        <h2 class="font-bold text-gray-900 mb-4">Produk Dipesan</h2>
        <div class="space-y-3">
            @foreach($pesanan->details as $detail)
            <div class="flex justify-between items-center py-2 border-b border-gray-50 last:border-0">
                <div>
                    <p class="text-sm font-semibold text-gray-900">{{ $detail->nama_produk }}</p>
                    <p class="text-xs text-gray-400">{{ $detail->qty }} unit × {{ $detail->harga_format }}</p>
                </div>
                <p class="font-bold text-gray-900 text-sm">{{ $detail->subtotal_format }}</p>
            </div>
            @endforeach
        </div>
        <div class="border-t border-gray-200 pt-3 mt-3 flex justify-between">
            <span class="font-bold text-gray-900">Total Pembayaran</span>
            <span class="font-bold text-navy-700 text-lg">{{ $pesanan->total_format }}</span>
        </div>
    </div>

    {{-- Tombol aksi --}}
    <div class="flex gap-3">
        @if($pesanan->status === 'menunggu_pembayaran')
        <a href="{{ route('pembayaran.upload', $pesanan->id) }}"
           class="flex-1 bg-navy-700 text-white font-bold px-6 py-3 rounded-xl
                  hover:bg-navy-800 transition-colors text-center">
            Upload Bukti Transfer
        </a>
        @endif
        <a href="{{ route('home') }}"
           class="flex-1 border border-gray-200 text-gray-700 font-bold px-6 py-3
                  rounded-xl hover:bg-gray-50 transition-colors text-center">
            Kembali Belanja
        </a>
    </div>
</div>
@endsection