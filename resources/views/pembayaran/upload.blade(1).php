@extends('layouts.app')
@section('title', 'Upload Bukti Transfer — Plazza Bangunan Sukses')

@section('content')
<div class="max-w-xl mx-auto px-4 py-12">

    @if(session('success'))
    <div class="mb-5 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-sm">

        {{-- Header --}}
        <div class="text-center py-8 px-6 border-b border-gray-100">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-navy-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0
                             01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-1">Upload Bukti Pembayaran</h1>
            <p class="text-sm text-gray-500">Pastikan bukti transfer terlihat jelas untuk verifikasi cepat.</p>
        </div>

        <div class="p-6 space-y-5">

            {{-- Info Pesanan --}}
            <div class="bg-gray-50 rounded-2xl p-5 text-center">
                <p class="text-xs font-bold text-gray-500 tracking-wider uppercase mb-1">ORDER ID</p>
                <p class="text-lg font-bold text-gray-900 mb-3">
                    #{{ $pesanan->kode_pesanan }}
                </p>
                <p class="text-xs text-gray-400 mb-1">Total Pembayaran</p>
                <p class="text-3xl font-bold text-navy-700">{{ $pesanan->total_format }}</p>
            </div>

            {{-- Info Bank --}}
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex gap-3">
                <svg class="w-5 h-5 text-navy-700 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                </svg>
                <div>
                    <p class="text-xs font-bold text-navy-700 uppercase mb-1">TRANSFER KE BANK BCA</p>
                    <p class="text-sm font-semibold text-gray-700 mb-0.5">Plazza Bangunan Sukses PT</p>
                    <div class="flex items-center gap-2">
                        <p class="text-xl font-bold text-navy-700 tracking-widest">822 091 1822</p>
                        <button onclick="navigator.clipboard.writeText('8220911822')"
                                class="text-navy-700 hover:text-navy-600" title="Salin nomor rekening">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6
                                         4h8a2 2 0 012 2v8a2 2 0 01-2 2h-8a2 2 0 01-2-2v-8a2 2 0 012-2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Upload Form --}}
            <form method="POST" action="{{ route('pembayaran.kirim', $pesanan->id) }}"
                  enctype="multipart/form-data">
                @csrf

                @error('bukti_transfer')
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
                    {{ $message }}
                </div>
                @enderror

                <div>
                    <p class="text-sm font-bold text-gray-700 mb-2">Pilih File Bukti Transfer</p>

                    {{-- Drop Zone --}}
                    <label for="bukti_transfer"
                           class="flex flex-col items-center justify-center w-full h-40
                                  border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer
                                  hover:border-navy-700 hover:bg-blue-50 transition-all group"
                           x-data="{ fileName: '' }"
                           @dragover.prevent
                           @drop.prevent="
                               fileName = $event.dataTransfer.files[0]?.name || '';
                               document.getElementById('bukti_transfer').files = $event.dataTransfer.files;
                           ">
                        <div class="text-center px-4" x-show="!fileName">
                            <svg class="w-10 h-10 text-gray-300 group-hover:text-navy-700 mx-auto mb-2 transition-colors"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15
                                         13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-sm font-semibold text-gray-600 group-hover:text-navy-700">
                                Klik atau seret file ke sini
                            </p>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, PDF (MAX. 5MB)</p>
                        </div>
                        <div x-show="fileName" class="text-center px-4">
                            <svg class="w-10 h-10 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm font-semibold text-green-600" x-text="fileName"></p>
                            <p class="text-xs text-gray-400 mt-0.5">File siap dikirim</p>
                        </div>
                        <input type="file" name="bukti_transfer" id="bukti_transfer"
                               accept=".jpg,.jpeg,.png,.pdf" class="hidden"
                               @change="fileName = $el.files[0]?.name || ''">
                    </label>
                </div>

                {{-- Info verifikasi --}}
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 flex gap-2">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-xs text-blue-700">
                        Verifikasi dilakukan secara manual oleh tim keuangan kami dalam waktu maksimal 1×24 jam kerja.
                    </p>
                </div>

                {{-- Tombol Submit --}}
                <button type="submit"
                        class="w-full bg-navy-700 text-white font-bold py-4 rounded-2xl
                               hover:bg-navy-800 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim Bukti Transfer
                </button>

                <a href="#" class="block text-center text-sm font-semibold text-gray-500 hover:text-navy-700">
                    Bantuan Pembayaran
                </a>
            </form>
        </div>
    </div>
</div>
@endsection