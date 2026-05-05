@extends('layouts.auth')
@section('title', 'Masuk — Plazza Bangunan Sukses')

@section('content')
<div class="w-full max-w-md space-y-6">

    <!-- ================= LOGIN CARD ================= -->
    <div class="bg-white rounded-3xl shadow-xl p-8">

        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 mb-1">
                <span class="text-2xl font-bold text-navy-700">Plazza</span>
            </div>
            <p class="text-xs font-semibold text-gray-400 tracking-widest">BANGUNAN SUKSES</p>
        </div>

        <!-- Heading -->
        <div class="text-center mb-7">
            <h1 class="text-2xl font-bold text-gray-900 mb-1">Masuk ke Akun Anda</h1>
            <p class="text-sm text-gray-500">Akses dashboard dan kelola pesanan Anda</p>
        </div>

        <!-- Alert -->
        @if ($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-5 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       class="w-full border rounded-xl px-4 py-2"
                       required>
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <label class="font-semibold">Kata Sandi</label>
                    <a href="#lupa-password" class="text-blue-500">Lupa Sandi?</a>
                </div>

                <input type="password" name="password"
                       class="w-full border rounded-xl px-4 py-2"
                       required>
            </div>

            <!-- Remember -->
            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember">
                <span class="text-sm text-gray-600">Ingat saya</span>
            </div>

            <!-- Submit -->
            <button class="w-full bg-[#0d1b2e] text-white py-2 rounded-xl">
                Masuk
            </button>
        </form>

        <!-- INFO -->
        <p class="text-center text-sm text-gray-500 mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-bold text-blue-600">
                Daftar sekarang
            </a>
        </p>

    </div>


    <!-- ================= LUPA PASSWORD CARD ================= -->
    <div id="lupa-password" class="bg-white rounded-3xl shadow-lg overflow-hidden">

        <!-- HEADER -->
        <div class="bg-[#1e3a5f] text-white text-center py-6">
            <h2 class="text-lg font-bold">Lupa Password?</h2>
            <p class="text-sm opacity-80">Tenang, admin siap bantu reset akun Anda</p>
        </div>

        <!-- CONTENT -->
        <div class="p-6">

            <div class="bg-gray-50 border rounded-xl p-4 text-sm text-gray-700 space-y-3">

                <p class="font-semibold">Cara Reset Password:</p>

                <ol class="space-y-2 list-decimal list-inside">
                    <li>Hubungi admin melalui WhatsApp</li>
                    <li>Kirim email akun Anda</li>
                    <li>Admin akan reset password</li>
                    <li>Login kembali dengan password baru</li>
                </ol>

            </div>

            <!-- BUTTON -->
            <div class="mt-5 space-y-3">

                <a href="https://wa.me/6287877438920"
                   class="block w-full text-center bg-green-500 text-white py-2 rounded-xl">
                    WhatsApp Admin
                </a>

                <div class="text-center border py-2 rounded-xl text-gray-700">
                    admin@plazzabangunan.com
                </div>

            </div>

        </div>

    </div>

</div>
@endsection