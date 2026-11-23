
@extends('layouts.teacher')

@section('title', 'Bank Soal')

@section('content')

<style>
    .qb-float {
        animation: qb-float 4s ease-in-out infinite;
    }

    .qb-float-delay {
        animation: qb-float 4.8s ease-in-out infinite;
        animation-delay: .8s;
    }

    .qb-symbol {
        animation: qb-symbol 3s ease-in-out infinite;
    }

    .qb-card {
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .qb-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 38px rgba(8, 126, 197, .12);
    }

    @keyframes qb-float {
        0%, 100% { transform: translateY(0) rotate(-2deg); }
        50% { transform: translateY(-11px) rotate(2deg); }
    }

    @keyframes qb-symbol {
        0%, 100% { opacity: .5; transform: scale(.9) rotate(-5deg); }
        50% { opacity: 1; transform: scale(1.1) rotate(5deg); }
    }

    @media (prefers-reduced-motion: reduce) {
        .qb-float, .qb-float-delay, .qb-symbol {
            animation: none !important;
        }
    }
</style>

<div class="relative space-y-8 overflow-hidden">

    {{-- Background decoration --}}
    <div class="pointer-events-none absolute -right-24 -top-24 h-80 w-80 rounded-full bg-cyan-300/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-24 top-[35rem] h-72 w-72 rounded-full bg-blue-300/20 blur-3xl"></div>


    {{-- Hero --}}
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
                    Bank Soal
                </h1>

                <p class="mt-4 max-w-xl text-sm leading-7 text-white/85 md:text-base">
                    Kelola kumpulan soal numerasi berdasarkan kelas, domain, dan topik. Pastikan setiap soal siap digunakan untuk mendukung proses asesmen siswa.
                </p>

                <div class="mt-7 flex flex-wrap items-center gap-3">
                    <a href="{{ route('teacher.questions.create') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-bold text-[#087bc9] shadow-lg transition hover:-translate-y-1 hover:shadow-xl">
                        <span class="text-lg">＋</span>
                        Tambah Soal
                    </a>

                    <div class="inline-flex items-center gap-2 rounded-full border border-white/35 bg-white/15 px-4 py-3 text-sm font-semibold backdrop-blur-md">
                        <span>📝</span>
                        {{ $totalQuestions }} soal terdaftar
                    </div>
                </div>
            </div>

            {{-- Animated math illustration --}}
            <div class="relative mx-auto hidden h-56 w-full max-w-[270px] lg:block">
                <div class="absolute inset-4 rounded-full bg-white/10 blur-sm"></div>

                <svg viewBox="0 0 270 220" class="relative z-10 h-full w-full" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi animasi buku dan simbol matematika">

                    {{-- Mathematical symbols --}}
                    <g class="qb-symbol" fill="#FFF4A8" font-size="30" font-weight="bold">
                        <text x="22" y="55">+</text>
                        <text x="222" y="75">÷</text>
                    </g>

                    <g class="qb-symbol" fill="#FFFFFF" font-size="25" font-weight="bold" style="animation-delay:.8s">
                        <text x="30" y="170">×</text>
                        <text x="220" y="175">=</text>
                    </g>

                    {{-- Floating pencil --}}
                    <g class="qb-float-delay" transform="translate(187 40) rotate(35)">
                        <rect x="0" y="0" width="14" height="95" rx="6" fill="#FFE28A"/>
                        <rect x="0" y="0" width="14" height="18" rx="5" fill="#FF8A75"/>
                        <path d="M0 95 L7 108 L14 95 Z" fill="#F4D3A2"/>
                        <path d="M4 103 L7 108 L10 103 Z" fill="#304B68"/>
                    </g>

                    {{-- Main book --}}
                    <g class="qb-float" transform="translate(42 82) rotate(-7 82 55)">
                        <rect x="6" y="8" width="154" height="105" rx="12" fill="#075CB8"/>
                        <rect x="0" y="0" width="154" height="105" rx="12" fill="#FFFFFF"/>
                        <path d="M77 5 V100" stroke="#D7E9F8" stroke-width="3"/>
                        <path d="M15 25 H65 M15 38 H65 M15 51 H55" stroke="#58B9E7" stroke-width="5" stroke-linecap="round"/>
                        <path d="M92 25 H139 M92 38 H139 M92 51 H129" stroke="#58B9E7" stroke-width="5" stroke-linecap="round"/>
                        <circle cx="40" cy="76" r="10" fill="#36D99A"/>
                        <rect x="103" y="66" width="27" height="20" rx="5" fill="#FFE28A"/>
                    </g>

                    <circle cx="224" cy="135" r="7" fill="#B9FFF0" class="qb-symbol"/>
                    <circle cx="39" cy="91" r="5" fill="#FFE28A" class="qb-symbol"/>
                </svg>
            </div>

        </div>
    </section>


    {{-- Statistics --}}
    <section class="relative">

        <div class="mb-5">
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#168bd1]">
                Ringkasan Bank Soal
            </p>
            <h2 class="mt-1 text-xl font-extrabold tracking-tight text-slate-800">
                Statistik Soal
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Pantau perkembangan dan status soal dalam sistem.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Total --}}
            <div class="qb-card relative overflow-hidden rounded-[25px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-blue-100/70"></div>
                <div class="relative flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-500">Total Soal</span>
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 text-xl text-white shadow-lg shadow-blue-100">▤</span>
                </div>
                <div class="relative mt-5 text-4xl font-extrabold text-[#087bc9]">{{ $totalQuestions }}</div>
                <p class="relative mt-2 text-xs text-slate-400">Seluruh soal dalam bank soal</p>
                <div class="relative mt-5 h-1.5 rounded-full bg-blue-50">
                    <div class="h-full w-full rounded-full bg-gradient-to-r from-blue-500 to-cyan-400"></div>
                </div>
            </div>

            {{-- Draft --}}
            <div class="qb-card relative overflow-hidden rounded-[25px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-amber-100/70"></div>
                <div class="relative flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-500">Draft</span>
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-orange-400 to-amber-300 text-xl text-white shadow-lg shadow-orange-100">◷</span>
                </div>
                <div class="relative mt-5 text-4xl font-extrabold text-amber-500">{{ $totalDraft }}</div>
                <p class="relative mt-2 text-xs text-slate-400">Soal yang belum disetujui</p>
                <div class="relative mt-5 h-1.5 rounded-full bg-amber-50">
                    <div class="h-full w-full rounded-full bg-gradient-to-r from-orange-400 to-amber-300"></div>
                </div>
            </div>

            {{-- Approved --}}
            <div class="qb-card relative overflow-hidden rounded-[25px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-emerald-100/70"></div>
                <div class="relative flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-500">Disetujui</span>
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-400 text-xl text-white shadow-lg shadow-emerald-100">✓</span>
                </div>
                <div class="relative mt-5 text-4xl font-extrabold text-emerald-500">{{ $totalApproved }}</div>
                <p class="relative mt-2 text-xs text-slate-400">Soal siap digunakan</p>
                <div class="relative mt-5 h-1.5 rounded-full bg-emerald-50">
                    <div class="h-full w-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-400"></div>
                </div>
            </div>

            {{-- Revision --}}
            <div class="qb-card relative overflow-hidden rounded-[25px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-orange-100/70"></div>
                <div class="relative flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-500">Perlu Revisi</span>
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-orange-500 to-amber-400 text-xl text-white shadow-lg shadow-orange-100">✎</span>
                </div>
                <div class="relative mt-5 text-4xl font-extrabold text-orange-500">{{ $totalRevision }}</div>
                <p class="relative mt-2 text-xs text-slate-400">Soal yang perlu diperbaiki</p>
                <div class="relative mt-5 h-1.5 rounded-full bg-orange-50">
                    <div class="h-full w-full rounded-full bg-gradient-to-r from-orange-500 to-amber-400"></div>
                </div>
            </div>

        </div>
    </section>


    {{-- Question list --}}
    <section class="relative overflow-hidden rounded-[28px] border border-white bg-white/95 shadow-[0_15px_40px_rgba(38,105,160,0.08)] backdrop-blur-xl">

        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 bg-gradient-to-r from-blue-50/90 via-cyan-50/70 to-emerald-50/70 p-6 md:p-7">

            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 text-xl text-white shadow-lg shadow-blue-100">
                    📝
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168bd1]">
                        Koleksi Numerasi
                    </p>
                    <h2 class="mt-1 text-xl font-extrabold text-slate-800">
                        Daftar Bank Soal
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Periksa soal dan status pengelolaannya.
                    </p>
                </div>
            </div>

            <a href="{{ route('teacher.questions.create') }}"
               class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#087cf0] to-[#12b5ed] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-blue-100 transition hover:-translate-y-1 hover:shadow-xl">
                <span class="text-lg">＋</span>
                Tambah Soal
            </a>
        </div>


        {{-- Questions --}}
        <div class="divide-y divide-slate-100">

            @forelse ($questions as $question)

                <article class="group flex flex-col justify-between gap-5 p-6 transition duration-200 hover:bg-blue-50/40 md:flex-row md:items-center md:px-7">

                    <div class="flex min-w-0 items-start gap-4">

                        <div class="qb-float flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-100 to-cyan-100 text-xl text-blue-600">
                            ?
                        </div>

                        <div class="min-w-0">
                            <h3 class="font-bold leading-7 text-slate-800">
                                {{ $question->question_text }}
                            </h3>

                            <div class="mt-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-sm text-slate-500">
                                <span>{{ $question->topic?->title ?? 'Topik belum tersedia' }}</span>
                                <span class="text-slate-300">•</span>
                                <span>Kelas {{ $question->topic?->grade_level ?? '-' }}</span>
                                <span class="text-slate-300">•</span>
                                <span>{{ ucfirst($question->difficulty) }}</span>
                            </div>

                            <div class="mt-3">
                                @if ($question->review_status === 'approved')
                                    <span class="inline-flex items-center gap-2 rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-600">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                        Disetujui
                                    </span>
                                @elseif ($question->review_status === 'revision_requested')
                                    <span class="inline-flex items-center gap-2 rounded-full border border-orange-100 bg-orange-50 px-3 py-1.5 text-xs font-bold text-orange-600">
                                        <span class="h-2 w-2 rounded-full bg-orange-400"></span>
                                        Perlu Revisi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 rounded-full border border-amber-100 bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-600">
                                        <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                                        {{ ucfirst(str_replace('_', ' ', $question->review_status)) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>


                    {{-- Original ownership and action conditions --}}
                    <div class="flex shrink-0 flex-wrap items-center gap-2">

                        @if ($question->created_by === auth()->id())

                            @if (in_array($question->review_status, ['draft', 'revision_requested']))
                                <a href="{{ route('teacher.questions.edit', $question) }}"
                                   class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-5 py-2.5 text-sm font-bold text-blue-600 transition hover:bg-blue-100">
                                    ✎ Edit Soal
                                </a>

                            @elseif ($question->review_status === 'approved')
                                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2.5 text-sm font-bold text-emerald-600">
                                    ✓ Soal Disetujui
                                </span>
                            @endif

                        @else
                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2.5 text-xs font-semibold text-slate-500">
                                ◈ Soal Bawaan Sistem
                            </span>
                        @endif

                    </div>

                </article>

            @empty

                <div class="p-12 text-center">
                    <div class="qb-float mx-auto flex h-20 w-20 items-center justify-center rounded-[28px] bg-gradient-to-br from-blue-100 to-cyan-100 text-4xl">
                        📝
                    </div>

                    <h3 class="mt-5 text-lg font-extrabold text-slate-800">
                        Belum Ada Soal
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                        Belum ada soal dalam bank soal. Kamu dapat mulai menambahkan soal numerasi untuk mendukung pembelajaran.
                    </p>

                    <a href="{{ route('teacher.questions.create') }}"
                       class="mt-6 inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#087cf0] to-[#12b5ed] px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-100">
                        ＋ Tambah Soal
                    </a>
                </div>

            @endforelse

        </div>


        {{-- Pagination --}}
        <div class="border-t border-slate-100 bg-slate-50/50 p-5 md:px-7">
            {{ $questions->links() }}
        </div>

    </section>

</div>

@endsection
