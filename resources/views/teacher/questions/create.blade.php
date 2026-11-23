
@extends('layouts.teacher')

@section('title', 'Buat Soal Baru')

@section('content')

<style>
    .question-float {
        animation: questionFloat 4s ease-in-out infinite;
    }

    .question-float-delay {
        animation: questionFloat 5s ease-in-out infinite;
        animation-delay: .8s;
    }

    .question-sparkle {
        animation: questionSparkle 2.5s ease-in-out infinite;
        transform-box: fill-box;
        transform-origin: center;
    }

    @keyframes questionFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    @keyframes questionSparkle {
        0%, 100% { opacity: .5; transform: scale(.9) rotate(0deg); }
        50% { opacity: 1; transform: scale(1.15) rotate(12deg); }
    }

    @media (prefers-reduced-motion: reduce) {
        .question-float,
        .question-float-delay,
        .question-sparkle {
            animation: none !important;
        }
    }
</style>

<div class="relative mx-auto max-w-6xl space-y-7 overflow-hidden">

    {{-- DEKORASI --}}
    <div class="pointer-events-none absolute -right-20 top-20 h-64 w-64 rounded-full bg-cyan-200/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-20 top-96 h-64 w-64 rounded-full bg-blue-200/20 blur-3xl"></div>


    {{-- KEMBALI --}}
    <div class="relative z-10">
        <a href="{{ route('teacher.questions.index') }}"
           class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-white px-4 py-2.5 text-sm font-semibold text-blue-600 shadow-sm transition hover:-translate-x-1 hover:shadow-md">
            <span>←</span>
            Kembali ke Bank Soal
        </a>
    </div>


    {{-- HERO --}}
    <section class="relative overflow-hidden rounded-[28px] bg-gradient-to-br from-[#087cf0] via-[#12b5ed] to-[#36d99a] p-7 text-white shadow-[0_18px_45px_rgba(13,126,222,.17)] md:p-9">

        <div class="absolute -right-16 -top-24 h-72 w-72 rounded-full bg-white/15"></div>
        <div class="absolute -bottom-28 right-1/4 h-64 w-64 rounded-full bg-blue-900/10"></div>

        <div class="relative z-10 grid items-center gap-6 lg:grid-cols-[1fr_230px]">

            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/15 px-4 py-2 text-xs font-bold backdrop-blur">
                    <span class="h-2 w-2 rounded-full bg-emerald-200"></span>
                    NUMERA SMART · BANK SOAL
                </div>

                <h1 class="mt-5 text-3xl font-extrabold tracking-tight md:text-4xl">
                    Buat Soal Baru
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-7 text-white/90 md:text-base">
                    Susun soal numerasi yang berkualitas untuk mengukur pemahaman
                    dan kemampuan berpikir siswa.
                </p>

                <div class="mt-6 inline-flex items-center gap-3 rounded-full border border-white/30 bg-white/15 px-5 py-3 text-sm font-semibold backdrop-blur">
                    <span class="text-xl">✏️</span>
                    Ciptakan soal pembelajaran berkualitas
                </div>
            </div>

            {{-- ILUSTRASI ANIMASI --}}
            <div class="mx-auto hidden h-48 w-full max-w-[230px] lg:block">
                <svg viewBox="0 0 240 190"
                     class="h-full w-full"
                     xmlns="http://www.w3.org/2000/svg"
                     role="img"
                     aria-label="Ilustrasi pembuatan soal">

                    <circle cx="120" cy="96" r="85" fill="white" fill-opacity=".10"/>

                    <g class="question-sparkle" fill="#FFF1A8">
                        <path d="M38 25 L43 37 L55 42 L43 47 L38 59 L33 47 L21 42 L33 37 Z"/>
                    </g>

                    <g class="question-sparkle" fill="white" style="animation-delay:.8s">
                        <path d="M199 28 L203 38 L213 42 L203 46 L199 56 L195 46 L185 42 L195 38 Z"/>
                    </g>

                    <g class="question-float" transform="translate(47 30)">
                        <rect x="15" y="10" width="120" height="137" rx="15" fill="#DDF7FF"/>
                        <rect x="25" y="20" width="120" height="137" rx="15" fill="white"/>

                        <rect x="42" y="39" width="65" height="7" rx="3.5" fill="#159DE5"/>
                        <rect x="42" y="57" width="85" height="5" rx="2.5" fill="#B8DCEB"/>
                        <rect x="42" y="70" width="76" height="5" rx="2.5" fill="#B8DCEB"/>
                        <rect x="42" y="91" width="16" height="16" rx="4" fill="#36CFA3"/>
                        <rect x="65" y="96" width="57" height="5" rx="2.5" fill="#B8DCEB"/>
                        <rect x="42" y="116" width="16" height="16" rx="4" fill="#159DE5"/>
                        <rect x="65" y="121" width="57" height="5" rx="2.5" fill="#B8DCEB"/>
                    </g>

                    <g class="question-float-delay" transform="translate(150 111)">
                        <circle cx="25" cy="25" r="22" fill="#FFF1A8"/>
                        <path d="M17 25 L23 31 L34 18" stroke="#D28B00" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </g>
                </svg>
            </div>

        </div>
    </section>


    {{-- PANDUAN --}}
    <div class="relative flex items-start gap-3 rounded-2xl border border-blue-100 bg-blue-50/80 p-5">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-xl shadow-sm">
            💡
        </span>

        <div>
            <p class="font-bold text-blue-900">Panduan Pembuatan Soal</p>
            <p class="mt-1 text-sm leading-6 text-blue-800">
                Lengkapi setiap informasi soal dengan teliti. Pastikan pertanyaan,
                pilihan jawaban, kunci jawaban, dan pembahasan sesuai dengan
                tujuan pembelajaran numerasi.
            </p>
        </div>
    </div>


    {{-- FORM SOAL --}}
    <section class="overflow-hidden rounded-[25px] border border-white bg-white shadow-[0_12px_35px_rgba(38,105,160,.07)]">

        <div class="flex items-center gap-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-cyan-50 p-6">

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 text-xl text-white shadow-lg shadow-blue-100">
                📝
            </div>

            <div>
                <p class="text-[11px] font-bold uppercase tracking-[.16em] text-blue-500">
                    Formulir Soal
                </p>

                <h2 class="mt-1 text-lg font-extrabold text-slate-800">
                    Informasi dan Konten Soal
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Isi semua informasi yang diperlukan sebelum menyimpan soal.
                </p>
            </div>

        </div>

        <div class="p-6 md:p-8">

            <form action="{{ route('teacher.questions.store') }}"
                  method="POST"
                  class="space-y-5">

                @include('teacher.questions._form')

            </form>

        </div>

    </section>


    {{-- FOOTER INFO --}}
    <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-emerald-100 bg-gradient-to-r from-emerald-50 to-cyan-50 p-5">

        <div class="flex items-center gap-3">
            <span class="text-2xl">🌱</span>
            <div>
                <p class="text-sm font-bold text-emerald-900">
                    Soal berkualitas, pembelajaran lebih bermakna
                </p>
                <p class="mt-1 text-xs text-emerald-700">
                    Setiap soal membantu guru memahami perkembangan siswa.
                </p>
            </div>
        </div>

        <span class="rounded-full bg-white px-4 py-2 text-xs font-bold text-emerald-600 shadow-sm">
            NUMERA SMART
        </span>

    </div>

</div>

@endsection
