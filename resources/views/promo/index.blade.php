@extends('layouts.app')
@section('title', 'Promo — Plazza Bangunan Sukses')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">

    {{-- Header --}}
    <div class="text-center mb-10">
        <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-2">🔥 Penawaran Spesial</p>
        <h1 class="text-4xl font-bold text-gray-900 mb-3">Promo & Diskon Terbaik</h1>
        <p class="text-gray-500 max-w-xl mx-auto">
            Dapatkan penawaran terbaik material bangunan premium dengan harga spesial. Jangan sampai ketinggalan!
        </p>
    </div>

    {{-- Grid Promo --}}
    @forelse($promos as $promo)
    <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden mb-6 hover:shadow-md transition-shadow">
        <div class="grid grid-cols-1 md:grid-cols-2">

            {{-- Gambar --}}
            <div class="relative h-64 md:h-auto bg-gray-100">
                <img src="{{ $promo->gambar_url }}"
                     class="w-full h-full object-cover" alt="{{ $promo->judul }}">
                @if($promo->badge_text)
                @php
                    $bc = ['red'=>'bg-red-500','blue'=>'bg-blue-500','green'=>'bg-green-500','orange'=>'bg-orange-500'][$promo->badge_color ?? 'red'] ?? 'bg-red-500';
                @endphp
                <span class="absolute top-4 left-4 {{ $bc }} text-white text-sm font-bold px-4 py-1.5 rounded-full shadow-lg">
                    {{ $promo->badge_text }}
                </span>
                @endif
            </div>

            {{-- Detail --}}
            <div class="p-8 flex flex-col justify-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ $promo->judul }}</h2>

                @if($promo->tanggal_selesai)
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-semibold text-red-500">
                        Berlaku s/d {{ $promo->tanggal_selesai->format('d M Y') }}
                    </span>
                </div>
                @endif

                @if($promo->deskripsi)
                <p class="text-gray-600 text-sm leading-relaxed mb-6">
                    {{ $promo->deskripsi }}
                </p>
                @endif

                <a href="{{ route('produk.index') }}"
                   class="inline-flex items-center gap-2 text-white font-bold px-6 py-3 rounded-xl text-sm hover:opacity-90 transition-opacity w-fit"
                   style="background-color:#0d1b2e;">
                    Belanja Sekarang
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-20 bg-white rounded-3xl border border-gray-200">
        <div class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
        </div>
        <p class="font-bold text-gray-700 text-lg">Belum ada promo aktif saat ini</p>
        <p class="text-gray-400 text-sm mt-1">Pantau terus halaman ini untuk penawaran terbaru!</p>
        <a href="{{ route('produk.index') }}"
           class="inline-block mt-4 text-white font-semibold px-6 py-3 rounded-xl text-sm hover:opacity-90"
           style="background-color:#0d1b2e;">
            Lihat Semua Produk
        </a>
    </div>
    @endforelse

    @if($promos->hasPages())
    <div class="mt-6">{{ $promos->links() }}</div>
    @endif

</div>
@endsection