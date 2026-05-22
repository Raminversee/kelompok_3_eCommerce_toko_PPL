@extends('admin.layouts.admin')
@section('title', 'Kelola Pesanan')

@section('content')
<div class="p-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Pesanan</h1>
            <p class="text-gray-500 mt-1">Pantau dan kelola semua pesanan pelanggan Plazza Bangunan</p>
        </div>
        <div class="flex items-center gap-3">
            <form method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari ID Pesanan..."
                       class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 w-56">
            </form>
        </div>
    </div>

    {{-- Tab Filter --}}
    <div class="flex gap-2 mb-6">
        @foreach(['semua'=>'Semua','menunggu_verifikasi'=>'Menunggu','diproses'=>'Diproses','dikirim'=>'Dikirim','selesai'=>'Selesai'] as $key=>$label)
        <a href="{{ route('admin.pesanan.index', array_merge(request()->query(), ['status'=>$key])) }}"
           class="px-4 py-2 rounded-xl text-sm font-semibold transition-colors
                  {{ (request('status', 'semua') === $key) ? 'bg-navy-700 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}"
           style="{{ (request('status', 'semua') === $key) ? 'background-color:#0d1b2e;' : '' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- Tabel Pesanan --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-6">
        <table class="w-full">
            <thead>
                <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 bg-gray-50">
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Order ID</th>
                    <th class="px-6 py-4 text-left">Pelanggan</th>
                    <th class="px-6 py-4 text-left">Total</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">Tanggal</th>
                    <th class="px-6 py-4 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pesanans as $i => $p)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-400">{{ $pesanans->firstItem() + $i }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-navy-700">{{ $p->kode_pesanan }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500">
                                {{ strtoupper(substr($p->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <span class="text-sm text-gray-700">{{ $p->user->name ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $p->total_format }}</td>
                    <td class="px-6 py-4">
                        @php $c = ['selesai'=>'green','dikirim'=>'purple','diproses'=>'indigo','menunggu_verifikasi'=>'blue','menunggu_pembayaran'=>'yellow','dibatalkan'=>'red'][$p->status]??'gray'; @endphp
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-{{ $c }}-100 text-{{ $c }}-700">
                            {{ $p->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-400">{{ $p->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.pesanan.show', $p->id) }}"
                           class="text-sm font-semibold text-blue-600 hover:text-blue-700">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">Tidak ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($pesanans->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
            <span>Menampilkan {{ $pesanans->firstItem() }}-{{ $pesanans->lastItem() }} dari {{ $pesanans->total() }} pesanan</span>
            {{ $pesanans->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

    {{-- Summary Stats --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-blue-200 p-5">
            <p class="text-xs font-bold text-blue-500 uppercase tracking-wider mb-1">Total Penjualan</p>
            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_penjualan'] / 1000000, 1) }}M</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Pesanan Baru</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['pesanan_baru'] }} <span class="text-sm font-normal text-gray-400">Hari ini</span></p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-5">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Siap Kirim</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['siap_kirim'] }}</p>
        </div>
    </div>

</div>
@endsection