@extends('layouts.app')
@section('title', 'Beranda — Plazza Bangunan Sukses')

@section('content')

{{-- ── HERO BANNER ─────────────────────────────────────────── --}}
<section class="bg-navy-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

            {{-- TEXT --}}
            <div>
                <h1 class="text-4xl lg:text-5xl font-bold leading-tight mb-4">
                    Perlengkapan Bangunan Rumah Lengkap di Satu Tempat
                </h1>

                <p class="text-blue-200 text-base mb-8 leading-relaxed max-w-md">
                    Temukan produk berkualitas tinggi untuk setiap sudut hunian Anda
                    dengan standar konstruksi terbaik.
                </p>

                <a href="{{ route('produk.index') }}"
                   class="inline-flex items-center gap-2 bg-white text-navy-700 font-bold
                          px-6 py-3 rounded-xl hover:bg-blue-50 transition-colors">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>

                    Lihat Produk
                </a>
            </div>

            {{-- IMAGE HERO --}}
            <div class="hidden lg:block">
                <div class="relative rounded-2xl overflow-hidden h-72 shadow-lg">
                    <img src="{{ asset('images/mewah.jfif') }}"
                         alt="Hero Banner"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/20"></div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ── KATEGORI UNGGULAN (FIX PAKAI CONTROLLER) ───────────────── --}}
<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Kategori Unggulan</h2>

            <a href="{{ route('produk.index') }}"
               class="text-sm font-semibold text-navy-700 hover:text-navy-600">
                Lihat Semua Kategori →
            </a>
        </div>

        <div class="grid grid-cols-3 sm:grid-cols-6 gap-4">

    @foreach($kategoris as $kat)
    <a href="{{ route('produk.index', ['kategori' => $kat['slug']]) }}"
       class="group flex flex-col items-center p-4 rounded-2xl border border-gray-200
              hover:border-navy-700 hover:bg-blue-50 transition-all">

        <span class="text-3xl mb-2">
            {{ $kat['icon'] }}
        </span>

        <span class="text-xs font-semibold text-gray-700 text-center
                     group-hover:text-navy-700">
            {{ $kat['nama'] }}
        </span>
    </a>
    @endforeach

        </div>

    </div>
</section>


{{-- ── PROMO ───────────────────────────────────────── --}}
<section class="bg-blue-50 border-y border-blue-100">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">

        <div class="flex items-center gap-3">
            <span class="bg-navy-700 text-white text-xs font-bold px-3 py-1 rounded-full">
                PROMO
            </span>

            <p class="text-sm text-gray-700 font-medium">
                Diskon hingga 35% minggu ini!
            </p>
        </div>

        <a href="{{ route('produk.index') }}"
           class="text-sm font-bold text-navy-700">
            Klaim →
        </a>

    </div>
</section>


{{-- ── PRODUK TERBARU ───────────────────────────────────────── --}}
<section class="py-14">
    <div class="max-w-7xl mx-auto px-4">

        <h2 class="text-2xl font-bold mb-8">Produk Terbaru</h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">

            @forelse($produkTerbaru as $produk)

            <div class="bg-white rounded-2xl border overflow-hidden hover:shadow-md">

                <a href="{{ route('produk.show', $produk->slug) }}">
                    <div class="aspect-square bg-gray-100">
                        <img src="{{ $produk->gambar_url }}"
                             class="w-full h-full object-cover">
                    </div>
                </a>

                <div class="p-4">

                    <p class="text-xs text-gray-400 uppercase">
                        {{ $produk->kategori }}
                    </p>

                    <h3 class="text-sm font-bold mb-2">
                        {{ $produk->nama }}
                    </h3>

                    <p class="text-navy-700 font-bold mb-3">
                        {{ $produk->harga_format }}
                    </p>

                    <form method="POST" action="{{ route('keranjang.tambah', $produk->id) }}">
                        @csrf
                        <button class="w-full bg-navy-700 text-white text-xs py-2 rounded-lg">
                            + Tambah
                        </button>
                    </form>

                </div>

            </div>

            @empty
                <p>Belum ada produk</p>
            @endforelse

        </div>

    </div>
</section>


{{-- ── FITUR KEUNGGULAN ───────────────────── --}}
<section class="py-14 bg-gray-50 border-y border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">

            <div>
                <div class="text-blue-600 text-4xl mb-3">🛡️</div>
                <h3 class="font-bold text-gray-900 mb-1">Produk Bergaransi</h3>
                <p class="text-sm text-gray-500">
                    Jaminan kualitas produk asli dengan garansi resmi produsen.
                </p>
            </div>

            <div>
                <div class="text-blue-600 text-4xl mb-3">🏷️</div>
                <h3 class="font-bold text-gray-900 mb-1">Harga Transparan</h3>
                <p class="text-sm text-gray-500">
                    Harga kompetitif tanpa biaya tersembunyi untuk proyek Anda.
                </p>
            </div>

            <div>
                <div class="text-blue-600 text-4xl mb-3">🚚</div>
                <h3 class="font-bold text-gray-900 mb-1">Pengiriman Cepat</h3>
                <p class="text-sm text-gray-500">
                    Layanan kirim ke seluruh Indonesia dengan proteksi maksimal.
                </p>
            </div>

            <div>
                <div class="text-blue-600 text-4xl mb-3">🎧</div>
                <h3 class="font-bold text-gray-900 mb-1">Konsultasi Ahli</h3>
                <p class="text-sm text-gray-500">
                    Tim ahli kami siap membantu memilih material yang tepat.
                </p>
            </div>

        </div>

    </div>
</section>

@endsection