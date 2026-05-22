@extends('admin.layouts.admin')

@section('content')
<div class="p-8">
    <h1 class="text-2xl font-bold mb-6">Manajemen Stok</h1>

    <div class="bg-white rounded-xl shadow p-6">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Nama Produk</th>
                    <th class="text-left py-2">Stok</th>
                    <th class="text-left py-2">Min Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produks as $p)
                <tr class="border-b">
                    <td class="py-2">{{ $p->nama }}</td>
                    <td class="py-2">{{ $p->stok }}</td>
                    <td class="py-2">{{ $p->min_stok ?? 10 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection