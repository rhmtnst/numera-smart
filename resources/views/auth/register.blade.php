
@extends('layouts.guest')

@section('title', 'Daftar Akun - NUMERA SMART')

@section('content')

<div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-gradient-to-br from-[#e4fbff] via-[#eff8ff] to-[#f1eaff] px-5 py-10">

    {{-- BACKGROUND DECORATION --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">

        <div class="absolute -left-24 -top-24 h-80 w-80 rounded-full bg-cyan-200/50 blur-2xl"></div>
        <div class="absolute -right-24 -top-20 h-96 w-96 rounded-full bg-yellow-200/50 blur-2xl"></div>
        <div class="absolute -bottom-32 left-1/4 h-96 w-96 rounded-full bg-emerald-200/40 blur-2xl"></div>
        <div class="absolute -bottom-32 -right-20 h-96 w-96 rounded-full bg-purple-200/50 blur-2xl"></div>

        {{-- FLOATING MATH ICONS --}}
        <div class="absolute left-[7%] top-[13%] rotate-[-12deg] rounded-2xl border-4 border-white bg-white/80 p-4 text-4xl shadow-lg">➕</div>
        <div class="absolute left-[12%] bottom-[16%] rotate-12 rounded-2xl border-4 border-white bg-yellow-100 p-4 text-4xl shadow-lg">🧮</div>
        <div class="absolute right-[9%] top-[13%] rotate-12 rounded-2xl border-4 border-white bg-purple-100 p-4 text-4xl shadow-lg">📐</div>
        <div class="absolute right-[8%] bottom-[15%] rotate-[-10deg] rounded-2xl border-4 border-white bg-emerald-100 p-4 text-4xl shadow-lg">📊</div>

        <div class="absolute left-[28%] top-[8%] text-4xl opacity-70">⭐</div>
        <div class="absolute right-[28%] bottom-[8%] text-4xl opacity-70">✨</div>
        <div class="absolute left-[6%] top-[48%] text-4xl opacity-60">✖️</div>
        <div class="absolute right-[6%] top-[48%] text-4xl opacity-60">➗</div>

        <div class="absolute left-[28%] bottom-[8%] h-20 w-20 rounded-full bg-cyan-300/40"></div>
        <div class="absolute right-[28%] top-[7%] h-24 w-24 rounded-full bg-yellow-300/40"></div>

    </div>

    {{-- MAIN CONTENT --}}
    <div class="relative z-10 w-full max-w-xl">

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

        {{-- REGISTER CARD --}}
        <div class="rounded-[2rem] border-4 border-white bg-white/95 p-7 shadow-[0_25px_70px_rgba(14,116,144,0.16)] backdrop-blur-md sm:p-9">

            <div class="mb-7 text-center">

                <span class="inline-flex items-center gap-2 rounded-full bg-cyan-50 px-4 py-2 text-xs font-bold text-cyan-700">
                    🚀 MULAI PETUALANGANMU
                </span>

                <h2 class="mt-5 text-3xl font-black text-[#075985]">
                    Buat akun siswa!
                </h2>

                <p class="mt-3 text-sm leading-6 text-slate-500">
                    Isi informasi berikut dan bersiaplah menjelajahi dunia numerasi.
                </p>

            </div>

            {{-- ERROR MESSAGE --}}
            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <p class="mb-2 font-bold">⚠️ Ada informasi yang perlu diperiksa.</p>
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- REGISTER FORM --}}
            <form action="{{ route('register.process') }}" method="POST" class="space-y-5">
                @csrf

                {{-- NAME --}}
                <div>
                    <label for="name" class="mb-2 block text-sm font-bold text-slate-700">
                        👤 Nama Lengkap
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autocomplete="name"
                        placeholder="Nama lengkap siswa"
                        class="w-full rounded-2xl border-2 border-slate-100 bg-slate-50 px-5 py-3.5 text-sm text-slate-700 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100"
                    >
                </div>

                {{-- EMAIL --}}
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
                        autocomplete="email"
                        placeholder="nama@email.com"
                        class="w-full rounded-2xl border-2 border-slate-100 bg-slate-50 px-5 py-3.5 text-sm text-slate-700 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100"
                    >
                </div>

                {{-- GRADE --}}
                <div>
                    <label for="grade_level" class="mb-2 block text-sm font-bold text-slate-700">
                        🎒 Kelas
                    </label>

                    <select
                        id="grade_level"
                        name="grade_level"
                        required
                        class="w-full rounded-2xl border-2 border-slate-100 bg-slate-50 px-5 py-3.5 text-sm text-slate-700 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100"
                    >
                        <option value="">Pilih kelas</option>

                        @foreach ([4, 5, 6] as $grade)
                            <option value="{{ $grade }}" @selected(old('grade_level') == $grade)>
                                Kelas {{ $grade }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- SCHOOL CODE --}}
                <div>
                    <label for="school_code" class="mb-2 block text-sm font-bold text-slate-700">
                        🏫 Kode Pendaftaran Sekolah
                    </label>

                    <input
                        id="school_code"
                        type="text"
                        name="school_code"
                        value="{{ old('school_code') }}"
                        required
                        maxlength="32"
                        placeholder="Masukkan kode dari sekolah"
                        class="w-full rounded-2xl border-2 border-slate-100 bg-slate-50 px-5 py-3.5 text-sm text-slate-700 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100"
                    >
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label for="password" class="mb-2 block text-sm font-bold text-slate-700">
                        🔐 Password
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                        class="w-full rounded-2xl border-2 border-slate-100 bg-slate-50 px-5 py-3.5 text-sm text-slate-700 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100"
                    >
                </div>

                {{-- CONFIRM PASSWORD --}}
                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-bold text-slate-700">
                        🔒 Konfirmasi Password
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Ulangi password"
                        class="w-full rounded-2xl border-2 border-slate-100 bg-slate-50 px-5 py-3.5 text-sm text-slate-700 outline-none transition focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100"
                    >
                </div>

                {{-- SUBMIT --}}
                <button
                    type="submit"
                    class="group flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-500 py-4 font-extrabold text-white shadow-lg shadow-cyan-200 transition duration-300 hover:-translate-y-1 hover:from-cyan-600 hover:to-blue-600 hover:shadow-xl active:translate-y-0"
                >
                    Buat Akun NUMERA SMART
                    <span class="transition group-hover:translate-x-1">→</span>
                </button>

            </form>

            {{-- LOGIN LINK --}}
            <div class="mt-7 border-t border-slate-100 pt-6 text-center">
                <p class="text-sm text-slate-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-extrabold text-cyan-600 hover:text-blue-600 hover:underline">
                        Masuk di sini
                    </a>
                </p>
            </div>

        </div>

        {{-- FOOTER --}}
        <div class="mt-6 text-center">
            <p class="inline-flex items-center gap-2 rounded-full border border-white bg-white/70 px-5 py-2 text-xs font-medium text-slate-500 shadow-sm">
                🌱 Belajar, mencoba, dan tumbuh bersama!
            </p>

            <p class="mt-4 text-xs text-slate-400">
                © {{ date('Y') }} NUMERA SMART · Explore · Learn · Grow
            </p>
        </div>

    </div>

</div>

@endsection
