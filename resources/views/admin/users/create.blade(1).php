@extends('admin.layouts.admin')
@section('title', 'Buat Akun User')

@section('content')
<div class="p-6 max-w-2xl">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.users.index') }}"
           class="p-2 hover:bg-gray-100 rounded-lg transition-colors text-gray-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Buat Akun User Baru</h1>
            <p class="text-sm text-gray-500">Buatkan akun untuk pelanggan yang menghubungi admin</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 p-7">

        @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           placeholder="Contoh: Budi Santoso" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                  focus:outline-none focus:ring-2 focus:ring-navy-700
                                  @error('name') border-red-400 @enderror">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Nomor Telepon <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" name="phone" value="{{ old('phone') }}"
                           placeholder="08xxxxxxxxxx" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                  focus:outline-none focus:ring-2 focus:ring-navy-700
                                  @error('phone') border-red-400 @enderror">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}"
                       placeholder="nama@email.com" required
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                              focus:outline-none focus:ring-2 focus:ring-navy-700
                              @error('email') border-red-400 @enderror">
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" required
                           placeholder="Min. 8 karakter"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                  focus:outline-none focus:ring-2 focus:ring-navy-700
                                  @error('password') border-red-400 @enderror">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" required
                           placeholder="Ulangi password"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                  focus:outline-none focus:ring-2 focus:ring-navy-700">
                </div>
            </div>

            <div class="bg-blue-50 rounded-xl p-4 text-sm text-blue-700 border border-blue-100">
                💡 Setelah akun dibuat, informasikan email dan password kepada pelanggan melalui WhatsApp atau email.
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.users.index') }}"
                   class="px-6 py-3 border border-gray-200 text-gray-700 font-semibold
                          rounded-xl hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="px-8 py-3 bg-navy-700 text-white font-bold rounded-xl
                               hover:bg-navy-800 transition-colors">
                    Buat Akun
                </button>
            </div>
        </form>
    </div>
</div>
@endsection