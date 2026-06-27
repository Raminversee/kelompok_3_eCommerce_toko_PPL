@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto py-8">

    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="bg-blue-700 text-white px-6 py-4">
            <h1 class="text-xl font-bold">
                Customer Service Chat
            </h1>
            <p class="text-sm opacity-80">
                Hubungi Admin Pembelian untuk bantuan produk dan pesanan
            </p>
        </div>

        <div class="h-[500px] overflow-y-auto p-6 bg-gray-50">

            @forelse($messages as $chat)

                @if($chat->sender_id == auth()->id())

                    <div class="flex justify-end mb-4">

                        <div class="max-w-md">

                            <div class="bg-blue-600 text-white px-4 py-3 rounded-2xl rounded-br-md shadow">
                                {{ $chat->message }}
                            </div>

                            <p class="text-xs text-gray-500 mt-1 text-right">
                                Anda • {{ $chat->created_at->format('d M Y H:i') }}
                            </p>

                        </div>

                    </div>

                @else

                    <div class="flex justify-start mb-4">

                        <div class="max-w-md">

                            <div class="bg-white border px-4 py-3 rounded-2xl rounded-bl-md shadow-sm">

                                <p class="font-semibold text-sm text-blue-700 mb-1">
                                    {{ $chat->sender->name }}
                                </p>

                                <p>
                                    {{ $chat->message }}
                                </p>

                            </div>

                            <p class="text-xs text-gray-500 mt-1">
                                {{ $chat->created_at->format('d M Y H:i') }}
                            </p>

                        </div>

                    </div>

                @endif

            @empty

                <div class="text-center py-20 text-gray-400">
                    Belum ada percakapan.
                </div>

            @endforelse

        </div>

        <div class="border-t bg-white p-6">

            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('chat.store') }}">
                @csrf

                <div class="mb-4">

                    <label class="block text-sm font-semibold mb-2">
                        Tujuan
                    </label>

                    <select
                        name="receiver_id"
                        class="w-full border rounded-xl px-4 py-3">

                        @foreach($admins as $admin)

                            <option value="{{ $admin->id }}">
                                {{ $admin->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-4">

                    <textarea
                        name="message"
                        rows="4"
                        required
                        placeholder="Tulis pesan..."
                        class="w-full border rounded-xl px-4 py-3"></textarea>

                </div>

                <button
                    type="submit"
                    class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-3 rounded-xl font-medium">

                    Kirim Pesan

                </button>

            </form>

        </div>

    </div>

</div>

@endsection