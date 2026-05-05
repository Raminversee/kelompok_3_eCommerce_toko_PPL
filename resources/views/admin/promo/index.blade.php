@extends('admin.layouts.admin')
@section('title', 'Kelola Promo')

@section('content')
<div class="p-8">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Promo</h1>
            <p class="text-gray-500 text-sm mt-1">Atur banner dan info promo yang tampil di halaman publik</p>
        </div>
        <a href="{{ route('admin.promo.create') }}"
           class="flex items-center gap-2 text-white font-bold px-5 py-3 rounded-xl text-sm hover:opacity-90"
           style="background-color:#0d1b2e;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Promo
        </a>
    </div>

    @if(session('success'))
    <div class="mb-5 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" x-data="{ showModal: false, deleteId: null, deleteJudul: '' }">

        @forelse($promos as $promo)
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            {{-- Gambar --}}
            <div class="h-40 bg-gray-100 relative overflow-hidden">
                <img src="{{ $promo->gambar_url }}"
                     class="w-full h-full object-cover" alt="{{ $promo->judul }}">
                @if($promo->badge_text)
                @php
                    $badgeColors = ['red'=>'bg-red-500','blue'=>'bg-blue-500','green'=>'bg-green-500','orange'=>'bg-orange-500'];
                    $bc = $badgeColors[$promo->badge_color ?? 'red'] ?? 'bg-red-500';
                @endphp
                <span class="absolute top-3 left-3 {{ $bc }} text-white text-xs font-bold px-3 py-1 rounded-full">
                    {{ $promo->badge_text }}
                </span>
                @endif
                <span class="absolute top-3 right-3 text-xs font-bold px-2.5 py-1 rounded-full
                    {{ $promo->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                    {{ $promo->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>

            <div class="p-5">
                <h3 class="font-bold text-gray-900 mb-1">{{ $promo->judul }}</h3>
                @if($promo->tanggal_selesai)
                <p class="text-xs text-gray-400 mb-3">
                    s/d {{ $promo->tanggal_selesai->format('d M Y') }}
                </p>
                @endif
                <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $promo->deskripsi ?? '-' }}</p>

                <div class="flex gap-2">
                    <a href="{{ route('admin.promo.edit', $promo->id) }}"
                       class="flex-1 text-center text-sm font-semibold py-2 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors">
                        Edit
                    </a>
                    <button @click="showModal=true; deleteId={{ $promo->id }}; deleteJudul='{{ addslashes($promo->judul) }}'"
                            class="flex-1 text-center text-sm font-semibold py-2 rounded-xl bg-red-50 text-red-500 hover:bg-red-100 transition-colors">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-20 bg-white rounded-2xl border border-gray-200">
            <p class="text-gray-400 font-semibold">Belum ada promo. Klik "+ Tambah Promo" untuk memulai.</p>
        </div>
        @endforelse

        {{-- Modal Hapus --}}
        <div x-show="showModal"
             class="fixed inset-0 z-50 flex items-center justify-center"
             style="display:none; background-color:rgba(0,0,0,0.5);">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-4 p-6 text-center">
                <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Promo?</h3>
                <p class="text-sm text-gray-500 mb-6">
                    Yakin hapus promo "<strong x-text="deleteJudul"></strong>"?
                </p>
                <div class="flex gap-3">
                    <button @click="showModal=false"
                            class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold">
                        Batal
                    </button>
                    <form :action="'/admin/promo/' + deleteId" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="w-full py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">{{ $promos->links() }}</div>
</div>
@endsection