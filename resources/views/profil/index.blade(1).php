@extends('layouts.app')
@section('title', 'Profil Saya — Plazza Bangunan Sukses')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
<div class="flex gap-6">

    {{-- ===== SIDEBAR KIRI ===== --}}
    <aside class="w-56 flex-shrink-0">

        <div class="bg-white rounded-3xl border border-gray-200 p-6 text-center shadow-sm mb-3">

            {{-- ✅ AVATAR DINAMIS --}}
            <div class="relative w-20 h-20 mx-auto mb-3">
                @if(auth()->user()->foto)
                    <img src="{{ asset('storage/' . auth()->user()->foto) }}"
                         class="w-20 h-20 rounded-full object-cover border-2 border-gray-200">
                @else
                    <div class="w-20 h-20 rounded-full flex items-center justify-center text-white text-2xl font-bold"
                         style="background: linear-gradient(135deg, #0d1b2e, #1e40af);">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <p class="font-bold text-gray-900 text-sm">{{ auth()->user()->name }}</p>
            <p class="text-xs text-gray-400 mt-0.5 break-all">{{ auth()->user()->email }}</p>
        </div>

        {{-- MENU --}}
        <nav class="bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-sm">

            <a href="{{ route('profil.index') }}"
               class="flex items-center gap-3 px-5 py-3.5 text-sm font-semibold
                      bg-blue-50 text-navy-700 border-r-2 border-navy-700">
                Profil Saya
            </a>

            <a href="{{ route('riwayat.index') }}"
               class="flex items-center gap-3 px-5 py-3.5 text-sm font-semibold text-gray-600 hover:bg-gray-50 border-t">
                Pesanan Saya
            </a>

            <a href="#ubah-password"
               class="flex items-center gap-3 px-5 py-3.5 text-sm font-semibold text-gray-600 hover:bg-gray-50 border-t">
                Password
            </a>

            <div class="border-t">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-5 py-3.5 text-sm text-red-500 hover:bg-red-50">
                        Keluar
                    </button>
                </form>
            </div>

        </nav>
    </aside>

    {{-- ===== KONTEN KANAN ===== --}}
    <div class="flex-1 space-y-5">

        {{-- ================= FORM PROFIL ================= --}}
        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-8">

            <h1 class="text-2xl font-bold text-gray-900 mb-1">Edit Profil</h1>

            @if(session('success'))
                <div class="mb-5 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ✅ FORM FIX --}}
            <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
                @csrf

                {{-- ================= FOTO UPLOAD ================= --}}
                <div class="text-center mb-6"
                     x-data="{ preview: '{{ auth()->user()->foto ? asset('storage/'.auth()->user()->foto) : '' }}' }">

                    <div class="relative w-24 h-24 mx-auto mb-2">

                        {{-- Preview foto --}}
                        <template x-if="preview">
                            <img :src="preview"
                                 class="w-24 h-24 rounded-full object-cover border-2 border-gray-200">
                        </template>

                        {{-- fallback inisial --}}
                        <template x-if="!preview">
                            <div class="w-24 h-24 rounded-full flex items-center justify-center text-white text-2xl font-bold"
                                 style="background: linear-gradient(135deg, #0d1b2e, #1e40af);">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </template>

                        {{-- tombol upload --}}
                        <label class="absolute bottom-0 right-0 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center cursor-pointer">
                            <input type="file" name="foto" class="hidden"
                                   accept="image/*"
                                   @change="preview = URL.createObjectURL($event.target.files[0])">

                            📷
                        </label>
                    </div>

                    <p class="text-xs text-gray-400">Klik untuk ganti foto</p>
                </div>

                {{-- ================= FORM FIELD ================= --}}
                <div class="grid grid-cols-2 gap-5 mb-5">

                    <div>
                        <label>Nama</label>
                        <input type="text" name="name"
                               value="{{ old('name', auth()->user()->name) }}"
                               class="w-full border rounded-xl px-4 py-2">
                    </div>

                    <div>
                        <label>Email</label>
                        <input type="text"
                               value="{{ auth()->user()->email }}"
                               class="w-full border bg-gray-100 rounded-xl px-4 py-2"
                               readonly>
                    </div>

                </div>

                <div class="mb-4">
                    <label>Telepon</label>
                    <input type="text" name="telepon"
                           value="{{ old('telepon', auth()->user()->telepon) }}"
                           class="w-full border rounded-xl px-4 py-2">
                </div>

                <div class="mb-6">
                    <label>Alamat</label>
                    <textarea name="alamat"
                              class="w-full border rounded-xl px-4 py-2">{{ old('alamat', auth()->user()->alamat) }}</textarea>
                </div>

                <div class="text-right">
                    <button class="bg-[#0d1b2e] text-white px-6 py-2 rounded-xl">
                        Simpan
                    </button>
                </div>

            </form>
        </div>

        {{-- ================= PASSWORD ================= --}}
        <div id="ubah-password" class="bg-white rounded-3xl border p-8">

            <h2 class="text-xl font-bold mb-4">Ubah Password</h2>

            <form method="POST" action="{{ route('profil.password') }}">
                @csrf

                <input type="password" name="password_lama" placeholder="Password lama"
                       class="w-full border rounded-xl px-4 py-2 mb-3">

                <input type="password" name="password" placeholder="Password baru"
                       class="w-full border rounded-xl px-4 py-2 mb-3">

                <input type="password" name="password_confirmation" placeholder="Konfirmasi"
                       class="w-full border rounded-xl px-4 py-2 mb-3">

                <div class="text-right">
                    <button class="border px-6 py-2 rounded-xl">
                        Update Password
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
</div>
@endsection