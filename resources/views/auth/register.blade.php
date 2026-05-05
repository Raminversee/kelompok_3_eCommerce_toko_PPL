@extends('layouts.auth')
@section('title', 'Daftar Akun — Plazza Bangunan Sukses')

@section('content')
<div class="w-full max-w-lg">

    {{-- Logo --}}
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-14 h-14 bg-navy-700 rounded-2xl mb-3 shadow-lg">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1
                         0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </div>
        <p class="text-xs font-bold text-gray-500 tracking-widest">PLAZZA</p>
        <p class="text-xs font-semibold text-gray-400 tracking-widest">BANGUNAN SUKSES</p>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-navy-700 to-navy-600 px-8 py-6 text-center">
            <h1 class="text-xl font-bold text-white">Ingin Punya Akun?</h1>
            <p class="text-sm text-blue-200 mt-1">
                Pendaftaran akun dilakukan oleh admin Plazza Bangunan Sukses.
            </p>
        </div>

        <div class="px-8 py-8">

            {{-- Info box --}}
            <div class="bg-blue-50 rounded-2xl p-5 mb-7 border border-blue-100">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-navy-700 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-navy-700 text-sm mb-1">Cara Mendapatkan Akun:</p>
                        <ol class="text-sm text-gray-600 space-y-1.5 list-none">
                            <li class="flex items-start gap-2">
                                <span class="bg-navy-700 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">1</span>
                                Hubungi admin melalui WhatsApp atau email di bawah
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="bg-navy-700 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">2</span>
                                Berikan data: nama lengkap, email, dan nomor telepon
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="bg-navy-700 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">3</span>
                                Admin akan membuat akun dan mengirimkan password Anda
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="bg-navy-700 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">4</span>
                                Login dengan email dan password yang diberikan admin
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            {{-- Kontak Admin --}}
            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3 text-center">
                Hubungi Admin Sekarang
            </p>
            <div class="space-y-3 mb-7">
                <a href="https://wa.me/6287877438920?text=Halo%20Admin%20Plazza%2C%20saya%20ingin%20mendaftar%20akun."
                   target="_blank"
                   class="flex items-center gap-3 bg-green-500 hover:bg-green-400 text-white
                          font-bold py-3.5 px-5 rounded-xl transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    WhatsApp: 087877438920
                </a>

                <a href="mailto:admin@plazzabangunan.com?subject=Permohonan%20Pembuatan%20Akun"
                   class="flex items-center gap-3 border-2 border-navy-700 text-navy-700
                          font-bold py-3.5 px-5 rounded-xl hover:bg-navy-700 hover:text-white transition-all">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2
                                 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    admin@plazzabangunan.com
                </a>
            </div>

            <p class="text-center text-sm text-gray-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-navy-700 hover:text-navy-600 ml-1">
                    Masuk sekarang
                </a>
            </p>
        </div>
    </div>

    <p class="text-center text-xs text-gray-400 mt-6 tracking-widest">
        © 2026 PLAZZA BANGUNAN SUKSES • PREMIUM BUILDING MATERIALS
    </p>
</div>
@endsection