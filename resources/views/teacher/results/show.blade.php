
@extends('layouts.teacher')

@section('title', 'Detail Hasil Asesmen')

@section('content')

<style>
    .result-card {
        border: 1px solid #e8eef6;
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 8px 28px rgba(31, 65, 105, .045);
    }

    .result-info {
        border: 1px solid #e8eef6;
        border-radius: 17px;
        background: #fbfdff;
        padding: 17px;
        transition: .2s ease;
    }

    .result-info:hover {
        border-color: #bfdbfe;
        transform: translateY(-2px);
    }

    .result-label {
        color: #8b9bb0;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .result-content {
        border: 1px solid #e9eff6;
        border-radius: 16px;
        background: #fbfdff;
        padding: 17px;
    }

    .result-answer {
        border: 1px solid #e7edf5;
        border-radius: 15px;
        background: #f8fafc;
        padding: 17px;
    }

    .result-float {
        animation: resultFloat 4s ease-in-out infinite;
    }

    .result-float-delay {
        animation: resultFloat 5s ease-in-out infinite;
        animation-delay: .8s;
    }

    @keyframes resultFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    @media (prefers-reduced-motion: reduce) {
        .result-float,
        .result-float-delay {
            animation: none;
        }

        .result-info {
            transition: none;
        }
    }

    @media (max-width: 640px) {
        .result-content,
        .result-answer {
            padding: 14px;
        }
    }
</style>

