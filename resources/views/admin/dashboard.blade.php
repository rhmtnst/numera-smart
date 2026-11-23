
@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-8">

    {{-- HERO / WELCOME --}}
    <section class="relative isolate overflow-hidden rounded-[30px] bg-gradient-to-br from-[#087f68] via-[#0da991] to-[#16b9c9] p-7 text-white shadow-xl shadow-emerald-900/10 sm:p-10">
        <div class="pointer-events-none absolute -right-16 -top-24 h-80 w-80 rounded-full border-[38px] border-white/[0.08]"></div>
        <div class="pointer-events-none absolute -bottom-36 right-1/4 h-72 w-72 rounded-full bg-cyan-200/10"></div>
        <div class="pointer-events-none absolute right-10 top-10 h-32 w-32 rounded-full bg-white/[0.06] blur-2xl"></div>

        <div class="relative z-10 flex flex-col justify-between gap-8 lg:flex-row lg:items-center">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3.5 py-2 text-[10px] font-black uppercase tracking-[.18em] text-white/95 backdrop-blur-sm">
                    <span class="h-2 w-2 rounded-full bg-lime-300 shadow-[0_0_10px_rgba(190,242,100,.8)]"></span>
                    System Administrator
                </div>

                <h1 class="mt-6 text-3xl font-black leading-tight tracking-tight sm:text-4xl lg:text-[42px]">
                    Selamat datang,<br class="hidden sm:block">
                    {{ auth()->user()->name }}!
                    <span class="inline-block">👋</span>
                </h1>

                <p class="mt-4 max-w-xl text-sm leading-7 text-white/85 sm:text-[15px]">
                    Pusat kendali NUMERA SMART. Kelola institusi, tenaga pengajar, peserta didik, serta pastikan seluruh ekosistem pembelajaran berjalan dengan baik.
                </p>

                <div class="mt-7 flex flex-wrap items-center gap-3">
                    <a href="{{ route('admin.schools.index') }}"
                       class="inline-flex items-center gap-3 rounded-2xl bg-white px-5 py-3.5 text-sm font-extrabold text-emerald-800 shadow-lg shadow-emerald-950/10 transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <span>Jelajahi Sekolah</span>
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </a>

                    <div class="inline-flex items-center gap-2 rounded-2xl border border-white/20 bg-white/10 px-4 py-3.5 text-xs font-bold text-white/90 backdrop-blur-sm">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 8v4l3 2"/>
                            <circle cx="12" cy="12" r="9"/>
                        </svg>
                        Pusat Administrasi
                    </div>
                </div>
            </div>

            {{-- DECORATIVE ILLUSTRATION --}}
            <div class="relative hidden h-56 w-56 shrink-0 items-center justify-center lg:flex">
                <div class="absolute h-52 w-52 rounded-full border border-white/20"></div>
                <div class="absolute h-40 w-40 rounded-full border border-white/15"></div>
                <div class="absolute h-32 w-32 rounded-full bg-white/10 blur-xl"></div>

                <div class="relative grid h-32 w-32 place-items-center rounded-[34px] border border-white/25 bg-white/15 shadow-2xl backdrop-blur-md">
                    <svg class="h-20 w-20 text-white" viewBox="0 0 100 100" fill="none">
                        <path d="M50 12L84 25V49C84 69 70 84 50 92C30 84 16 69 16 49V25L50 12Z" fill="white" fill-opacity=".16" stroke="currentColor" stroke-width="3"/>
                        <path d="M34 49L45 60L67 37" stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M50 4V12M91 50H84M16 50H9" stroke="currentColor" stroke-width="3" stroke-linecap="round" opacity=".7"/>
                    </svg>
                </div>

                <div class="absolute right-0 top-5 grid h-12 w-12 place-items-center rounded-2xl border border-white/20 bg-white/20 text-xl shadow-lg backdrop-blur-sm">⚙️</div>
                <div class="absolute bottom-3 left-2 grid h-12 w-12 place-items-center rounded-2xl border border-white/20 bg-white/20 text-xl shadow-lg backdrop-blur-sm">📊</div>
                <div class="absolute bottom-5 right-1 grid h-9 w-9 place-items-center rounded-xl bg-lime-300 text-lg shadow-lg">✓</div>
            </div>
        </div>
    </section>


    {{-- SYSTEM STATISTICS --}}
    <section>
        <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    <p class="text-[10px] font-black uppercase tracking-[.2em] text-emerald-700">Ringkasan Sistem</p>
                </div>
                <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-800">NUMERA SMART dalam angka</h2>
                <p class="mt-1 text-sm text-slate-500">Gambaran umum ekosistem pembelajaran yang dikelola.</p>
            </div>

            <div class="inline-flex w-fit items-center gap-2 rounded-full border border-emerald-100 bg-emerald-50 px-3 py-2 text-[10px] font-bold text-emerald-700">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                Ringkasan data sistem
            </div>
        </div>

        @php
            $stats = [
                ['Sekolah', $totalSchools, '🏫', 'from-sky-50 to-white', 'text-sky-600', 'border-sky-100'],
                ['Guru', $totalTeachers, '🧑‍🏫', 'from-emerald-50 to-white', 'text-emerald-600', 'border-emerald-100'],
                ['Siswa', $totalStudents, '🎓', 'from-violet-50 to-white', 'text-violet-600', 'border-violet-100'],
                ['Topik', $totalTopics, '📚', 'from-amber-50 to-white', 'text-amber-600', 'border-amber-100'],
                ['Asesmen selesai', $totalAssessments, '🏆', 'from-rose-50 to-white', 'text-rose-600', 'border-rose-100'],
            ];
        @endphp

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            @foreach($stats as [$label, $value, $icon, $tone, $color, $border])
                <article class="group relative overflow-hidden rounded-[24px] border {{ $border }} bg-gradient-to-br {{ $tone }} p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-bold text-slate-500">{{ $label }}</p>
                        <div class="grid h-12 w-12 place-items-center rounded-2xl bg-white text-2xl shadow-sm transition duration-300 group-hover:scale-110 group-hover:rotate-3">
                            {{ $icon }}
                        </div>
                    </div>

                    <div class="mt-5 flex items-end justify-between gap-2">
                        <p class="text-3xl font-black tracking-tight {{ $color }}">
                            {{ number_format($value) }}
                        </p>
                        <svg class="mb-1 h-5 w-5 text-slate-300 transition group-hover:text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M7 17L17 7M7 7h10v10"/>
                        </svg>
                    </div>

                    <p class="mt-2 text-[10px] font-medium text-slate-400">Data terhubung langsung ke sistem</p>

                    <div class="absolute -bottom-8 -right-8 h-20 w-20 rounded-full bg-white/50 blur-xl"></div>
                </article>
            @endforeach
        </div>
    </section>


    {{-- MANAGEMENT MODULES --}}
    <section>
        <div class="mb-5">
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-cyan-500"></span>
                <p class="text-[10px] font-black uppercase tracking-[.2em] text-cyan-700">Ruang Pengelolaan</p>
            </div>
            <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-800">Pusat administrasi</h2>
            <p class="mt-1 text-sm text-slate-500">Pilih modul untuk mengelola bagian dari ekosistem NUMERA SMART.</p>
        </div>

        @php
            $menus = [
                [
                    'Data Sekolah',
                    'Kelola institusi yang menggunakan platform NUMERA SMART.',
                    '🏫',
                    'admin.schools.index',
                    'bg-sky-100 text-sky-700',
                    'from-sky-500 to-cyan-500',
                ],
                [
                    'Data Guru',
                    'Kelola akun, identitas, dan informasi tenaga pengajar.',
                    '🧑‍🏫',
                    'admin.teachers.index',
                    'bg-emerald-100 text-emerald-700',
                    'from-emerald-500 to-teal-500',
                ],
                [
                    'Penugasan Guru',
                    'Atur sekolah dan kelas yang menjadi tanggung jawab guru.',
                    '🧭',
                    'admin.assignments.index',
                    'bg-violet-100 text-violet-700',
                    'from-violet-500 to-purple-500',
                ],
                [
                    'Kode Sekolah',
                    'Buat dan kelola kode pendaftaran untuk setiap sekolah.',
                    '🔐',
                    'admin.codes.index',
                    'bg-amber-100 text-amber-700',
                    'from-amber-500 to-orange-500',
                ],
                [
                    'Data Siswa',
                    'Pantau akun, informasi sekolah, dan status peserta didik.',
                    '🎓',
                    'admin.students.index',
                    'bg-rose-100 text-rose-700',
                    'from-rose-500 to-pink-500',
                ],
            ];
        @endphp

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach($menus as [$title, $desc, $icon, $routeName, $tone, $gradient])
                <a href="{{ route($routeName) }}"
                   class="group relative overflow-hidden rounded-[26px] border border-slate-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-emerald-100 hover:shadow-xl hover:shadow-emerald-900/[0.06]">

                    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-slate-50 transition duration-500 group-hover:scale-150 group-hover:bg-emerald-50/70"></div>

                    <div class="relative flex items-start justify-between">
                        <div class="grid h-14 w-14 place-items-center rounded-[19px] {{ $tone }} text-3xl shadow-sm transition duration-300 group-hover:scale-110 group-hover:rotate-3">
                            {{ $icon }}
                        </div>

                        <span class="grid h-9 w-9 place-items-center rounded-xl bg-slate-50 text-slate-400 transition duration-300 group-hover:bg-emerald-500 group-hover:text-white">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3">
                                <path d="M7 17L17 7M7 7h10v10"/>
                            </svg>
                        </span>
                    </div>

                    <div class="relative mt-6">
                        <h3 class="text-lg font-black tracking-tight text-slate-800 transition group-hover:text-emerald-700">
                            {{ $title }}
                        </h3>
                        <p class="mt-2 min-h-[48px] text-sm leading-6 text-slate-500">
                            {{ $desc }}
                        </p>
                    </div>

                    <div class="relative mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
                        <span class="inline-flex items-center gap-2 text-xs font-extrabold text-emerald-700">
                            Buka pengelolaan
                            <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M5 12h14M13 6l6 6-6 6"/>
                            </svg>
                        </span>
                        <span class="h-1.5 w-10 rounded-full bg-gradient-to-r {{ $gradient }} opacity-60 transition-all duration-300 group-hover:w-16 group-hover:opacity-100"></span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>


    {{-- NUMERA INFORMATION --}}
    <section class="relative isolate overflow-hidden rounded-[26px] border border-emerald-100 bg-gradient-to-r from-lime-50 via-emerald-50 to-cyan-50 p-6 sm:p-8">
        <div class="pointer-events-none absolute -right-10 -top-16 h-48 w-48 rounded-full bg-emerald-200/20 blur-2xl"></div>

        <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center">
            <div class="grid h-16 w-16 shrink-0 place-items-center rounded-[22px] border border-white bg-white text-3xl shadow-sm">
                🌱
            </div>

            <div class="flex-1">
                <div class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-[.18em] text-emerald-700">
                    Tentang NUMERA SMART
                </div>
                <h3 class="mt-2 text-lg font-black tracking-tight text-slate-800 sm:text-xl">
                    Dari Kesalahan Menuju Pemahaman
                </h3>
                <p class="mt-2 max-w-3xl text-sm leading-7 text-slate-600">
                    NUMERA SMART mendukung proses pembelajaran numerasi melalui materi, asesmen, analisis kesulitan, verifikasi pemahaman, dan remediasi. Bersama-sama, kita membangun pengalaman belajar yang lebih terarah dan bermakna.
                </p>
            </div>

            <div class="hidden shrink-0 text-5xl opacity-40 sm:block">✦</div>
        </div>
    </section>

</div>
@endsection
