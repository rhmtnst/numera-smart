
@extends('layouts.teacher')

@section('title', 'Analisis Kesulitan Siswa')

@section('content')

<style>
    .analysis-float {
        animation: analysis-float 4s ease-in-out infinite;
    }

    .analysis-float-delay {
        animation: analysis-float 4.8s ease-in-out infinite;
        animation-delay: .7s;
    }

    .analysis-pulse {
        transform-box: fill-box;
        transform-origin: center;
        animation: analysis-pulse 2.5s ease-in-out infinite;
    }

    .analysis-card {
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .analysis-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 38px rgba(8,126,197,.12);
    }

    @keyframes analysis-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-11px); }
    }

    @keyframes analysis-pulse {
        0%, 100% { opacity: .5; transform: scale(.9); }
        50% { opacity: 1; transform: scale(1.12); }
    }

    @media (prefers-reduced-motion: reduce) {
        .analysis-float,
        .analysis-float-delay,
        .analysis-pulse {
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
                    Analisis Kesulitan Siswa
                </h1>

                <p class="mt-4 max-w-xl text-sm leading-7 text-white/85 md:text-base">
                    Tinjau ringkasan analisis Newman untuk setiap asesmen topik. Konfirmasikan satu diagnosis keseluruhan, lalu tentukan tindak lanjut pembelajaran berdasarkan bukti pada jawaban siswa.
                </p>

                <div class="mt-7 flex flex-wrap items-center gap-3">
                    <div class="inline-flex items-center gap-3 rounded-full border border-white/35 bg-white/15 px-5 py-3 backdrop-blur-md">
                        <span class="text-xl">🔍</span>
                        <span class="text-sm font-semibold">
                            {{ $attempts->total() }} asesmen tercatat
                        </span>
                    </div>
                </div>
            </div>


            {{-- Animated analysis illustration --}}
            <div class="relative mx-auto hidden h-56 w-full max-w-[270px] lg:block">

                <div class="absolute inset-5 rounded-full bg-white/10 blur-sm"></div>

                <svg viewBox="0 0 270 220"
                     class="relative z-10 h-full w-full"
                     xmlns="http://www.w3.org/2000/svg"
                     role="img"
                     aria-label="Ilustrasi animasi analisis dan verifikasi jawaban">

                    {{-- Sparkles --}}
                    <g class="analysis-pulse" fill="#FFF4A8">
                        <path d="M38 43 L43 55 L55 60 L43 65 L38 77 L33 65 L21 60 L33 55 Z"/>
                    </g>

                    <g class="analysis-pulse" fill="#FFFFFF" style="animation-delay:.8s">
                        <path d="M224 34 L228 44 L238 48 L228 52 L224 62 L220 52 L210 48 L220 44 Z"/>
                    </g>

                    {{-- Analysis paper --}}
                    <g class="analysis-float" transform="translate(45 35) rotate(-5 75 80)">
                        <rect x="5" y="5" width="145" height="155" rx="13" fill="#075CB8"/>
                        <rect x="0" y="0" width="145" height="155" rx="13" fill="#FFFFFF"/>

                        <rect x="16" y="16" width="65" height="9" rx="4" fill="#087CF0"/>
                        <rect x="16" y="33" width="43" height="5" rx="2" fill="#B7DDF0"/>

                        {{-- Analysis rows --}}
                        <circle cx="25" cy="58" r="6" fill="#36D99A"/>
                        <path d="M40 58 H122" stroke="#A9D4E9" stroke-width="5" stroke-linecap="round"/>

                        <circle cx="25" cy="82" r="6" fill="#12B5ED"/>
                        <path d="M40 82 H112" stroke="#A9D4E9" stroke-width="5" stroke-linecap="round"/>

                        <circle cx="25" cy="106" r="6" fill="#FFE28A"/>
                        <path d="M40 106 H122" stroke="#A9D4E9" stroke-width="5" stroke-linecap="round"/>

                        <path d="M17 132 H125" stroke="#DCEBF4" stroke-width="4" stroke-linecap="round"/>
                    </g>

                    {{-- Magnifying glass --}}
                    <g class="analysis-float-delay" transform="translate(142 103) rotate(-12)">
                        <circle cx="35" cy="35" r="30" fill="#B9F4FF" fill-opacity=".9" stroke="#FFFFFF" stroke-width="5"/>
                        <circle cx="35" cy="35" r="20" fill="#DFFAFF" fill-opacity=".7"/>
                        <path d="M57 57 L83 83" stroke="#075CB8" stroke-width="13" stroke-linecap="round"/>
                        <path d="M57 57 L83 83" stroke="#36D99A" stroke-width="7" stroke-linecap="round"/>
                    </g>

                    {{-- Verified check --}}
                    <g class="analysis-pulse" transform="translate(188 146)">
                        <circle cx="20" cy="20" r="19" fill="#36D99A" stroke="#FFFFFF" stroke-width="4"/>
                        <path d="M10 20 L17 27 L30 13" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>

                    <circle cx="39" cy="151" r="5" fill="#FFE28A" class="analysis-pulse"/>

                </svg>
            </div>

        </div>
    </section>


    {{-- SUMMARY: status keputusan dihitung per asesmen/topik, bukan per jawaban --}}
    @php
        $confirmedTopics = $attempts->filter(
            fn ($item) => $item->topicReview?->decision === 'confirmed'
        )->count();

        $topicsNeedingRevision = $attempts->filter(
            fn ($item) => $item->topicReview?->decision === 'needs_revision'
        )->count();

        $topicsAwaitingReview = $attempts->filter(
            fn ($item) => !$item->topicReview
        )->count();
    @endphp


    {{-- STATISTICS --}}
    <section class="relative">

        <div class="mb-5">
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#168bd1]">
                Ringkasan Aktivitas
            </p>

            <h2 class="mt-1 text-xl font-extrabold tracking-tight text-slate-800">
                Statistik Analisis
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Pantau kesiapan analisis dan keputusan guru untuk setiap asesmen topik.
            </p>
        </div>


        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">

            {{-- Completed attempts --}}
            <div class="analysis-card relative overflow-hidden rounded-[25px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl">

                <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-blue-100/70"></div>

                <div class="relative flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-500">
                        Asesmen Selesai
                    </span>

                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 text-xl text-white shadow-lg shadow-blue-100">
                        ▤
                    </span>
                </div>

                <div class="relative mt-5 text-4xl font-extrabold text-[#087bc9]">
                    {{ $attempts->total() }}
                </div>

                <p class="relative mt-2 text-xs text-slate-400">
                    Total asesmen yang diselesaikan siswa
                </p>

                <div class="relative mt-5 h-1.5 rounded-full bg-blue-50">
                    <div class="h-full w-full rounded-full bg-gradient-to-r from-blue-500 to-cyan-400"></div>
                </div>
            </div>


            {{-- Topic diagnoses confirmed --}}
            <div class="analysis-card relative overflow-hidden rounded-[25px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl">
                <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-emerald-100/70"></div>
                <div class="relative flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-500">Diagnosis Topik Dikonfirmasi</span>
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-400 text-xl text-white shadow-lg shadow-emerald-100">✓</span>
                </div>
                <div class="relative mt-5 text-4xl font-extrabold text-emerald-500">{{ $confirmedTopics }}</div>
                <p class="relative mt-2 text-xs text-slate-400">Asesmen dengan keputusan topik dikonfirmasi guru</p>
                <div class="relative mt-5 h-1.5 rounded-full bg-emerald-50">
                    <div class="h-full w-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-400"></div>
                </div>
            </div>

            {{-- Topic diagnoses awaiting review --}}
            <div class="analysis-card relative overflow-hidden rounded-[25px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl">
                <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-amber-100/70"></div>
                <div class="relative flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-500">Menunggu Keputusan Topik</span>
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-orange-400 to-amber-300 text-xl text-white shadow-lg shadow-orange-100">◷</span>
                </div>
                <div class="relative mt-5 text-4xl font-extrabold text-amber-500">{{ $topicsAwaitingReview }}</div>
                <p class="relative mt-2 text-xs text-slate-400">Asesmen yang belum dikonfirmasi guru</p>
                <div class="relative mt-5 h-1.5 rounded-full bg-amber-50">
                    <div class="h-full w-full rounded-full bg-gradient-to-r from-orange-400 to-amber-300"></div>
                </div>
                @if($topicsNeedingRevision > 0)
                    <p class="relative mt-2 text-xs font-semibold text-rose-600">{{ $topicsNeedingRevision }} diagnosis perlu perbaikan</p>
                @endif
            </div>
        </div>
    </section>


    {{-- NEWMAN ANALYSIS PROCESS --}}
    <section class="relative overflow-hidden rounded-[25px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] md:p-7">

        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 text-xl text-white shadow-lg shadow-blue-100">
                🧠
            </div>

            <div>
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168bd1]">
                    Kerangka Analisis
                </p>

                <h2 class="mt-1 text-lg font-extrabold text-slate-800">
                    Tahapan Newman
                </h2>
            </div>
        </div>

        <p class="mt-3 text-sm leading-6 text-slate-500">
            Analisis kesulitan numerasi dilakukan dengan memperhatikan lima tahapan Newman sebagai kerangka untuk memahami proses siswa dalam menyelesaikan soal.
        </p>

        <div class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-5">

            <div class="rounded-2xl border border-blue-100 bg-blue-50/70 p-4">
                <span class="text-2xl">📖</span>
                <p class="mt-3 text-sm font-extrabold text-blue-700">Reading</p>
                <p class="mt-1 text-xs leading-5 text-slate-500">Membaca soal</p>
            </div>

            <div class="rounded-2xl border border-cyan-100 bg-cyan-50/70 p-4">
                <span class="text-2xl">💡</span>
                <p class="mt-3 text-sm font-extrabold text-cyan-700">Comprehension</p>
                <p class="mt-1 text-xs leading-5 text-slate-500">Memahami soal</p>
            </div>

            <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4">
                <span class="text-2xl">🧮</span>
                <p class="mt-3 text-sm font-extrabold text-emerald-700">Transformation</p>
                <p class="mt-1 text-xs leading-5 text-slate-500">Transformasi soal</p>
            </div>

            <div class="rounded-2xl border border-amber-100 bg-amber-50/70 p-4">
                <span class="text-2xl">✏️</span>
                <p class="mt-3 text-sm font-extrabold text-amber-700">Process Skills</p>
                <p class="mt-1 text-xs leading-5 text-slate-500">Keterampilan proses</p>
            </div>

            <div class="rounded-2xl border border-purple-100 bg-purple-50/70 p-4">
                <span class="text-2xl">🎯</span>
                <p class="mt-3 text-sm font-extrabold text-purple-700">Encoding</p>
                <p class="mt-1 text-xs leading-5 text-slate-500">Penulisan jawaban</p>
            </div>

        </div>

        <p class="mt-4 text-xs leading-5 text-slate-400">
            Kelima tahapan ini merupakan informasi pendukung untuk memahami kerangka Newman, bukan hasil pengukuran tambahan dari halaman ini.
        </p>

    </section>


    {{-- ASSESSMENT HISTORY --}}
    <section class="relative overflow-hidden rounded-[28px] border border-white bg-white/95 shadow-[0_15px_40px_rgba(38,105,160,0.08)] backdrop-blur-xl">

        {{-- Heading --}}
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 bg-gradient-to-r from-blue-50/90 via-cyan-50/70 to-emerald-50/70 p-6 md:p-7">

            <div class="flex items-center gap-4">

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 text-xl text-white shadow-lg shadow-blue-100">
                    🔍
                </div>

                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168bd1]">
                        Pemantauan Siswa
                    </p>

                    <h2 class="mt-1 text-xl font-extrabold text-slate-800">
                        Riwayat Asesmen Siswa
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Pilih asesmen untuk melihat analisis Newman dan melakukan verifikasi.
                    </p>
                </div>

            </div>

            <span class="rounded-full border border-white bg-white/90 px-4 py-2 text-xs font-bold text-slate-500 shadow-sm">
                {{ $attempts->total() }} asesmen
            </span>

        </div>


        {{-- Attempts list --}}
        <div class="divide-y divide-slate-100">

            @forelse ($attempts as $attempt)

                @php
                    $totalAnswers = $attempt->answers->count();
                    $analyzedCount = $attempt->answers->filter(
                        fn ($answer) => $answer->analysis?->analysis_status === 'completed'
                    )->count();
                    $analysisProgress = $totalAnswers > 0
                        ? (int) round(($analyzedCount / $totalAnswers) * 100)
                        : 0;

                    $topicDecision = $attempt->topicReview?->decision;

                    if ($topicDecision === 'confirmed') {
                        $reviewLabel = 'Diagnosis topik dikonfirmasi';
                        $reviewColor = 'border-emerald-100 bg-emerald-50 text-emerald-700';
                    } elseif ($topicDecision === 'needs_revision') {
                        $reviewLabel = 'Diagnosis perlu perbaikan';
                        $reviewColor = 'border-rose-100 bg-rose-50 text-rose-700';
                    } else {
                        $reviewLabel = 'Menunggu konfirmasi topik';
                        $reviewColor = 'border-amber-100 bg-amber-50 text-amber-700';
                    }
                @endphp


                <article class="group p-6 transition duration-200 hover:bg-blue-50/40 md:p-7">

                    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">

                        {{-- Student identity --}}
                        <div class="flex min-w-0 items-start gap-4">

                            <div class="analysis-float flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-100 to-cyan-100 text-xl font-extrabold text-blue-600">
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
                                <p class="text-xs text-slate-400">
                                    Jumlah Soal
                                </p>

                                <p class="mt-2 font-bold text-slate-700">
                                    {{ $attempt->answers_count }} soal
                                </p>
                            </div>

                            <div class="min-w-[150px]">
                                <p class="text-xs text-slate-400">
                                    Diselesaikan
                                </p>

                                <p class="mt-2 font-bold text-slate-700">
                                    {{ $attempt->completed_at?->format('d M Y, H:i') ?? '-' }}
                                </p>
                            </div>

                        </div>


                        {{-- Verification progress --}}
                        <div class="w-full lg:w-64 lg:shrink-0">

                            <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-bold {{ $reviewColor }}">
                                <span class="h-2 w-2 rounded-full bg-current"></span>
                                {{ $reviewLabel }}
                            </span>

                            <div class="mt-4">
                                <div class="mb-2 flex justify-between text-xs">
                                    <span class="font-medium text-slate-500">Analisis AI selesai</span>
                                    <span class="font-extrabold text-slate-700">{{ $analyzedCount }}/{{ $totalAnswers }}</span>
                                </div>
                                <div class="h-2 w-full overflow-hidden rounded-full bg-slate-100">
                                    <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-cyan-400 transition-all duration-500"
                                         style="width: {{ $analysisProgress }}%"></div>
                                </div>
                                <p class="mt-3 text-xs font-medium text-slate-500">
                                    Keputusan guru dicatat satu kali untuk keseluruhan diagnosis topik.
                                </p>
                            </div>

                        </div>

                    </div>


                    {{-- Detail action --}}
                    <div class="mt-6 flex justify-end border-t border-slate-100 pt-5">

                        <a href="{{ route('teacher.analyses.show', $attempt->id) }}"
                           class="inline-flex w-full items-center justify-center gap-3 rounded-full bg-gradient-to-r from-[#087cf0] to-[#12b5ed] px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-100 transition hover:-translate-y-1 hover:shadow-xl sm:w-auto">

                            Lihat Analisis
                            <span class="text-lg">→</span>

                        </a>

                    </div>

                </article>

            @empty

                <div class="p-12 text-center">

                    <div class="analysis-float mx-auto flex h-24 w-24 items-center justify-center rounded-[30px] bg-gradient-to-br from-blue-100 to-cyan-100 text-5xl">
                        📊
                    </div>

                    <h3 class="mt-5 text-xl font-extrabold text-slate-800">
                        Belum Ada Hasil Asesmen
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                        Hasil analisis akan muncul di sini setelah siswa menyelesaikan asesmen numerasi.
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
