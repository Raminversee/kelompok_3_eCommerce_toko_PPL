@extends('layouts.app')
@section('title', 'Pesanan Saya — Plazza Bangunan Sukses')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Pesanan Saya</h1>
        <p class="text-gray-500 mt-1">Lacak status material konstruksi dan kebutuhan bangunan Anda.</p>
    </div>

    {{-- Tab Filter Status --}}
    <div class="flex gap-2 flex-wrap mb-8">
        @foreach([
            'semua'                => 'Semua',
            'menunggu_pembayaran'  => 'Menunggu',
            'diproses'             => 'Diproses',
            'dikirim'              => 'Dikirim',
            'selesai'              => 'Selesai',
        ] as $key => $label)
        <a href="{{ route('riwayat.index', ['status' => $key]) }}"
           class="px-5 py-2 rounded-full text-sm font-semibold transition-colors
                  {{ (request('status', 'semua') === $key)
                        ? 'bg-navy-700 text-white'
                        : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- List Pesanan --}}
    @forelse($pesanans as $pesanan)
    <div class="bg-white border border-gray-200 rounded-3xl p-6 mb-4 shadow-sm hover:shadow-md transition-shadow">

        {{-- Header Kartu --}}
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                {{-- Icon status --}}
                <div class="w-10 h-10 rounded-xl flex items-center justify-center
                    {{ $pesanan->status === 'selesai' ? 'bg-green-50' :
                       ($pesanan->status === 'dikirim' ? 'bg-purple-50' :
                       ($pesanan->status === 'diproses' ? 'bg-indigo-50' : 'bg-gray-100')) }}">
                    @if($pesanan->status === 'selesai')
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @elseif($pesanan->status === 'dikirim')
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    @else
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <p class="font-bold text-gray-900 text-sm">{{ $pesanan->kode_pesanan }}</p>
                    <p class="text-xs text-gray-400">{{ $pesanan->created_at->format('d F Y, H:i') }} WIB</p>
                </div>
            </div>

            {{-- Badge Status --}}
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
            <span class="text-xs font-bold px-3 py-1 rounded-full {{ $badgeColor }} uppercase tracking-wider">
                {{ $pesanan->status_label }}
            </span>
        </div>

        {{-- Produk (tampilkan item pertama) --}}
        @if($pesanan->details->first())
        @php $item = $pesanan->details->first(); @endphp
        <div class="flex items-center gap-4 mb-4">
            <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                @if($item->produk && $item->produk->gambar)
                    <img src="{{ asset('storage/' . $item->produk->gambar) }}"
                         class="w-full h-full object-cover" alt="{{ $item->nama_produk }}">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
            </div>
            <div>
                <p class="font-semibold text-gray-800 text-sm">{{ $item->nama_produk }}</p>
                <p class="text-xs text-gray-500">
                    Qty: {{ $item->qty }}
                    @if($item->sku) • SKU: {{ $item->sku }} @endif
                    @if($pesanan->details->count() > 1)
                        • <span class="text-navy-700">+{{ $pesanan->details->count() - 1 }} produk lainnya</span>
                    @endif
                </p>
                <p class="text-xs font-semibold text-gray-400 uppercase mt-1 tracking-wider">Total Pesanan</p>
                <p class="text-lg font-bold text-navy-700">{{ $pesanan->total_format }}</p>
            </div>
        </div>
        @endif

        {{-- Tombol Aksi --}}
        <div class="flex gap-3">
            <a href="{{ route('riwayat.show', $pesanan->id) }}"
               class="flex-1 text-center border border-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl text-sm hover:bg-gray-50 transition-colors">
                Lihat Detail
            </a>
            @if($pesanan->status === 'menunggu_pembayaran')
            <a href="{{ route('pembayaran.upload', $pesanan->id) }}"
               class="flex-1 text-center bg-navy-700 text-white font-semibold py-2.5 rounded-xl text-sm hover:bg-navy-800 transition-colors">
                Upload Bukti
            </a>
            @endif
        </div>

    </div>
    @empty
    <div class="text-center py-20">
        <div class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <p class="font-bold text-gray-700 text-lg">Belum ada pesanan</p>
        <p class="text-gray-400 text-sm mt-1">Yuk mulai belanja material bangunan!</p>
        <a href="{{ route('produk.index') }}"
           class="inline-block mt-4 bg-navy-700 text-white font-semibold px-6 py-3 rounded-xl text-sm hover:bg-navy-800 transition-colors">
            Belanja Sekarang
        </a>
    </div>
    @endforelse

    {{-- Pagination --}}
    @if($pesanans->hasPages())
    <div class="mt-6">
        {{ $pesanans->appends(request()->query())->links() }}
    </div>
    @endif

</div>
@endsection