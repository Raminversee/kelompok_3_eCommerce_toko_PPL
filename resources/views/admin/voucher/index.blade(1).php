@extends('admin.layouts.admin')
@section('title', 'Kelola Voucher')

@section('content')
<div class="p-8" x-data="{ showModal: false, deleteId: null, deleteKode: '', deleteNama: '' }">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Voucher</h1>
            <p class="text-gray-500 text-sm mt-1">Buat dan kelola kode diskon untuk pelanggan</p>
        </div>
        <a href="{{ route('admin.voucher.create') }}"
           class="flex items-center gap-2 text-white font-bold px-5 py-3 rounded-xl text-sm hover:opacity-90"
           style="background-color:#0d1b2e;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Voucher
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="mb-5 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 bg-gray-50">
                    <th class="px-6 py-4 text-left">Kode</th>
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">Tipe & Nilai</th>
                    <th class="px-6 py-4 text-left">Min Belanja</th>
                    <th class="px-6 py-4 text-left">Kuota</th>
                    <th class="px-6 py-4 text-left">Berlaku Sampai</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($vouchers as $v)
                <tr class="hover:bg-gray-50 transition-colors">

                    <td class="px-6 py-4">
                        <span class="font-bold text-sm bg-orange-50 text-orange-700 px-3 py-1 rounded-lg font-mono tracking-wider">
                            {{ $v->kode }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $v->nama }}</td>

                    <td class="px-6 py-4">
                        <span class="text-sm font-bold {{ $v->tipe === 'persen' ? 'text-blue-600' : 'text-green-600' }}">
                            {{ $v->nilai_format }}
                        </span>
                        <span class="text-xs text-gray-400 ml-1">{{ $v->tipe === 'persen' ? 'diskon' : 'potongan' }}</span>
                        @if($v->tipe === 'persen' && $v->maks_diskon)
                        <p class="text-xs text-gray-400 mt-0.5">maks Rp {{ number_format($v->maks_diskon, 0, ',', '.') }}</p>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ $v->min_belanja > 0 ? 'Rp ' . number_format($v->min_belanja, 0, ',', '.') : '-' }}
                    </td>

                    <td class="px-6 py-4 text-sm">
                        @if($v->kuota)
                            <span class="{{ $v->terpakai >= $v->kuota ? 'text-red-500 font-bold' : 'text-gray-700' }}">
                                {{ $v->terpakai }}/{{ $v->kuota }}
                            </span>
                        @else
                            <span class="text-gray-400">Unlimited</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $v->tanggal_selesai ? $v->tanggal_selesai->format('d M Y') : '∞ Selamanya' }}
                    </td>

                    <td class="px-6 py-4">
                        @php $valid = $v->isValid(); @endphp
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full
                            {{ $valid ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                            {{ $valid ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            {{-- Edit --}}
                            <a href="{{ route('admin.voucher.edit', $v->id) }}"
                               class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center hover:bg-blue-100 transition-colors"
                               title="Edit">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            {{-- Hapus — buka modal --}}
                            <button
                                @click="showModal=true; deleteId={{ $v->id }}; deleteKode='{{ addslashes($v->kode) }}'; deleteNama='{{ addslashes($v->nama) }}'"
                                class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center hover:bg-red-100 transition-colors"
                                title="Hapus">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center">
                        <p class="text-3xl mb-3">🎟</p>
                        <p class="text-gray-400 font-semibold">Belum ada voucher.</p>
                        <a href="{{ route('admin.voucher.create') }}"
                           class="text-blue-600 text-sm hover:underline mt-1 inline-block">
                            + Buat voucher pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $vouchers->links() }}
        </div>
    </div>

    {{-- ============ MODAL KONFIRMASI HAPUS ============ --}}
    <div
        x-show="showModal"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center"
        style="display:none; background-color:rgba(0,0,0,0.55);">

        <div
            @click.stop
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden">

            {{-- Isi Modal --}}
            <div class="px-8 pt-8 pb-6 text-center">
                {{-- Icon --}}
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>

                <h2 class="text-xl font-bold text-gray-900 mb-3">Hapus Voucher?</h2>

                {{-- Pesan dengan border kiri merah --}}
                <div class="border-l-4 border-red-400 bg-red-50 rounded-r-xl p-4 text-left mb-6">
                    <p class="text-sm text-gray-700">
                        Yakin ingin menghapus voucher
                        <strong class="font-mono text-orange-600" x-text="deleteKode"></strong>
                        (<span x-text="deleteNama"></span>)?
                        <br><span class="text-red-500 text-xs mt-1 block">Tindakan ini tidak dapat dibatalkan.</span>
                    </p>
                </div>

                {{-- Tombol --}}
                <div class="flex gap-3">
                    <button
                        @click="showModal = false"
                        class="flex-1 py-3 rounded-xl border-2 border-gray-200 text-gray-700 font-bold text-sm hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <form :action="'/admin/voucher/' + deleteId" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full py-3 rounded-xl bg-red-500 text-white font-bold text-sm hover:bg-red-600 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>

            {{-- Footer info --}}
            <div class="bg-gray-50 border-t px-6 py-2.5 flex justify-between items-center">
                <span class="text-xs text-gray-400">ID: <span x-text="deleteId"></span></span>
                <span class="text-xs text-red-400 font-semibold">PERMANEN</span>
            </div>

        </div>
    </div>

</div>
@endsection