<div class="space-y-7">

    {{-- NAVIGASI --}}
    <a href="{{ route('teacher.results.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 transition hover:gap-3 hover:text-blue-800">
        <span>←</span>
        Kembali ke Hasil Asesmen
    </a>

    {{-- HERO --}}
    <section class="relative overflow-hidden rounded-[26px] bg-gradient-to-br from-[#087cf0] via-[#12afe9] to-[#35d99a] px-6 py-8 text-white shadow-xl shadow-blue-500/10 sm:px-9 sm:py-10">

        <div class="pointer-events-none absolute -right-12 -top-20 h-64 w-64 rounded-full border-[35px] border-white/10"></div>
        <div class="pointer-events-none absolute -bottom-24 right-36 h-56 w-56 rounded-full bg-white/10 blur-2xl"></div>

        <div class="relative z-10 grid items-center gap-6 md:grid-cols-[1fr_auto]">

            <div>
                <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/15 px-3 py-1.5 text-xs font-semibold text-white/95 backdrop-blur">
                    <span>NUMERA SMART</span>
                    <span class="text-white/60">/</span>
                    <span>HASIL ASESMEN</span>
                </div>

                <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                    Detail Pengerjaan Siswa
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-relaxed text-white/85 sm:text-base">
                    Tinjau jawaban, langkah pengerjaan, dan penjelasan siswa untuk memahami proses penyelesaian setiap soal.
                </p>

                <div class="mt-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/15 px-4 py-2 text-xs font-semibold backdrop-blur">
                    <span class="h-2 w-2 rounded-full bg-green-300"></span>
                    Asesmen Selesai
                </div>
            </div>

            <div class="result-float hidden h-36 w-36 items-center justify-center rounded-[30px] border border-white/20 bg-white/15 shadow-lg backdrop-blur-sm md:flex">
                <svg viewBox="0 0 150 150" class="h-32 w-32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="27" y="24" width="83" height="104" rx="13" fill="white" fill-opacity=".95"/>
                    <rect x="42" y="42" width="48" height="6" rx="3" fill="#B7DDFB"/>
                    <rect x="42" y="57" width="55" height="5" rx="2.5" fill="#D3E8F9"/>
                    <rect x="42" y="70" width="42" height="5" rx="2.5" fill="#D3E8F9"/>
                    <rect x="42" y="83" width="52" height="5" rx="2.5" fill="#D3E8F9"/>
                    <circle cx="102" cy="105" r="23" fill="#D1FAE5"/>
                    <path d="M91 105L99 113L114 96" stroke="#07975A" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M23 43L15 43" stroke="white" stroke-width="4" stroke-linecap="round"/>
                    <path d="M119 35L126 28" stroke="white" stroke-width="4" stroke-linecap="round"/>
                    <path d="M124 62L133 62" stroke="white" stroke-width="4" stroke-linecap="round"/>
                    <path d="M23 113L16 120" stroke="white" stroke-width="4" stroke-linecap="round"/>
                </svg>
            </div>

        </div>
    </section>

    {{-- IDENTITAS ASESMEN --}}
    <section class="result-card p-5 sm:p-7">

        <div class="flex items-center gap-3 border-b border-gray-100 pb-5">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-xl">
                👨‍🎓
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800">Informasi Asesmen</h2>
                <p class="text-xs text-gray-500">Identitas siswa dan informasi pengerjaan.</p>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

            <div class="result-info">
                <p class="result-label">Nama Siswa</p>
                <p class="mt-2 font-bold text-gray-800">
                    {{ $attempt->student->name ?? 'Tidak tersedia' }}
                </p>
            </div>

            <div class="result-info">
                <p class="result-label">Kelas</p>
                <p class="mt-2 font-bold text-gray-800">
                    {{ $attempt->student->studentProfile->grade_level ?? '-' }}
                </p>
            </div>

            <div class="result-info">
                <p class="result-label">Tingkat Kelas</p>
                <p class="mt-2 font-bold text-gray-800">
                    {{ $attempt->student->studentProfile->grade_level ?? '-' }}
                </p>
            </div>

            <div class="result-info">
                <p class="result-label">Topik Numerasi</p>
                <p class="mt-2 font-bold text-gray-800">
                    {{ $attempt->topic->title ?? 'Tidak tersedia' }}
                </p>
            </div>

            <div class="result-info">
                <p class="result-label">Tanggal Mulai</p>
                <p class="mt-2 font-bold text-gray-800">
                    {{ $attempt->started_at?->format('d M Y, H:i') ?? '-' }}
                </p>
            </div>

            <div class="result-info">
                <p class="result-label">Tanggal Penyelesaian</p>
                <p class="mt-2 font-bold text-gray-800">
                    {{ $attempt->completed_at?->format('d M Y, H:i') ?? '-' }}
                </p>
            </div>

            <div class="result-info">
                <p class="result-label">Jumlah Soal</p>
                <p class="mt-2 font-bold text-gray-800">
                    {{ $attempt->answers->count() }} soal
                </p>
            </div>

            <div class="result-info">
                <p class="result-label">Status Asesmen</p>
                <div class="mt-2">
                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Selesai
                    </span>
                </div>
            </div>

        </div>
    </section>

    {{-- DETAIL JAWABAN SISWA --}}
    <section class="space-y-5">

        <div class="flex flex-wrap items-end justify-between gap-3">
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-cyan-50 text-xl">
                        📝
                    </div>
                    <div>
                        <h2 class="text-xl font-extrabold text-gray-800">
                            Detail Jawaban Siswa
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Jawaban dan proses pengerjaan untuk setiap soal.
                        </p>
                    </div>
                </div>
            </div>

            <span class="rounded-full bg-blue-50 px-4 py-2 text-xs font-bold text-blue-700">
                {{ $attempt->answers->count() }} Jawaban
            </span>
        </div>

        @forelse ($attempt->answers as $index => $answer)

            <article class="result-card overflow-hidden">

                {{-- HEADER SOAL --}}
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 bg-gradient-to-r from-blue-50/80 to-cyan-50/50 px-5 py-4 sm:px-6">

                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-sm font-extrabold text-blue-700 shadow-sm">
                            {{ $index + 1 }}
                        </div>

                        <div>
                            <h3 class="font-extrabold text-gray-800">
                                Soal {{ $index + 1 }}
                            </h3>
                            <p class="text-xs text-gray-500">
                                Detail jawaban pengerjaan
                            </p>
                        </div>
                    </div>

                    <span class="rounded-full border border-white bg-white/80 px-3 py-1.5 text-xs font-semibold text-gray-500">
                        🕒 {{ $answer->answered_at?->format('d M Y, H:i') ?? 'Waktu tidak tersedia' }}
                    </span>
                </div>

                <div class="space-y-6 p-5 sm:p-6">

                    {{-- STIMULUS --}}
                    @if($answer->question->stimulus)
                        <div>
                            <div class="mb-3 flex items-center gap-2">
                                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-100 text-xs font-extrabold text-indigo-700">
                                    i
                                </span>
                                <h4 class="text-sm font-bold text-gray-800">Informasi Soal</h4>
                            </div>

                            <div class="result-content border-indigo-100 bg-indigo-50/60">
                                <p class="whitespace-pre-line text-sm leading-7 text-gray-700">
                                    {{ $answer->question->stimulus }}
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- PERTANYAAN --}}
                    <div>
                        <div class="mb-3 flex items-center gap-2">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-100 text-xs font-extrabold text-blue-700">
                                ?
                            </span>
                            <h4 class="text-sm font-bold text-gray-800">Pertanyaan</h4>
                        </div>

                        <div class="rounded-xl bg-blue-50/60 p-5">
                            <p class="whitespace-pre-line text-sm leading-7 text-gray-800">
                                {{ $answer->question->question_text }}
                            </p>
                        </div>
                    </div>

                    {{-- JAWABAN YANG DIPILIH --}}
                    <div>
                        <div class="mb-3 flex items-center gap-2">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-violet-100 text-xs font-extrabold text-violet-700">
                                A
                            </span>
                            <h4 class="text-sm font-bold text-gray-800">Jawaban yang Dipilih</h4>
                        </div>

                        <div class="result-answer">
                            @if($answer->answer_text)

                                @php
                                    $selectedOption = $answer->question->options
                                        ->firstWhere('option_label', $answer->answer_text);
                                @endphp

                                <div class="flex items-start gap-3">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-violet-100 text-sm font-extrabold text-violet-700">
                                        {{ $answer->answer_text }}
                                    </span>

                                    <div class="min-w-0 pt-1">
                                        <p class="font-bold text-gray-800">
                                            {{ $answer->answer_text }}
                                        </p>

                                        @if($selectedOption)
                                            <p class="mt-1 text-sm leading-relaxed text-gray-600">
                                                {{ $selectedOption->option_text }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                            @else

                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-gray-200 text-gray-500">
                                        —
                                    </span>
                                    <p class="text-sm text-gray-500">
                                        Siswa tidak memberikan jawaban.
                                    </p>
                                </div>

                            @endif
                        </div>
                    </div>

                    {{-- LANGKAH PENGERJAAN --}}
                    <div>
                        <div class="mb-3 flex items-center gap-2">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-cyan-100 text-xs font-extrabold text-cyan-700">
                                02
                            </span>
                            <h4 class="text-sm font-bold text-gray-800">Langkah Pengerjaan</h4>
                        </div>

                        <div class="result-content">
                            <p class="whitespace-pre-line text-sm leading-7 text-gray-700">
                                {{ $answer->working_steps ?: 'Siswa tidak menuliskan langkah pengerjaan.' }}
                            </p>
                        </div>
                    </div>

                    {{-- PENJELASAN SISWA --}}
                    <div>
                        <div class="mb-3 flex items-center gap-2">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-amber-100 text-xs font-extrabold text-amber-700">
                                03
                            </span>
                            <h4 class="text-sm font-bold text-gray-800">Penjelasan Siswa</h4>
                        </div>

                        <div class="result-content border-amber-100 bg-amber-50/40">
                            <p class="whitespace-pre-line text-sm leading-7 text-gray-700">
                                {{ $answer->student_explanation ?: 'Siswa tidak memberikan penjelasan.' }}
                            </p>
                        </div>
                    </div>

                    {{-- STATUS PENILAIAN --}}
                    <div class="border-t border-gray-100 pt-5">

                        <p class="mb-3 text-xs font-extrabold uppercase tracking-wider text-gray-400">
                            Status Penilaian
                        </p>

                        @if($answer->is_correct === null)

                            <div class="flex items-center gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4">
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-lg">
                                    ⏳
                                </span>
                                <div>
                                    <p class="text-sm font-bold text-amber-800">Belum Dinilai</p>
                                    <p class="mt-1 text-xs text-amber-700">Jawaban belum mendapatkan penilaian.</p>
                                </div>
                            </div>

                        @elseif($answer->is_correct)

                            <div class="flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 p-4">
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-100 text-lg">
                                    ✓
                                </span>
                                <div>
                                    <p class="text-sm font-bold text-green-800">Jawaban Benar</p>
                                    <p class="mt-1 text-xs text-green-700">Jawaban siswa dinilai benar.</p>
                                </div>
                            </div>

                        @else

                            <div class="flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-4">
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-100 text-lg">
                                    ✕
                                </span>
                                <div>
                                    <p class="text-sm font-bold text-red-800">Jawaban Salah</p>
                                    <p class="mt-1 text-xs text-red-700">Jawaban siswa dinilai belum tepat.</p>
                                </div>
                            </div>

                        @endif

                    </div>

                </div>
            </article>

        @empty

            <div class="result-card p-10 text-center sm:p-14">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-blue-50 text-4xl">
                    📭
                </div>

                <h3 class="mt-5 text-lg font-extrabold text-gray-800">
                    Belum Ada Jawaban
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-gray-500">
                    Tidak ditemukan data jawaban pada asesmen ini.
                </p>
            </div>

        @endforelse

    </section>

    {{-- INFORMASI DAN ANALISIS NEWMAN --}}
    <section class="relative overflow-hidden rounded-[22px] border border-indigo-100 bg-gradient-to-br from-indigo-50 via-blue-50 to-cyan-50 p-5 sm:p-7">

        <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-blue-200/20 blur-2xl"></div>

        <div class="relative z-10 flex items-start gap-4">
            <div class="result-float-delay flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white text-2xl shadow-sm">
                💡
            </div>

            <div class="min-w-0">
                <h3 class="text-lg font-extrabold text-indigo-950">
                    Informasi Hasil Asesmen
                </h3>

                <p class="mt-2 text-sm leading-7 text-indigo-800">
                    Halaman ini menampilkan data pengerjaan siswa. Status benar atau salah hanya ditampilkan apabila jawaban sudah dinilai oleh sistem atau guru. Analisis kesulitan berdasarkan tahapan Newman tersedia pada menu Analisis Kesulitan.
                </p>

                <div class="mt-5">
                    <a href="{{ route('teacher.analyses.show', $attempt->id) }}"
                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-500/15 transition hover:-translate-y-0.5 hover:shadow-xl">
                        Lihat Analisis Newman
                        <span>→</span>
                    </a>
                </div>
            </div>
        </div>

    </section>

</div>

@endsection
