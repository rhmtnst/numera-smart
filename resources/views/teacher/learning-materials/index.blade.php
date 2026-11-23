
@extends('layouts.teacher')

@section('title', 'Materi Utama')

@section('content')

<style>
    .lm-page {
        --lm-blue: #087cf0;
        --lm-cyan: #12b5ed;
        --lm-green: #36d99a;
    }

    .lm-float {
        animation: lm-float 4s ease-in-out infinite;
    }

    .lm-float-delay {
        animation: lm-float 4.8s ease-in-out infinite;
        animation-delay: .7s;
    }

    .lm-sparkle {
        transform-box: fill-box;
        transform-origin: center;
        animation: lm-sparkle 2.5s ease-in-out infinite;
    }

    .lm-book {
        transform-box: fill-box;
        transform-origin: center bottom;
        animation: lm-book 3.5s ease-in-out infinite;
    }

    @keyframes lm-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-12px); }
    }

    @keyframes lm-sparkle {
        0%, 100% { opacity: .45; transform: scale(.8) rotate(0deg); }
        50% { opacity: 1; transform: scale(1.15) rotate(12deg); }
    }

    @keyframes lm-book {
        0%, 100% { transform: rotate(0deg); }
        50% { transform: rotate(-3deg); }
    }

    .lm-action {
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .lm-action:hover {
        transform: translateY(-2px);
    }

    @media (prefers-reduced-motion: reduce) {
        .lm-float,
        .lm-float-delay,
        .lm-sparkle,
        .lm-book {
            animation: none !important;
        }
    }
</style>

<div class="lm-page relative space-y-8 overflow-hidden">

    {{-- Decorative background --}}
    <div class="pointer-events-none absolute -right-24 -top-24 h-80 w-80 rounded-full bg-cyan-300/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-24 top-[35rem] h-72 w-72 rounded-full bg-blue-300/20 blur-3xl"></div>


    {{-- Hero --}}
    <section class="relative overflow-hidden rounded-[30px] border border-white/70 bg-gradient-to-br from-[#087cf0] via-[#12b5ed] to-[#36d99a] p-7 text-white shadow-[0_20px_50px_rgba(13,126,222,0.18)] md:p-9">

        <div class="absolute -right-16 -top-24 h-72 w-72 rounded-full bg-white/15"></div>
        <div class="absolute -bottom-32 right-1/4 h-64 w-64 rounded-full bg-[#075de0]/20"></div>

        <div class="relative z-10 grid items-center gap-8 lg:grid-cols-[1fr_300px]">

            <div>
                <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/15 px-4 py-2 text-xs font-semibold backdrop-blur-md">
                    <span class="h-2 w-2 rounded-full bg-[#a7ffda]"></span>
                    NUMERA SMART · RUANG GURU
                </div>

                <h1 class="text-3xl font-extrabold tracking-tight md:text-4xl">
                    Materi Utama
                </h1>

                <p class="mt-4 max-w-xl text-sm leading-7 text-white/85 md:text-base">
                    Kelola materi pembelajaran numerasi untuk setiap kelas yang ditugaskan kepada Anda. Pastikan siswa mendapatkan bahan belajar yang tepat.
                </p>

                <div class="mt-7 flex flex-wrap items-center gap-3">
                    <a href="{{ route('teacher.learning-materials.create') }}"
                       class="lm-action inline-flex items-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-bold text-[#087bc9] shadow-lg hover:shadow-xl">
                        <span class="text-lg">＋</span>
                        Tambah Materi
                    </a>

                    <div class="inline-flex items-center gap-2 rounded-full border border-white/35 bg-white/15 px-4 py-3 text-sm font-semibold backdrop-blur-md">
                        <span>📚</span>
                        {{ $materials->total() }} materi terdaftar
                    </div>
                </div>
            </div>

            {{-- Animated learning illustration --}}
            <div class="relative mx-auto hidden h-56 w-full max-w-[280px] lg:block">

                <div class="absolute left-8 top-7 h-40 w-40 rounded-full bg-white/15 blur-sm"></div>

                <svg viewBox="0 0 280 220" class="relative z-10 h-full w-full" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi animasi buku dan alat belajar">

                    {{-- Sparkles --}}
                    <g class="lm-sparkle" fill="#FFF4A8">
                        <path d="M42 46 L47 58 L59 63 L47 68 L42 80 L37 68 L25 63 L37 58 Z"/>
                    </g>
                    <g class="lm-sparkle" fill="#FFFFFF" style="animation-delay:.8s">
                        <path d="M225 34 L229 44 L239 48 L229 52 L225 62 L221 52 L211 48 L221 44 Z"/>
                    </g>
                    <circle cx="235" cy="145" r="5" fill="#B9FFF0" class="lm-sparkle"/>
                    <circle cx="48" cy="145" r="4" fill="#FFFFFF" class="lm-sparkle"/>

                    {{-- Floating pencil --}}
                    <g class="lm-float-delay" transform="translate(188 65) rotate(35)">
                        <rect x="0" y="0" width="15" height="91" rx="6" fill="#FFE28A"/>
                        <rect x="0" y="0" width="15" height="17" rx="5" fill="#FF8A75"/>
                        <path d="M0 91 L7.5 105 L15 91 Z" fill="#F4D3A2"/>
                        <path d="M5 100 L7.5 105 L10 100 Z" fill="#304B68"/>
                    </g>

                    {{-- Back book --}}
                    <g class="lm-float" transform="translate(50 112) rotate(-9 80 40)">
                        <rect x="5" y="7" width="145" height="77" rx="10" fill="#075CB8"/>
                        <rect x="0" y="0" width="145" height="77" rx="10" fill="#FFFFFF"/>
                        <path d="M72 4 V73" stroke="#D7E9F8" stroke-width="3"/>
                        <path d="M15 19 H61 M15 29 H61 M84 19 H130 M84 29 H130" stroke="#A8D9F5" stroke-width="4" stroke-linecap="round"/>
                    </g>

                    {{-- Front book --}}
                    <g class="lm-book" transform="translate(72 137)">
                        <rect x="5" y="7" width="145" height="65" rx="9" fill="#0876CC"/>
                        <rect x="0" y="0" width="145" height="65" rx="9" fill="#E7FFFA"/>
                        <path d="M72 4 V61" stroke="#A5D8D6" stroke-width="3"/>
                        <path d="M15 19 H60 M15 29 H60 M84 19 H130 M84 29 H130" stroke="#42B9C8" stroke-width="4" stroke-linecap="round"/>
                        <path d="M15 43 H55 M84 43 H126" stroke="#B2D9E9" stroke-width="3" stroke-linecap="round"/>
                    </g>

                    {{-- Small decorative circle --}}
                    <circle cx="212" cy="183" r="13" fill="#B9FFF0" opacity=".8"/>
                    <circle cx="45" cy="188" r="9" fill="#FFE28A"/>

                </svg>
            </div>

        </div>
    </section>


    {{-- Information heading --}}
    <section class="relative">
        <div class="mb-5 flex flex-wrap items-end justify-between gap-3">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#168bd1]">
                    Pusat Konten
                </p>
                <h2 class="mt-1 text-xl font-extrabold tracking-tight text-slate-800">
                    Daftar Materi Pembelajaran
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Materi yang tersedia untuk kelas penugasan Anda.
                </p>
            </div>

            <span class="rounded-full border border-white bg-white/80 px-4 py-2 text-xs font-semibold text-slate-500 shadow-sm">
                {{ $materials->total() }} total materi
            </span>
        </div>


        {{-- Material cards --}}
        <div class="grid grid-cols-1 gap-5 xl:grid-cols-2">

            @forelse($materials as $material)

                <article class="group relative overflow-hidden rounded-[26px] border border-white bg-white/95 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_40px_rgba(8,126,197,0.13)]">

                    <div class="absolute -right-10 -top-10 h-36 w-36 rounded-full bg-gradient-to-br from-blue-100/80 to-cyan-100/70 transition duration-500 group-hover:scale-125"></div>

                    <div class="relative flex flex-wrap items-start justify-between gap-4">

                        <div class="flex min-w-0 items-start gap-4">

                            <div class="lm-float flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 text-2xl text-white shadow-lg shadow-blue-100">
                                📘
                            </div>

                            <div class="min-w-0">
                                <h3 class="text-lg font-extrabold leading-snug text-slate-800">
                                    {{ $material->title }}
                                </h3>

                                <p class="mt-2 text-sm font-medium text-slate-500">
                                    {{ $material->topic?->learningDomain?->name ?? 'Domain belum tersedia' }}
                                </p>
                            </div>

                        </div>

                        @if($material->status === 'published')
                            <span class="inline-flex shrink-0 items-center gap-2 rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-600">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                Dipublikasikan
                            </span>
                        @else
                            <span class="inline-flex shrink-0 items-center gap-2 rounded-full border border-amber-100 bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-600">
                                <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                                Draft
                            </span>
                        @endif

                    </div>


                    {{-- Material metadata --}}
                    <div class="relative mt-6 flex flex-wrap gap-2">
                        <span class="inline-flex items-center gap-2 rounded-xl bg-blue-50 px-3 py-2 text-xs font-bold text-blue-600">
                            <span>🎓</span>
                            Kelas {{ $material->topic?->grade_level ?? '-' }}
                        </span>

                        <span class="inline-flex items-center gap-2 rounded-xl bg-cyan-50 px-3 py-2 text-xs font-bold text-cyan-700">
                            <span>📚</span>
                            Materi Numerasi
                        </span>
                    </div>


                    {{-- Actions --}}
                    <div class="relative mt-6 flex flex-wrap items-center gap-3 border-t border-slate-100 pt-5">

                        <a href="{{ route('teacher.learning-materials.edit', $material) }}"
                           class="lm-action inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#087cf0] to-[#12b5ed] px-5 py-2.5 text-xs font-bold text-white shadow-md shadow-blue-100 hover:shadow-lg">
                            <span>✎</span>
                            Edit Materi
                        </a>

                        @if($material->status !== 'published')
                            <form method="POST" action="{{ route('teacher.learning-materials.publish', $material) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="lm-action inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-5 py-2.5 text-xs font-bold text-emerald-700 hover:bg-emerald-100">
                                    <span>✓</span>
                                    Publikasikan
                                </button>
                            </form>
                        @else
                            <span class="inline-flex items-center gap-2 text-xs font-semibold text-emerald-600">
                                <span>✓</span>
                                Materi sudah tersedia
                            </span>
                        @endif

                    </div>

                </article>

            @empty

                <div class="col-span-full overflow-hidden rounded-[28px] border border-white bg-white/90 p-10 text-center shadow-[0_12px_35px_rgba(38,105,160,0.07)]">

                    <div class="lm-float mx-auto flex h-24 w-24 items-center justify-center rounded-[30px] bg-gradient-to-br from-blue-100 to-cyan-100 text-5xl">
                        📚
                    </div>

                    <h3 class="mt-6 text-xl font-extrabold text-slate-800">
                        Belum Ada Materi
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                        Belum ada materi untuk kelas yang ditugaskan kepada Anda. Mulai dengan menambahkan materi pembelajaran baru.
                    </p>

                    <a href="{{ route('teacher.learning-materials.create') }}"
                       class="lm-action mt-6 inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#087cf0] to-[#12b5ed] px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-100">
                        <span>＋</span>
                        Tambah Materi
                    </a>

                </div>

            @endforelse

        </div>


        {{-- Pagination --}}
        @if($materials->hasPages())
            <div class="rounded-2xl border border-white bg-white/80 p-5 shadow-sm">
                {{ $materials->links() }}
            </div>
        @endif

    </section>

</div>

@endsection
