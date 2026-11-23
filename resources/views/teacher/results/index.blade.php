
@extends('layouts.teacher')

@section('title', 'Hasil Asesmen Siswa')

@section('content')

<style>
    .result-float {
        animation: result-float 4s ease-in-out infinite;
    }

    .result-float-delay {
        animation: result-float 4.8s ease-in-out infinite;
        animation-delay: .7s;
    }

    .result-pulse {
        transform-box: fill-box;
        transform-origin: center;
        animation: result-pulse 2.5s ease-in-out infinite;
    }

    .result-card {
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .result-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 38px rgba(8,126,197,.12);
    }

    @keyframes result-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-11px); }
    }

    @keyframes result-pulse {
        0%, 100% { opacity: .5; transform: scale(.9); }
        50% { opacity: 1; transform: scale(1.12); }
    }

    @media (prefers-reduced-motion: reduce) {
        .result-float,
        .result-float-delay,
        .result-pulse {
            animation: none !important;
        }
    }
</style>

<div class="relative space-y-8 overflow-hidden">

    {{-- Decorative background --}}
    <div class="pointer-events-none absolute -right-24 -top-24 h-80 w-80 rounded-full bg-cyan-300/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-24 top-[35rem] h-72 w-72 rounded-full bg-blue-300/20 blur-3xl"></div>


    {{-- HERO --}}
    <section class="relative overflow-hidden rounded-[30px] border border-white/70 bg-gradient-to-br from-[#087cf0] via-[#12b5ed] to-[#36d99a] p-7 text-white shadow-[0_20px_50px_rgba(13,126,222,0.18)] md:p-9">

        <div class="absolute -right-16 -top-24 h-72 w-72 rounded-full bg-white/15"></div>
        <div class="absolute -bottom-32 right-1/4 h-64 w-64 rounded-full bg-[#075de0]/20"></div>

        <div class="relative z-10 grid items-center gap-8 lg:grid-cols-[1fr_280px]">

            <div>
                <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/15 px-4 py-2 text-xs font-semibold backdrop-blur-md">
                    <span class="h-2 w-2 rounded-full bg-[#a7ffda]"></span>
                    NUMERA SMART · RUANG GURU
                </div>

                <h1 class="text-3xl font-extrabold tracking-tight md:text-4xl">
                    Hasil Asesmen Siswa
                </h1>

                <p class="mt-4 max-w-xl text-sm leading-7 text-white/85 md:text-base">
                    Pantau riwayat pengerjaan, jawaban, dan langkah penyelesaian asesmen numerasi siswa. Gunakan hasil ini untuk memahami perkembangan belajar mereka.
                </p>

                <div class="mt-7 flex flex-wrap items-center gap-3">

                    <div class="inline-flex items-center gap-3 rounded-full border border-white/35 bg-white/15 px-5 py-3 backdrop-blur-md">
                        <span class="text-xl">📊</span>
                        <span class="text-sm font-semibold">
                            {{ $attempts->total() }} asesmen tercatat
                        </span>
                    </div>

                </div>
            </div>


            {{-- Animated analytics illustration --}}
            <div class="relative mx-auto hidden h-56 w-full max-w-[270px] lg:block">

                <div class="absolute inset-5 rounded-full bg-white/10 blur-sm"></div>

                <svg viewBox="0 0 270 220"
                     class="relative z-10 h-full w-full"
                     xmlns="http://www.w3.org/2000/svg"
                     role="img"
                     aria-label="Ilustrasi animasi grafik hasil asesmen">

                    {{-- Decorative sparkles --}}
                    <g class="result-pulse" fill="#FFF4A8">
                        <path d="M38 43 L43 55 L55 60 L43 65 L38 77 L33 65 L21 60 L33 55 Z"/>
                    </g>

                    <g class="result-pulse" fill="#FFFFFF" style="animation-delay:.8s">
                        <path d="M225 35 L229 45 L239 49 L229 53 L225 63 L221 53 L211 49 L221 45 Z"/>
                    </g>

                    {{-- Report card --}}
                    <g class="result-float" transform="translate(39 36) rotate(-5 80 80)">
                        <rect x="5" y="5" width="150" height="155" rx="14" fill="#075CB8"/>
                        <rect x="0" y="0" width="150" height="155" rx="14" fill="#FFFFFF"/>

                        <rect x="16" y="16" width="67" height="9" rx="4" fill="#087CF0"/>
                        <rect x="16" y="34" width="43" height="5" rx="2" fill="#B7DDF0"/>

                        {{-- Chart grid --}}
                        <path d="M20 126 H132 M20 101 H132 M20 76 H132" stroke="#E3EFF7" stroke-width="2"/>

                        {{-- Bars --}}
                        <rect x="30" y="96" width="15" height="30" rx="4" fill="#12B5ED"/>
                        <rect x="54" y="81" width="15" height="45" rx="4" fill="#36D99A"/>
                        <rect x="78" y="64" width="15" height="62" rx="4" fill="#087CF0"/>
                        <rect x="102" y="48" width="15" height="78" rx="4" fill="#36D99A"/>
                    </g>

                    {{-- Floating success badge --}}
                    <g class="result-float-delay" transform="translate(155 118)">
                        <circle cx="35" cy="35" r="31" fill="#36D99A" stroke="#FFFFFF" stroke-width="5"/>
                        <path d="M19 35 L30 46 L52 23" fill="none" stroke="#FFFFFF" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>

                    {{-- Small chart decoration --}}
                    <circle cx="222" cy="174" r="6" fill="#B9FFF0" class="result-pulse"/>
                    <circle cx="36" cy="150" r="5" fill="#FFE28A" class="result-pulse"/>

                </svg>
            </div>

        </div>
    </section>


    {{-- SUMMARY --}}
    <section class="relative">

        <div class="mb-5">
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#168bd1]">
                Ringkasan Aktivitas
            </p>

            <h2 class="mt-1 text-xl font-extrabold tracking-tight text-slate-800">
                Statistik Asesmen
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Informasi ringkas riwayat pengerjaan siswa.
            </p>
        </div>


        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

            {{-- Total attempts --}}
            <div class="result-card relative overflow-hidden rounded-[25px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl">

                <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-blue-100/70"></div>

                <div class="relative flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-500">
                        Total Asesmen Selesai
                    </span>

                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 text-xl text-white shadow-lg shadow-blue-100">
                        ▤
                    </span>
                </div>

                <div class="relative mt-5 text-4xl font-extrabold text-[#087bc9]">
                    {{ $attempts->total() }}
                </div>

                <p class="relative mt-2 text-xs text-slate-400">
                    Asesmen yang telah diselesaikan siswa
                </p>

                <div class="relative mt-5 h-1.5 rounded-full bg-blue-50">
                    <div class="h-full w-full rounded-full bg-gradient-to-r from-blue-500 to-cyan-400"></div>
                </div>
            </div>


            {{-- Current page --}}
            <div class="result-card relative overflow-hidden rounded-[25px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl">

                <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-emerald-100/70"></div>

                <div class="relative flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-500">
                        Halaman Saat Ini
                    </span>

                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-400 text-xl text-white shadow-lg shadow-emerald-100">
                        ▦
                    </span>
                </div>

                <div class="relative mt-5 text-4xl font-extrabold text-emerald-500">
                    {{ $attempts->currentPage() }}
                </div>

                <p class="relative mt-2 text-xs text-slate-400">
                    Dari {{ $attempts->lastPage() }} halaman
                </p>

                <div class="relative mt-5 h-1.5 rounded-full bg-emerald-50">
                    <div class="h-full w-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-400"></div>
                </div>
            </div>

        </div>
    </section>


    {{-- ASSESSMENT HISTORY --}}
    <section class="relative overflow-hidden rounded-[28px] border border-white bg-white/95 shadow-[0_15px_40px_rgba(38,105,160,0.08)] backdrop-blur-xl">

        {{-- Section heading --}}
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 bg-gradient-to-r from-blue-50/90 via-cyan-50/70 to-emerald-50/70 p-6 md:p-7">

            <div class="flex items-center gap-4">

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 text-xl text-white shadow-lg shadow-blue-100">
                    📋
                </div>

                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168bd1]">
                        Riwayat Pembelajaran
                    </p>

                    <h2 class="mt-1 text-xl font-extrabold text-slate-800">
                        Riwayat Pengerjaan Siswa
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Pilih asesmen untuk melihat detail pengerjaannya.
                    </p>
                </div>

            </div>

            <span class="rounded-full border border-white bg-white/90 px-4 py-2 text-xs font-bold text-slate-500 shadow-sm">
                {{ $attempts->total() }} data asesmen
            </span>

        </div>


        {{-- Attempts list --}}
        <div class="divide-y divide-slate-100">

            @forelse ($attempts as $attempt)

                <article class="group p-6 transition duration-200 hover:bg-blue-50/40 md:p-7">

                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                        {{-- Student identity --}}
                        <div class="flex min-w-0 items-start gap-4">

                            <div class="result-float flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-100 to-cyan-100 text-xl font-extrabold text-blue-600">
                                {{ strtoupper(substr($attempt->student->name ?? 'S', 0, 1)) }}
                            </div>

                            <div class="min-w-0">

                                <h3 class="font-extrabold text-slate-800">
                                    {{ $attempt->student->name ?? 'Siswa tidak ditemukan' }}
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Kelas {{ $attempt->student->studentProfile->grade_level ?? '-' }}
                                </p>

                                <p class="mt-2 text-sm font-semibold text-[#087bc9]">
                                    {{ $attempt->topic->title ?? 'Topik tidak tersedia' }}
                                </p>

                            </div>
                        </div>


                        {{-- Assessment information --}}
                        <div class="flex flex-wrap gap-x-8 gap-y-4">

                            <div class="min-w-[100px]">
                                <div class="flex items-center gap-2 text-xs text-slate-400">
                                    <span>📝</span>
                                    Jumlah Soal
                                </div>

                                <p class="mt-2 font-bold text-slate-700">
                                    {{ $attempt->answers_count }} soal
                                </p>
                            </div>

                            <div class="min-w-[150px]">
                                <div class="flex items-center gap-2 text-xs text-slate-400">
                                    <span>🕒</span>
                                    Diselesaikan
                                </div>

                                <p class="mt-2 font-bold text-slate-700">
                                    {{ $attempt->completed_at?->format('d M Y, H:i') ?? '-' }}
                                </p>
                            </div>

                        </div>


                        {{-- Status --}}
                        <div>
                            <span class="inline-flex items-center gap-2 rounded-full border border-emerald-100 bg-emerald-50 px-4 py-2 text-xs font-bold text-emerald-600">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                Asesmen Selesai
                            </span>
                        </div>


                        {{-- Detail action --}}
                        <div class="shrink-0">

                            <a href="{{ route('teacher.results.show', $attempt->id) }}"
                               class="inline-flex w-full items-center justify-center gap-3 rounded-full bg-gradient-to-r from-[#087cf0] to-[#12b5ed] px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-100 transition hover:-translate-y-1 hover:shadow-xl lg:w-auto">

                                Lihat Hasil
                                <span class="text-lg">→</span>

                            </a>

                        </div>

                    </div>

                </article>

            @empty

                <div class="p-12 text-center">

                    <div class="result-float mx-auto flex h-24 w-24 items-center justify-center rounded-[30px] bg-gradient-to-br from-blue-100 to-cyan-100 text-5xl">
                        📝
                    </div>

                    <h3 class="mt-5 text-xl font-extrabold text-slate-800">
                        Belum Ada Hasil Asesmen
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                        Riwayat pengerjaan akan muncul setelah siswa menyelesaikan asesmen numerasi.
                    </p>

                    <div class="mt-5 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-4 py-2 text-xs font-semibold text-blue-600">
                        <span>ℹ</span>
                        Menunggu pengerjaan siswa
                    </div>

                </div>

            @endforelse

        </div>


        {{-- Pagination --}}
        @if ($attempts->hasPages())
            <div class="border-t border-slate-100 bg-slate-50/50 p-5 md:px-7">
                {{ $attempts->links() }}
            </div>
        @endif

    </section>

</div>

@endsection
