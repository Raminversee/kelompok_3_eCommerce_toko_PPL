@extends('admin.layouts.admin')
@section('title', 'Verifikasi Pembayaran')

@section('content')
<div class="p-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Verifikasi Pembayaran</h1>
            <p class="text-gray-500 mt-1">Validasi bukti transfer pelanggan untuk memproses pesanan.</p>
        </div>
        <form method="GET" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari Order ID..."
                   class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-56">
        </form>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="mb-5 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mb-5 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
        {{ session('error') }}
    </div>
    @endif

    {{-- List Verifikasi --}}
    <div class="space-y-4">
        @forelse($pesanans as $p)
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 flex items-center gap-6">

            {{-- Info Pesanan --}}
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-sm font-bold text-gray-700 bg-gray-100 px-3 py-1 rounded-full">
                        #{{ $p->kode_pesanan }}
                    </span>
                    <span class="text-xs font-bold text-yellow-700 bg-yellow-100 px-3 py-1 rounded-full uppercase">
                        Menunggu
                    </span>
                </div>
                <p class="text-xl font-bold text-gray-900">{{ $p->user->name ?? '-' }}</p>
                <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $p->bukti_uploaded_at ? $p->bukti_uploaded_at->format('d M Y, H:i') : $p->updated_at->format('d M Y, H:i') }}
                    </span>
                    <span class="flex items-center gap-1 font-semibold text-navy-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        {{ $p->total_format }}
                    </span>
                </div>
            </div>

            {{-- Bukti Transfer --}}
            <div class="w-40 flex-shrink-0">
                @if($p->bukti_transfer)
                <a href="{{ asset('storage/' . $p->bukti_transfer) }}" target="_blank">
                    <div class="w-40 h-28 rounded-xl overflow-hidden bg-gray-100 border border-gray-200 cursor-pointer hover:opacity-90 transition-opacity relative group">
                        <img src="{{ asset('storage/' . $p->bukti_transfer) }}"
                             class="w-full h-full object-cover" alt="Bukti Transfer">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 flex items-center justify-center transition-all">
                            <span class="text-white text-xs font-bold opacity-0 group-hover:opacity-100">Klik Memperbesar</span>
                        </div>
                    </div>
                    <p class="text-xs text-center text-gray-400 mt-1">Klik untuk memperbesar</p>
                </a>
                @else
                <div class="w-40 h-28 rounded-xl bg-gray-100 border border-dashed border-gray-300 flex items-center justify-center">
                    <p class="text-xs text-gray-400 text-center">Belum ada<br>bukti transfer</p>
                </div>
                @endif
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex flex-col gap-3 w-40 flex-shrink-0">
                <form method="POST" action="{{ route('admin.verifikasi.approve', $p->id) }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-navy-700 text-white font-bold py-3 rounded-xl text-sm hover:bg-navy-800 transition-colors"
                            style="background-color:#0d1b2e;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Verifikasi
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.verifikasi.tolak', $p->id) }}"
                      onsubmit="return confirm('Tolak bukti transfer ini?')">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 border-2 border-red-500 text-red-600 font-bold py-3 rounded-xl text-sm hover:bg-red-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Tolak
                    </button>
                </form>
            </div>

        </div>
        @empty
        <div class="text-center py-20 bg-white rounded-2xl border border-gray-200">
            <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="font-bold text-gray-700">Tidak ada yang perlu diverifikasi</p>
            <p class="text-sm text-gray-400 mt-1">Semua bukti transfer sudah diproses ✅</p>
        </div>
        @endforelse
    </div>

</div>
@endsection