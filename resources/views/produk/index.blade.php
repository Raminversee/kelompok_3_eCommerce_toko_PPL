@extends('layouts.app')
@section('title', 'Katalog Produk — Plazza Bangunan Sukses')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- ── PAGE HEADER ────────────────────────────────────── --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Katalog Produk</h1>
        <p class="text-gray-500 mt-1">Temukan material bangunan berkualitas untuk hunian Anda.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- ── SIDEBAR FILTER ─────────────────────────────── --}}
        <aside class="w-full lg:w-64 flex-shrink-0">
            <form method="GET" action="{{ route('produk.index') }}" id="filterForm"
                  class="bg-white rounded-2xl border border-gray-200 p-5 space-y-5 sticky top-20">

                {{-- SEARCH --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Cari Produk
                    </label>
                    <div class="relative">
                        <input type="text"
                               name="q"
                               value="{{ request('q') }}"
                               placeholder="Nama produk atau SKU..."
                               class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm
                                      focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-8">
                        <svg class="w-4 h-4 text-gray-400 absolute right-3 top-3" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                {{-- KATEGORI --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Kategori
                    </label>
                    <div class="space-y-1">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" name="kategori" value=""
                                   {{ !request('kategori') ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()"
                                   class="text-blue-600">
                            <span class="text-sm text-gray-700 group-hover:text-navy-700">Semua Kategori</span>
                        </label>
                        @foreach($kategoris as $kat)
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" name="kategori" value="{{ $kat['slug'] }}"
                                   {{ request('kategori') == $kat['slug'] ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()"
                                   class="text-blue-600">
                            <span class="text-sm text-gray-700 group-hover:text-navy-700">
                                {{ $kat['icon'] }} {{ $kat['nama'] }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- RANGE HARGA --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Rentang Harga
                    </label>
                    <div class="space-y-2">
                        <input type="number" name="harga_min"
                               value="{{ request('harga_min') }}"
                               placeholder="Min (Rp)"
                               class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm">
                        <input type="number" name="harga_max"
                               value="{{ request('harga_max') }}"
                               placeholder="Max (Rp)"
                               class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm">
                    </div>
                </div>

                {{-- STOK --}}
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="stok_ada" value="1"
                               {{ request('stok_ada') ? 'checked' : '' }}
                               class="rounded text-blue-600">
                        <span class="text-sm text-gray-700">Hanya stok tersedia</span>
                    </label>
                </div>

                {{-- URUTAN --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Urutkan
                    </label>
                    <select name="sort"
                            onchange="document.getElementById('filterForm').submit()"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm">
                        <option value="terbaru"    {{ request('sort','terbaru') === 'terbaru'    ? 'selected' : '' }}>Terbaru</option>
                        <option value="harga_asc"  {{ request('sort') === 'harga_asc'  ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="harga_desc" {{ request('sort') === 'harga_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                </div>

                {{-- TOMBOL --}}
                <div class="flex gap-2 pt-1">
                    <button type="submit"
                            class="flex-1 text-white text-sm font-bold py-2.5 rounded-xl transition-opacity hover:opacity-90"
                            style="background-color:#0d1b2e;">
                        Terapkan
                    </button>
                    <a href="{{ route('produk.index') }}"
                       class="flex-1 text-center text-gray-600 text-sm font-semibold py-2.5 rounded-xl border border-gray-200 hover:bg-gray-50">
                        Reset
                    </a>
                </div>

            </form>
        </aside>

        {{-- ── PRODUCT GRID ────────────────────────────────── --}}
        <div class="flex-1 min-w-0">

            {{-- Result info --}}
            <div class="flex items-center justify-between mb-5">
                <p class="text-sm text-gray-500">
                    @if($produks->total() > 0)
                        Menampilkan <span class="font-semibold text-gray-800">{{ $produks->firstItem() }}–{{ $produks->lastItem() }}</span>
                        dari <span class="font-semibold text-gray-800">{{ $produks->total() }}</span> produk
                    @else
                        Tidak ada produk ditemukan
                    @endif
                </p>

                {{-- Active filter badge --}}
                @if(request('kategori'))
                    @php
                        $activeKat = collect($kategoris)->firstWhere('slug', request('kategori'));
                    @endphp
                    @if($activeKat)
                    <span class="inline-flex items-center gap-1 text-xs font-semibold bg-blue-50
                                 text-blue-700 px-3 py-1 rounded-full border border-blue-100">
                        {{ $activeKat['icon'] }} {{ $activeKat['nama'] }}
                        <a href="{{ route('produk.index', array_filter(request()->except('kategori'))) }}"
                           class="ml-1 hover:text-blue-900">✕</a>
                    </span>
                    @endif
                @endif
            </div>

            {{-- Grid --}}
            @if($produks->isEmpty())
            <div class="text-center py-20">
                <div class="text-5xl mb-4">📦</div>
                <p class="text-gray-500 font-semibold text-lg">Produk tidak ditemukan</p>
                <p class="text-gray-400 text-sm mt-1">Coba ubah filter atau kata kunci pencarian Anda.</p>
                <a href="{{ route('produk.index') }}"
                   class="inline-block mt-4 text-sm font-bold text-blue-600 hover:underline">
                    Lihat semua produk →
                </a>
            </div>
            @else
            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-3 gap-4">

                @foreach($produks as $produk)
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden
                            hover:shadow-md hover:border-gray-300 transition-all group">

                    {{-- Gambar --}}
                    <a href="{{ route('produk.show', $produk->slug) }}" class="block">
                        <div class="aspect-square bg-gray-100 overflow-hidden">
                            <img src="{{ $produk->gambar_url }}"
                                 alt="{{ $produk->nama }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    </a>

                    {{-- Info --}}
                    <div class="p-4">

                        {{-- Badge --}}
                        <div class="flex items-center gap-1 mb-2">
                            <span class="text-xs text-gray-400 uppercase font-medium">
                                {{ $produk->kategori }}
                            </span>
                            @if($produk->is_promo && $produk->diskon_persen)
                            <span class="ml-auto text-xs font-bold bg-red-500 text-white px-2 py-0.5 rounded-full">
                                -{{ $produk->diskon_persen }}%
                            </span>
                            @endif
                        </div>

                        {{-- Nama --}}
                        <a href="{{ route('produk.show', $produk->slug) }}">
                            <h3 class="text-sm font-bold text-gray-800 mb-2 line-clamp-2
                                       hover:text-navy-700 transition-colors">
                                {{ $produk->nama }}
                            </h3>
                        </a>

                        {{-- Harga --}}
                        <div class="mb-3">
                            <p class="text-base font-bold text-navy-700">
                                {{ $produk->harga_format }}
                            </p>
                            @if($produk->harga_coret_format)
                            <p class="text-xs text-gray-400 line-through">
                                {{ $produk->harga_coret_format }}
                            </p>
                            @endif
                        </div>

                        {{-- Stok --}}
                        @if($produk->stok <= 0)
                        <p class="text-xs text-red-400 font-semibold mb-2">Stok habis</p>
                        @endif

                        {{-- Aksi --}}
                        @if($produk->stok > 0)
                            @auth
                            <form method="POST" action="{{ route('keranjang.tambah', $produk->id) }}">
                                @csrf
                                <button class="w-full text-white text-xs font-bold py-2.5 rounded-xl
                                               transition-opacity hover:opacity-90"
                                        style="background-color:#0d1b2e;">
                                    🛒 Tambah ke Keranjang
                                </button>
                            </form>
                            @else
                            <a href="{{ route('login') }}"
                               class="block text-center w-full text-white text-xs font-bold py-2.5 rounded-xl
                                      transition-opacity hover:opacity-90"
                               style="background-color:#0d1b2e;">
                                Login untuk Beli
                            </a>
                            @endauth
                        @else
                            <button disabled
                                    class="w-full text-gray-400 text-xs font-bold py-2.5 rounded-xl
                                           bg-gray-100 cursor-not-allowed">
                                Stok Habis
                            </button>
                        @endif

                    </div>
                </div>
                @endforeach

            </div>

            {{-- PAGINATION --}}
            @if($produks->hasPages())
            <div class="mt-8 flex items-center justify-between text-sm text-gray-500">
                <span>
                    Halaman {{ $produks->currentPage() }} dari {{ $produks->lastPage() }}
                </span>
                <div class="flex items-center gap-1">

                    {{-- Prev --}}
                    @if($produks->onFirstPage())
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl border
                                 border-gray-200 text-gray-300 cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </span>
                    @else
                    <a href="{{ $produks->appends(request()->query())->previousPageUrl() }}"
                       class="w-9 h-9 flex items-center justify-center rounded-xl border
                              border-gray-200 hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    @endif

                    {{-- Page numbers --}}
                    @foreach($produks->appends(request()->query())->getUrlRange(
                        max(1, $produks->currentPage()-2),
                        min($produks->lastPage(), $produks->currentPage()+2)
                    ) as $page => $url)
                    <a href="{{ $url }}"
                       class="w-9 h-9 flex items-center justify-center rounded-xl text-sm font-semibold transition-colors
                              {{ $page == $produks->currentPage()
                                    ? 'text-white'
                                    : 'border border-gray-200 hover:bg-gray-50 text-gray-600' }}"
                       style="{{ $page == $produks->currentPage() ? 'background-color:#0d1b2e;' : '' }}">
                        {{ $page }}
                    </a>
                    @endforeach

                    {{-- Next --}}
                    @if($produks->hasMorePages())
                    <a href="{{ $produks->appends(request()->query())->nextPageUrl() }}"
                       class="w-9 h-9 flex items-center justify-center rounded-xl border
                              border-gray-200 hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    @else
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl border
                                 border-gray-200 text-gray-300 cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                    @endif

                </div>
            </div>
            @endif

            @endif {{-- end $produks->isEmpty() --}}
        </div>
        {{-- ── END PRODUCT GRID ─────────────────────────── --}}

    </div>
</div>

@endsection