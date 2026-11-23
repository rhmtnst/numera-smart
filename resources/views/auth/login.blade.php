
@extends('layouts.guest')

@section('title', 'Masuk - NUMERA SMART')

@section('content')

<div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-gradient-to-br from-[#e4fbff] via-[#eff8ff] to-[#f1eaff] px-5 py-12">

    {{-- BACKGROUND DECORATION --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">

        <div class="absolute -left-24 -top-24 h-80 w-80 rounded-full bg-cyan-200/50 blur-2xl"></div>
        <div class="absolute -right-24 -top-20 h-96 w-96 rounded-full bg-yellow-200/50 blur-2xl"></div>
        <div class="absolute -bottom-32 left-1/4 h-96 w-96 rounded-full bg-emerald-200/40 blur-2xl"></div>
        <div class="absolute -bottom-32 -right-20 h-96 w-96 rounded-full bg-purple-200/50 blur-2xl"></div>

        {{-- FLOATING MATH SYMBOLS --}}
        <div class="absolute left-[8%] top-[15%] rotate-[-12deg] rounded-2xl border-4 border-white bg-white/80 p-4 text-4xl shadow-lg">➕</div>
        <div class="absolute left-[18%] bottom-[20%] rotate-12 rounded-2xl border-4 border-white bg-yellow-100 p-4 text-4xl shadow-lg">🧮</div>
        <div class="absolute right-[12%] top-[16%] rotate-12 rounded-2xl border-4 border-white bg-purple-100 p-4 text-4xl shadow-lg">📐</div>
        <div class="absolute right-[9%] bottom-[18%] rotate-[-10deg] rounded-2xl border-4 border-white bg-emerald-100 p-4 text-4xl shadow-lg">📊</div>
        <div class="absolute left-[30%] top-[8%] text-4xl opacity-70">⭐</div>
        <div class="absolute right-[30%] bottom-[9%] text-4xl opacity-70">✨</div>
        <div class="absolute left-[7%] bottom-[48%] text-4xl opacity-60">✖️</div>
        <div class="absolute right-[7%] top-[48%] text-4xl opacity-60">➗</div>

        {{-- DECORATIVE CIRCLES --}}
        <div class="absolute left-[28%] bottom-[8%] h-20 w-20 rounded-full bg-cyan-300/40"></div>
        <div class="absolute right-[28%] top-[7%] h-24 w-24 rounded-full bg-yellow-300/40"></div>

    </div>

    {{-- MAIN CONTENT --}}
    <div class="relative z-10 w-full max-w-md">

        {{-- BRAND --}}
        <div class="mb-6 flex flex-col items-center text-center">

            <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-gradient-to-br from-cyan-400 to-blue-500 text-3xl font-black text-white shadow-xl shadow-cyan-200">
                N
            </div>

            <h1 class="mt-3 text-2xl font-black tracking-tight text-[#075985]">
                NUMERA<span class="text-orange-400">SMART</span>
            </h1>

            <p class="mt-1 text-xs font-medium text-slate-500">
                Petualangan Seru Belajar Numerasi
            </p>

        </div>

        {{-- LOGIN CARD --}}
        <div class="rounded-[2rem] border-4 border-white bg-white/95 p-7 shadow-[0_25px_70px_rgba(14,116,144,0.16)] backdrop-blur-md sm:p-9">

            <div class="mb-7 text-center">

                <span class="inline-flex items-center gap-2 rounded-full bg-cyan-50 px-4 py-2 text-xs font-bold text-cyan-700">
                    ✨ SELAMAT DATANG KEMBALI
                </span>

                <h2 class="mt-5 text-3xl font-black text-[#075985]">
                    Yuk, lanjut belajar!
                </h2>

                <p class="mt-3 text-sm leading-6 text-slate-500">
                    Siap melanjutkan petualangan numerasimu hari ini?
                </p>

            </div>

            {{-- ERROR MESSAGE --}}
            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <p class="font-bold">⚠️ Ada yang perlu diperiksa.</p>
                    <p class="mt-1">{{ $errors->first() }}</p>
                </div>
            @endif

            {{-- LOGIN FORM --}}
            <form action="{{ route('login.process') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-sm font-bold text-slate-700">
                        📧 Alamat Email
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="nama@email.com"
                        class="w-full rounded-2xl border-2 border-slate-100 bg-slate-50 px-5 py-4 text-sm text-slate-700 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100"
                    >
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-bold text-slate-700">
                        🔐 Password
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Masukkan password"
                        class="w-full rounded-2xl border-2 border-slate-100 bg-slate-50 px-5 py-4 text-sm text-slate-700 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100"
                    >
                </div>

                <label class="flex cursor-pointer items-center gap-3 text-sm text-slate-500">
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        class="h-4 w-4 rounded border-slate-300 text-cyan-500 focus:ring-cyan-400"
                    >
                    Ingat saya
                </label>

                <button
                    type="submit"
                    class="group flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-500 py-4 font-extrabold text-white shadow-lg shadow-cyan-200 transition duration-300 hover:-translate-y-1 hover:from-cyan-600 hover:to-blue-600 hover:shadow-xl active:translate-y-0"
                >
                    Masuk ke NUMERA SMART
                    <span class="transition group-hover:translate-x-1">→</span>
                </button>

            </form>

            {{-- REGISTER --}}
            <div class="mt-7 border-t border-slate-100 pt-6 text-center">
                <p class="text-sm text-slate-500">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-extrabold text-cyan-600 hover:text-blue-600 hover:underline">
                        Daftar sekarang
                    </a>
                </p>
            </div>

        </div>

        {{-- FOOTER --}}
        <div class="mt-6 text-center">
            <p class="inline-flex items-center gap-2 rounded-full border border-white bg-white/70 px-5 py-2 text-xs font-medium text-slate-500 shadow-sm">
                🌱 Kesalahan adalah awal dari pemahaman.
            </p>

            <p class="mt-4 text-xs text-slate-400">
                © {{ date('Y') }} NUMERA SMART · Explore · Learn · Grow
            </p>
        </div>

    </div>

</div>

@endsection
