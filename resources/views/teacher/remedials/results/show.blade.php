
@extends('layouts.teacher')

@section('title', 'Detail Hasil Remediasi')

@section('content')

<section class="space-y-6">

    {{-- HERO --}}
    <div class="relative overflow-hidden rounded-[28px] bg-gradient-to-r from-[#087cf0] via-[#12afe9] to-[#35d99a] p-6 text-white shadow-lg sm:p-8">
        <div class="relative z-10">
            <a href="{{ route('teacher.remedials.results.index', $remedial) }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-white/85 transition hover:text-white">
                <span>←</span> Kembali ke Hasil Remediasi
            </a>

            <div class="mt-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/15 px-3 py-1.5 text-xs font-semibold backdrop-blur">
                <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                DETAIL HASIL REMEDIASI
            </div>

            <h1 class="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">
                {{ $attempt->student->name }}
            </h1>

            <p class="mt-3 text-sm leading-6 text-white/85 sm:text-base">
                Evaluasi hasil latihan remediasi dan tinjau perkembangan pemahaman siswa.
            </p>

            <div class="mt-5 flex flex-wrap gap-3">
                <span class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/15 px-4 py-2.5 text-sm backdrop-blur">
                    <span>📚</span>
                    {{ $remedial->title }}
                </span>

                <span class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/15 px-4 py-2.5 text-sm backdrop-blur">
                    <span>🎓</span>
                    Kelas: {{ $attempt->student->studentProfile->grade_level ?? '-' }}
                </span>
            </div>
        </div>

        <div class="pointer-events-none absolute -right-12 -top-16 h-56 w-56 rounded-full bg-white/10 blur-2xl"></div>
        <div class="pointer-events-none absolute -bottom-20 right-1/3 h-48 w-48 rounded-full bg-emerald-300/20 blur-3xl"></div>

        <div class="pointer-events-none absolute bottom-4 right-8 hidden opacity-25 lg:block">
            <svg class="h-36 w-36 animate-[detailFloat_4s_ease-in-out_infinite]"
                 viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="80" cy="80" r="60" fill="white" fill-opacity=".2"/>
                <circle cx="80" cy="80" r="43" fill="white"/>
                <path d="M55 81L72 98L108 61" stroke="#12B981" stroke-width="11" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="124" cy="38" r="11" fill="#A7F3D0"/>
                <circle cx="35" cy="119" r="8" fill="#A7F3D0"/>
            </svg>
        </div>
    </div>

    {{-- PERHITUNGAN NILAI --}}
    @php
        $correct = $attempt->answers->where('is_correct', true)->count();
        $wrong = $attempt->answers->where('is_correct', false)->count();
    @endphp

    {{-- RINGKASAN NILAI --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

        <div class="group relative overflow-hidden rounded-[22px] border border-blue-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500">Nilai Akhir</p>
                    <h2 class="mt-3 text-4xl font-extrabold tabular-nums text-blue-600">
                        {{ number_format((float) $attempt->score, 0) }}
                    </h2>
                    <p class="mt-2 text-xs text-slate-400">Hasil akhir pengerjaan</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-2xl">📊</div>
            </div>
            <div class="absolute -bottom-8 -right-8 h-24 w-24 rounded-full bg-blue-50/80"></div>
        </div>

        <div class="group relative overflow-hidden rounded-[22px] border border-emerald-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500">Jawaban Benar</p>
                    <h2 class="mt-3 text-4xl font-extrabold tabular-nums text-emerald-600">
                        {{ $correct }}
                    </h2>
                    <p class="mt-2 text-xs text-slate-400">Soal dijawab dengan benar</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-2xl">✓</div>
            </div>
            <div class="absolute -bottom-8 -right-8 h-24 w-24 rounded-full bg-emerald-50/80"></div>
        </div>

        <div class="group relative overflow-hidden rounded-[22px] border border-red-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500">Jawaban Salah</p>
                    <h2 class="mt-3 text-4xl font-extrabold tabular-nums text-red-500">
                        {{ $wrong }}
                    </h2>
                    <p class="mt-2 text-xs text-slate-400">Soal yang perlu dipelajari kembali</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-2xl">✕</div>
            </div>
            <div class="absolute -bottom-8 -right-8 h-24 w-24 rounded-full bg-red-50/80"></div>
        </div>

    </div>

    {{-- PERBANDINGAN ASESMEN AWAL DAN HASIL REMEDIASI --}}
    <section class="rounded-[24px] border border-indigo-100 bg-white p-5 shadow-sm sm:p-6">
        <div class="mb-4">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-indigo-500">
                Evaluasi Perkembangan
            </p>
            <h2 class="mt-1 text-xl font-extrabold text-slate-800">
                Perbandingan Sebelum dan Sesudah Remediasi
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Perbandingan menggunakan asesmen awal siswa pada topik yang sama.
            </p>
        </div>

        @if($baselineAttempt && $scoreBefore !== null && $scoreAfter !== null)
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-xs font-semibold text-slate-500">Nilai asesmen awal</p>
                    <p class="mt-2 text-3xl font-black tabular-nums text-slate-700">
                        {{ number_format($scoreBefore, 0) }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">
                        {{ $baselineAttempt->completed_at?->format('d M Y, H:i') ?? 'Tanggal tidak tersedia' }}
                    </p>
                </div>
                <div class="rounded-2xl bg-emerald-50 p-4">
                    <p class="text-xs font-semibold text-emerald-700">Nilai setelah remediasi</p>
                    <p class="mt-2 text-3xl font-black tabular-nums text-emerald-700">
                        {{ number_format($scoreAfter, 0) }}
                    </p>
                    <p class="mt-1 text-xs text-emerald-700">
                        {{ $attempt->completed_at?->format('d M Y, H:i') ?? 'Tanggal tidak tersedia' }}
                    </p>
                </div>
            </div>

            <div class="mt-4 rounded-2xl border border-indigo-100 bg-indigo-50/70 p-4">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <span class="text-sm font-bold text-slate-700">Perubahan nilai</span>
                    <span class="text-lg font-black tabular-nums {{ $scoreChange > 0 ? 'text-emerald-700' : ($scoreChange < 0 ? 'text-rose-600' : 'text-slate-700') }}">
                        {{ $scoreChange > 0 ? '+' : '' }}{{ number_format($scoreChange, 2) }} poin
                    </span>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-3">
                    <div>
                        <div class="mb-1 flex justify-between text-[11px] text-slate-500">
                            <span>Asesmen awal</span><span>{{ number_format($scoreBefore, 0) }}%</span>
                        </div>
                        <div class="h-2 overflow-hidden rounded-full bg-white">
                            <div class="h-full rounded-full bg-slate-400" style="width: {{ max(0, min(100, $scoreBefore)) }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-1 flex justify-between text-[11px] text-slate-500">
                            <span>Setelah remediasi</span><span>{{ number_format($scoreAfter, 0) }}%</span>
                        </div>
                        <div class="h-2 overflow-hidden rounded-full bg-white">
                            <div class="h-full rounded-full bg-emerald-500" style="width: {{ max(0, min(100, $scoreAfter)) }}%"></div>
                        </div>
                    </div>
                </div>
                <p class="mt-3 text-xs leading-5 text-slate-600">
                    Sumber pembanding: {{ $baselineSource }}.
                    @if($scoreChange > 0)
                        Nilai meningkat setelah siswa menyelesaikan remediasi.
                    @elseif($scoreChange < 0)
                        Nilai setelah remediasi lebih rendah; guru perlu meninjau kembali kebutuhan belajar siswa.
                    @else
                        Nilai tidak berubah dibandingkan asesmen awal.
                    @endif
                </p>
            </div>
        @else
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-800">
                Belum ditemukan asesmen awal yang dapat dibandingkan untuk siswa dan topik ini.
                Hasil remediasi tetap tersimpan, tetapi peningkatan nilai belum dapat dihitung secara valid.
            </div>
        @endif
    </section>

    {{-- KONTEKS REKOMENDASI GURU --}}
    @if($attempt->recommendation)

        @php
            $stageLabels = [
                'reading' => 'Reading (Membaca)',
                'comprehension' => 'Comprehension (Memahami)',
                'transformation' => 'Transformation (Transformasi)',
                'process_skills' => 'Process Skills (Keterampilan Proses)',
                'encoding' => 'Encoding (Penulisan Jawaban)',
            ];

            $finding = $attempt->recommendation->newmanFinding;
            $stageLabel = $stageLabels[$finding->stage]
                ?? $finding->stage;
        @endphp

        <section class="overflow-hidden rounded-[24px] border border-indigo-100 bg-white shadow-sm">

            <div class="border-b border-indigo-100 bg-gradient-to-r from-indigo-50 to-blue-50 px-6 py-5 sm:px-7">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-100 text-xl">
                        🎯
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-indigo-500">
                            Konteks Rekomendasi Guru
                        </span>
                        <h2 class="mt-1 text-lg font-extrabold text-indigo-950">
                            Dasar Pemberian Remediasi
                        </h2>
                    </div>
                </div>
            </div>

            <div class="grid gap-5 p-6 sm:grid-cols-2 sm:p-7">

                <div class="rounded-2xl border border-indigo-100 bg-indigo-50/50 p-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-indigo-500">
                        Tahap Newman
                    </p>
                    <p class="mt-2 text-base font-extrabold text-indigo-950">
                        {{ $stageLabel }}
                    </p>
                </div>

                <div class="rounded-2xl border border-indigo-100 bg-indigo-50/50 p-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-indigo-500">
                        Materi yang Direkomendasikan
                    </p>
                    <p class="mt-2 text-base font-extrabold text-indigo-950">
                        {{ $attempt->material->title }}
                    </p>
                </div>

                <div class="rounded-2xl border border-indigo-100 bg-indigo-50/50 p-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-indigo-500">
                        Guru Pemberi Rekomendasi
                    </p>
                    <p class="mt-2 text-base font-extrabold text-indigo-950">
                        {{ $attempt->recommendation->recommender->name ?? 'Tidak tersedia' }}
                    </p>
                </div>

                <div class="rounded-2xl border border-indigo-100 bg-indigo-50/50 p-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-indigo-500">
                        Status Rekomendasi
                    </p>
                    <span class="mt-2 inline-flex rounded-full bg-emerald-100 px-3 py-1.5 text-xs font-bold text-emerald-700">
                        {{ $attempt->recommendation->status === 'completed'
                            ? 'Sudah Diselesaikan'
                            : ucfirst($attempt->recommendation->status) }}
                    </span>
                </div>

                <div class="rounded-2xl border border-indigo-100 bg-indigo-50/50 p-5 sm:col-span-2">
                    <p class="text-xs font-bold uppercase tracking-wider text-indigo-500">
                        Alasan Rekomendasi
                    </p>
                    <p class="mt-2 text-sm leading-7 text-indigo-950">
                        {{ $attempt->recommendation->reason }}
                    </p>
                </div>

            </div>
        </section>

    @endif

    {{-- INFORMASI PENGERJAAN --}}
    <section class="rounded-[24px] border border-slate-200 bg-white p-6 shadow-sm sm:p-7">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-xl">
                🕒
            </div>
            <div>
                <h2 class="text-lg font-extrabold text-slate-800">Informasi Pengerjaan</h2>
                <p class="mt-0.5 text-sm text-slate-500">Waktu penyelesaian latihan remediasi.</p>
            </div>
        </div>

        <div class="mt-5 rounded-xl bg-slate-50 p-4">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                Waktu Selesai
            </p>
            <p class="mt-2 font-bold text-slate-700">
                {{ $attempt->completed_at?->format('d M Y, H:i') ?? '-' }}
            </p>
        </div>
    </section>

    {{-- DETAIL JAWABAN --}}
    <section class="overflow-hidden rounded-[24px] border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-100 p-6 sm:p-7">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-xl">
                    📋
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-800">
                        Detail Jawaban Siswa
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Periksa jawaban dan pembahasan setiap soal.
                    </p>
                </div>
            </div>
        </div>

        <div class="space-y-5 p-6 sm:p-7">

            @forelse($attempt->answers as $index => $answer)

                <article class="overflow-hidden rounded-2xl border {{ $answer->is_correct ? 'border-emerald-200' : 'border-red-200' }}">

                    {{-- HEADER SOAL --}}
                    <div class="flex flex-wrap items-center justify-between gap-3 {{ $answer->is_correct ? 'bg-emerald-50/70' : 'bg-red-50/70' }} px-5 py-4">
                        <div class="flex items-center gap-3">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-sm font-extrabold text-slate-700 shadow-sm">
                                {{ $index + 1 }}
                            </span>
                            <h3 class="font-extrabold text-slate-800">
                                Soal {{ $index + 1 }}
                            </h3>
                        </div>

                        @if($answer->is_correct)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1.5 text-xs font-bold text-emerald-700">
                                <span>✓</span> Benar
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1.5 text-xs font-bold text-red-700">
                                <span>✕</span> Salah
                            </span>
                        @endif
                    </div>

                    <div class="space-y-5 p-5">

                        {{-- PERTANYAAN --}}
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Pertanyaan
                            </p>
                            <p class="mt-2 text-sm leading-7 text-slate-800">
                                {{ $answer->exercise->question_text }}
                            </p>
                        </div>

                        {{-- JAWABAN SISWA DAN KUNCI --}}
                        <div class="grid gap-4 sm:grid-cols-2">

                            <div class="rounded-xl border {{ $answer->is_correct ? 'border-emerald-100 bg-emerald-50/60' : 'border-red-100 bg-red-50/60' }} p-4">
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Jawaban Siswa
                                </p>
                                <p class="mt-2 break-words text-sm font-bold {{ $answer->is_correct ? 'text-emerald-700' : 'text-red-700' }}">
                                    {{ $answer->answer_text }}
                                </p>
                            </div>

                            <div class="rounded-xl border border-blue-100 bg-blue-50/60 p-4">
                                <p class="text-xs font-bold uppercase tracking-wider text-blue-500">
                                    Jawaban Benar
                                </p>
                                <p class="mt-2 break-words text-sm font-bold text-blue-800">
                                    {{ $answer->exercise->correct_answer }}
                                </p>
                            </div>

                        </div>

                        {{-- PEMBAHASAN --}}
                        @if($answer->exercise->explanation)
                            <div class="rounded-xl border border-cyan-100 bg-cyan-50/60 p-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg">💡</span>
                                    <p class="font-extrabold text-cyan-900">
                                        Pembahasan
                                    </p>
                                </div>

                                <p class="mt-2 text-sm leading-7 text-cyan-800">
                                    {{ $answer->exercise->explanation }}
                                </p>
                            </div>
                        @endif

                    </div>
                </article>

            @empty

                <div class="rounded-2xl bg-slate-50 px-6 py-12 text-center">
                    <div class="text-4xl">📝</div>
                    <h3 class="mt-4 font-extrabold text-slate-800">
                        Belum Ada Detail Jawaban
                    </h3>
                    <p class="mt-2 text-sm text-slate-500">
                        Data jawaban untuk pengerjaan ini belum tersedia.
                    </p>
                </div>

            @endforelse

        </div>
    </section>

</section>

<style>
    @keyframes detailFloat {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-8px);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .animate-\[detailFloat_4s_ease-in-out_infinite\] {
            animation: none !important;
        }
    }
</style>

@endsection
