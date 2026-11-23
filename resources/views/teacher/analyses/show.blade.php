
@extends('layouts.teacher')

@section('title', 'Detail Analisis Siswa')

@section('content')

<style>
    .detail-float {
        animation: detail-float 4s ease-in-out infinite;
    }

    .detail-float-delay {
        animation: detail-float 4.8s ease-in-out infinite;
        animation-delay: .7s;
    }

    .detail-sparkle {
        transform-box: fill-box;
        transform-origin: center;
        animation: detail-sparkle 2.5s ease-in-out infinite;
    }

    .detail-card {
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .detail-card:hover {
        box-shadow: 0 18px 38px rgba(8,126,197,.10);
    }

    .detail-input {
        width: 100%;
        border: 1px solid #dbe7f0;
        border-radius: 14px;
        background: #f8fbff;
        padding: 13px 16px;
        color: #243b53;
        font-size: 14px;
        transition: border-color .2s, box-shadow .2s, background .2s;
    }

    .detail-input:focus {
        outline: none;
        border-color: #0ea5e9;
        background: white;
        box-shadow: 0 0 0 3px rgba(14,165,233,.12);
    }

    .detail-label {
        display: block;
        margin-bottom: 9px;
        color: #334e68;
        font-size: 13px;
        font-weight: 700;
    }

    .detail-section-title {
        color: #123b53;
        font-weight: 800;
        letter-spacing: -.02em;
    }

    @keyframes detail-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    @keyframes detail-sparkle {
        0%, 100% { opacity: .5; transform: scale(.9); }
        50% { opacity: 1; transform: scale(1.12); }
    }

    @media (prefers-reduced-motion: reduce) {
        .detail-float,
        .detail-float-delay,
        .detail-sparkle {
            animation: none !important;
        }
    }
</style>

<div class="relative space-y-8 overflow-hidden">

    {{-- DEKORASI LATAR --}}
    <div class="pointer-events-none absolute -right-24 top-0 h-80 w-80 rounded-full bg-cyan-300/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-24 top-[45rem] h-80 w-80 rounded-full bg-blue-300/15 blur-3xl"></div>


    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="relative flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-5 text-emerald-800 shadow-sm">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-lg">✓</span>
            <div>
                <p class="font-bold">Berhasil</p>
                <p class="mt-1 text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="relative flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 p-5 text-red-800 shadow-sm">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 text-lg">!</span>
            <div>
                <p class="font-bold">Perhatian</p>
                <p class="mt-1 text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif


    {{-- HERO --}}
    <section class="relative overflow-hidden rounded-[30px] border border-white/70 bg-gradient-to-br from-[#087cf0] via-[#12b5ed] to-[#36d99a] p-7 text-white shadow-[0_20px_50px_rgba(13,126,222,0.18)] md:p-9">

        <div class="absolute -right-16 -top-24 h-72 w-72 rounded-full bg-white/15"></div>
        <div class="absolute -bottom-32 right-1/4 h-64 w-64 rounded-full bg-[#075de0]/20"></div>

        <div class="relative z-10 grid items-center gap-7 lg:grid-cols-[1fr_260px]">

            <div>
                <a href="{{ route('teacher.analyses.index') }}"
                   class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/15 px-4 py-2 text-xs font-semibold text-white transition hover:bg-white/25">
                    <span>←</span>
                    Kembali ke Daftar Analisis
                </a>

                <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/15 px-4 py-2 text-xs font-semibold backdrop-blur-md">
                    <span class="h-2 w-2 rounded-full bg-[#a7ffda]"></span>
                    NUMERA SMART · ANALISIS NEWMAN
                </div>

                <h1 class="text-3xl font-extrabold tracking-tight md:text-4xl">
                    Detail Analisis Siswa
                </h1>

                <p class="mt-4 max-w-xl text-sm leading-7 text-white/90 md:text-base">
                    Tinjau jawaban, bukti pengerjaan, dan indikasi kesulitan siswa berdasarkan lima tahapan Newman. Tentukan verifikasi dan tindak lanjut pembelajaran berdasarkan bukti yang tersedia.
                </p>

                <div class="mt-6 inline-flex items-center gap-3 rounded-full border border-white/30 bg-white/15 px-5 py-3 backdrop-blur-md">
                    <span class="text-xl">🔍</span>
                    <span class="text-sm font-semibold">Pemeriksaan dan verifikasi asesmen</span>
                </div>
            </div>

            {{-- ILUSTRASI ANIMASI --}}
            <div class="relative mx-auto hidden h-56 w-full max-w-[260px] lg:block">
                <svg viewBox="0 0 270 220"
                     class="relative z-10 h-full w-full"
                     xmlns="http://www.w3.org/2000/svg"
                     role="img"
                     aria-label="Ilustrasi animasi guru menganalisis jawaban siswa">

                    <circle cx="135" cy="110" r="100" fill="#FFFFFF" fill-opacity=".08"/>

                    <g class="detail-sparkle" fill="#FFF4A8">
                        <path d="M38 43 L43 55 L55 60 L43 65 L38 77 L33 65 L21 60 L33 55 Z"/>
                    </g>

                    <g class="detail-sparkle" fill="#FFFFFF" style="animation-delay:.8s">
                        <path d="M224 34 L228 44 L238 48 L228 52 L224 62 L220 52 L210 48 L220 44 Z"/>
                    </g>

                    <g class="detail-float" transform="translate(43 34) rotate(-5 75 80)">
                        <rect x="5" y="5" width="145" height="155" rx="13" fill="#075CB8"/>
                        <rect x="0" y="0" width="145" height="155" rx="13" fill="#FFFFFF"/>
                        <rect x="16" y="16" width="65" height="9" rx="4" fill="#087CF0"/>
                        <rect x="16" y="34" width="43" height="5" rx="2" fill="#B7DDF0"/>
                        <circle cx="25" cy="59" r="6" fill="#36D99A"/>
                        <path d="M40 59 H122" stroke="#A9D4E9" stroke-width="5" stroke-linecap="round"/>
                        <circle cx="25" cy="84" r="6" fill="#12B5ED"/>
                        <path d="M40 84 H112" stroke="#A9D4E9" stroke-width="5" stroke-linecap="round"/>
                        <circle cx="25" cy="109" r="6" fill="#FFE28A"/>
                        <path d="M40 109 H122" stroke="#A9D4E9" stroke-width="5" stroke-linecap="round"/>
                        <path d="M17 134 H125" stroke="#DCEBF4" stroke-width="4" stroke-linecap="round"/>
                    </g>

                    <g class="detail-float-delay" transform="translate(143 105) rotate(-12)">
                        <circle cx="35" cy="35" r="30" fill="#B9F4FF" fill-opacity=".9" stroke="#FFFFFF" stroke-width="5"/>
                        <circle cx="35" cy="35" r="20" fill="#DFFAFF" fill-opacity=".7"/>
                        <path d="M57 57 L83 83" stroke="#075CB8" stroke-width="13" stroke-linecap="round"/>
                        <path d="M57 57 L83 83" stroke="#36D99A" stroke-width="7" stroke-linecap="round"/>
                    </g>

                    <g class="detail-sparkle" transform="translate(190 148)">
                        <circle cx="20" cy="20" r="19" fill="#36D99A" stroke="#FFFFFF" stroke-width="4"/>
                        <path d="M10 20 L17 27 L30 13" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                </svg>
            </div>

        </div>
    </section>


    {{-- INFORMASI ASESMEN --}}
    <section class="detail-card relative overflow-hidden rounded-[26px] border border-white bg-white/95 p-6 shadow-[0_12px_35px_rgba(38,105,160,0.07)] md:p-7">

        <div class="mb-6 flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 text-xl text-white shadow-lg shadow-blue-100">
                👨‍🎓
            </div>

            <div>
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168bd1]">Profil Peserta</p>
                <h2 class="detail-section-title mt-1 text-xl">Informasi Asesmen</h2>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

            <div class="rounded-2xl bg-blue-50/70 p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Siswa</p>
                <p class="mt-2 text-base font-extrabold text-slate-800">
                    {{ $attempt->student->name }}
                </p>
            </div>

            <div class="rounded-2xl bg-cyan-50/70 p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Kelas</p>
                <p class="mt-2 text-base font-extrabold text-slate-800">
                    Kelas {{ $attempt->student->studentProfile->grade_level ?? '-' }}
                </p>
            </div>

            <div class="rounded-2xl bg-emerald-50/70 p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Topik</p>
                <p class="mt-2 text-base font-extrabold text-slate-800">
                    {{ $attempt->topic->title ?? 'Tidak tersedia' }}
                </p>
            </div>

            <div class="rounded-2xl bg-amber-50/70 p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Tanggal Penyelesaian</p>
                <p class="mt-2 text-base font-extrabold text-slate-800">
                    {{ $attempt->completed_at?->format('d M Y, H:i') ?? '-' }}
                </p>
            </div>

        </div>
    </section>



    {{-- RINGKASAN DIAGNOSIS NEWMAN PER TOPIK --}}
    <section class="detail-card rounded-[26px] border border-indigo-100 bg-white p-6 shadow-sm md:p-7">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-indigo-600">Diagnosis keseluruhan topik</p>
                <h2 class="mt-1 text-xl font-extrabold text-slate-900">Ringkasan Analisis Newman</h2>
                <p class="mt-2 text-sm text-slate-500">Rekap lima tahap dari seluruh jawaban pada asesmen ini. Detail setiap nomor tetap tersedia di bawah.</p>
            </div>
            <span class="rounded-full px-3 py-2 text-xs font-bold {{ $analysisReady ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                {{ $analysisReady ? 'Analisis tersedia' : 'Analisis belum lengkap' }}
            </span>
        </div>

        <div class="mt-6 space-y-5">
            @foreach($newmanSummary as $item)
                <div>
                    <div class="mb-2 flex flex-wrap items-center justify-between gap-2">
                        <span class="text-sm font-bold text-slate-700">{{ $item['label'] }}</span>
                        <span class="text-sm font-extrabold text-slate-800">{{ $item['percentage'] }}%
                            <span class="text-xs font-medium text-slate-400">({{ $item['errors'] }}/{{ $item['assessed'] }} teranalisis)</span>
                        </span>
                    </div>
                    <div class="h-3 overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-emerald-400" style="width: {{ $item['percentage'] }}%"></div>
                    </div>
                    <p class="mt-1 text-xs text-slate-500">
                        Indikasi pada nomor: {{ count($item['question_numbers']) ? implode(', ', $item['question_numbers']) : 'Belum ada' }}.
                        Bukti belum cukup: {{ $item['insufficient'] }}.
                    </p>
                </div>
            @endforeach
        </div>

        @php
            $dominantStage = $newmanSummary->filter(fn($item) => $item['errors'] > 0)
                ->sortByDesc('percentage')->first();
        @endphp
        <div class="mt-6 rounded-2xl border border-blue-100 bg-blue-50 p-4">
            <p class="text-xs font-bold uppercase tracking-wider text-blue-700">Kesimpulan ringkas</p>
            @if($dominantStage)
                <p class="mt-1 text-sm leading-6 text-blue-950">
                    Indikasi kesulitan tertinggi terdapat pada tahap <strong>{{ $dominantStage['label'] }}</strong>
                    ({{ $dominantStage['percentage'] }}%), berdasarkan nomor soal {{ implode(', ', $dominantStage['question_numbers']) ?: '-' }}.
                    Persentase dihitung hanya dari temuan yang memiliki hasil analisis cukup.
                </p>
            @else
                <p class="mt-1 text-sm leading-6 text-blue-950">Belum ada indikasi kesulitan yang dapat disimpulkan dari bukti analisis yang tersedia.</p>
            @endif
        </div>

        @if($topicReview?->reviewed_at)
            <div class="mt-5 rounded-2xl border border-emerald-100 bg-emerald-50 p-4">
                <p class="font-bold text-emerald-900">
                    Keputusan guru:
                    {{ $topicReview->decision === 'confirmed' ? 'Diagnosis topik dikonfirmasi' : 'Perlu perbaikan' }}
                </p>
                <p class="mt-2 whitespace-pre-line text-sm text-emerald-800">{{ $topicReview->teacher_notes }}</p>
                <p class="mt-2 text-xs text-emerald-700">Ditinjau {{ $topicReview->reviewed_at->format('d M Y, H:i') }} oleh {{ $topicReview->reviewer->name ?? 'Guru' }}</p>
            </div>
        @endif

        <form action="{{ route('teacher.analyses.review-topic', $attempt->id) }}" method="POST" class="mt-5 space-y-4 rounded-2xl border border-slate-200 bg-slate-50 p-5">
            @csrf
            <div>
                <label class="detail-label">Keputusan guru untuk topik ini</label>
                <select name="decision" required class="detail-input" {{ !$analysisReady ? 'disabled' : '' }}>
                    <option value="">Pilih keputusan</option>
                    <option value="confirmed" @selected(old('decision', $topicReview->decision ?? '') === 'confirmed')>Konfirmasi diagnosis</option>
                    <option value="needs_revision" @selected(old('decision', $topicReview->decision ?? '') === 'needs_revision')>Perlu perbaikan / pemeriksaan ulang</option>
                </select>
            </div>
            <div>
                <label class="detail-label">Catatan guru</label>
                <textarea name="teacher_notes" rows="3" minlength="10" maxlength="5000" required class="detail-input" placeholder="Tuliskan ringkasan hasil pemeriksaan untuk topik ini..." {{ !$analysisReady ? 'disabled' : '' }}>{{ old('teacher_notes', $topicReview->teacher_notes ?? '') }}</textarea>
            </div>
            <div class="flex flex-wrap items-center justify-between gap-3">
                <p class="text-xs text-slate-500">Cukup satu keputusan untuk satu hasil asesmen topik. Guru tetap dapat membuka bukti setiap nomor di bawah.</p>
                <button type="submit" {{ !$analysisReady ? 'disabled' : '' }} class="rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-bold text-white shadow disabled:cursor-not-allowed disabled:opacity-50">Simpan keputusan topik →</button>
            </div>
        </form>
    </section>

    {{-- HASIL REMEDIASI DAN PERBANDINGAN NILAI TOPIK --}}
    <section class="detail-card rounded-[26px] border border-emerald-100 bg-white p-6 shadow-sm md:p-7">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-emerald-600">Pemantauan tindak lanjut</p>
                <h2 class="mt-1 text-xl font-extrabold text-slate-900">Hasil Remediasi dan Perbandingan Nilai</h2>
                <p class="mt-2 text-sm text-slate-500">
                    Rekap remediasi siswa {{ $attempt->student->name }} untuk topik {{ $attempt->topic->title ?? 'ini' }}.
                    Nilai awal menggunakan asesmen yang sedang ditinjau.
                </p>
            </div>
            <a href="{{ route('teacher.remedials.index') }}"
               class="inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-xs font-bold text-emerald-700 transition hover:bg-emerald-100">
                Buka menu remediasi →
            </a>
        </div>

        <div class="mt-5 rounded-2xl border border-blue-100 bg-blue-50/70 p-4">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <span class="text-sm font-bold text-slate-700">Nilai asesmen awal</span>
                <span class="text-2xl font-black tabular-nums text-blue-700">{{ number_format((float) $attempt->score, 0) }}</span>
            </div>
            <p class="mt-1 text-xs text-slate-500">Selesai {{ $attempt->completed_at?->format('d M Y, H:i') ?? '-' }}</p>
        </div>

        @if($remedialAttempts->isNotEmpty())
            <div class="mt-4 space-y-3">
                @foreach($remedialAttempts as $remedialAttempt)
                    <div class="rounded-2xl border border-slate-200 p-4">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <h3 class="font-extrabold text-slate-800">{{ $remedialAttempt->material->title ?? 'Materi remediasi' }}</h3>
                                <p class="mt-1 text-xs text-slate-500">
                                    Selesai {{ $remedialAttempt->completed_at?->format('d M Y, H:i') ?? '-' }}
                                </p>
                            </div>
                            <a href="{{ route('teacher.remedials.results.show', [$remedialAttempt->material, $remedialAttempt]) }}"
                               class="inline-flex items-center rounded-full bg-emerald-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-emerald-700">
                                Lihat hasil lengkap →
                            </a>
                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-3">
                            <div class="rounded-xl bg-slate-50 p-3">
                                <p class="text-xs font-semibold text-slate-500">Nilai awal</p>
                                <p class="mt-1 text-2xl font-black tabular-nums text-slate-700">{{ number_format($remedialAttempt->comparison_before, 0) }}</p>
                            </div>
                            <div class="rounded-xl bg-emerald-50 p-3">
                                <p class="text-xs font-semibold text-emerald-700">Nilai remedial</p>
                                <p class="mt-1 text-2xl font-black tabular-nums text-emerald-700">{{ number_format($remedialAttempt->comparison_after, 0) }}</p>
                            </div>
                            <div class="rounded-xl bg-indigo-50 p-3">
                                <p class="text-xs font-semibold text-indigo-700">Perubahan nilai</p>
                                <p class="mt-1 text-2xl font-black tabular-nums {{ $remedialAttempt->comparison_change > 0 ? 'text-emerald-700' : ($remedialAttempt->comparison_change < 0 ? 'text-rose-600' : 'text-slate-700') }}">
                                    {{ $remedialAttempt->comparison_change > 0 ? '+' : '' }}{{ number_format($remedialAttempt->comparison_change, 2) }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-3 grid grid-cols-2 gap-3">
                            <div>
                                <div class="mb-1 flex justify-between text-[11px] text-slate-500"><span>Awal</span><span>{{ number_format($remedialAttempt->comparison_before, 0) }}%</span></div>
                                <div class="h-2 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-slate-400" style="width: {{ max(0, min(100, $remedialAttempt->comparison_before)) }}%"></div></div>
                            </div>
                            <div>
                                <div class="mb-1 flex justify-between text-[11px] text-slate-500"><span>Remedial</span><span>{{ number_format($remedialAttempt->comparison_after, 0) }}%</span></div>
                                <div class="h-2 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-emerald-500" style="width: {{ max(0, min(100, $remedialAttempt->comparison_after)) }}%"></div></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-800">
                Belum ada latihan remediasi yang selesai dan terhubung dengan asesmen topik ini. Setelah siswa mengumpulkan latihan remediasi, nilai awal, nilai remedial, dan perubahan nilainya akan tampil di bagian ini.
            </div>
        @endif
    </section>

    {{-- DAFTAR JAWABAN --}}
    @foreach($attempt->answers as $index => $answer)

        <section class="detail-card relative overflow-hidden rounded-[26px] border border-white bg-white/95 shadow-[0_12px_35px_rgba(38,105,160,0.07)]">

            {{-- HEADER SOAL --}}
            <div class="border-b border-slate-100 bg-gradient-to-r from-blue-50/90 via-cyan-50/70 to-emerald-50/70 p-6 md:p-7">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 font-extrabold text-white shadow-lg shadow-blue-100">
                            {{ $index + 1 }}
                        </span>

                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168bd1]">Jawaban dan Analisis</p>
                            <h2 class="detail-section-title mt-1 text-lg">Soal {{ $index + 1 }}</h2>
                        </div>
                    </div>

                    <span class="rounded-full border border-blue-100 bg-white px-4 py-2 text-xs font-bold text-blue-600">
                        Analisis Newman
                    </span>
                </div>

                <p class="mt-5 text-base font-semibold leading-7 text-slate-700">
                    {{ $answer->question->question_text }}
                </p>
            </div>


            <div class="space-y-7 p-6 md:p-7">

                {{-- JAWABAN SISWA --}}
                <div>
                    <div class="mb-4 flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 text-blue-600">✏️</span>
                        <h3 class="detail-section-title text-base">Jawaban Siswa</h3>
                    </div>

                    <div class="space-y-4 rounded-2xl border border-slate-100 bg-slate-50/80 p-5">

                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Pilihan Jawaban</p>
                            <p class="mt-2 text-sm font-bold text-slate-800">
                                {{ $answer->answer_text ?? 'Tidak dijawab' }}
                            </p>
                        </div>

                        <div class="border-t border-slate-200 pt-4">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Langkah Pengerjaan</p>
                            <p class="mt-2 whitespace-pre-line text-sm leading-7 text-slate-700">
                                {{ $answer->working_steps ?? 'Tidak ada langkah pengerjaan.' }}
                            </p>
                        </div>

                        <div class="border-t border-slate-200 pt-4">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Penjelasan Siswa</p>
                            <p class="mt-2 whitespace-pre-line text-sm leading-7 text-slate-700">
                                {{ $answer->student_explanation ?? 'Tidak ada penjelasan.' }}
                            </p>
                        </div>

                    </div>
                </div>


                {{-- HASIL ANALISIS NEWMAN --}}
                <div>
                    <div class="mb-4 flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-cyan-100 text-cyan-700">🧠</span>
                        <div>
                            <h3 class="detail-section-title text-base">Hasil Analisis Newman</h3>
                            <p class="mt-1 text-xs text-slate-400">Temuan sistem berdasarkan tahapan penyelesaian soal.</p>
                        </div>
                    </div>

                    @if($answer->analysis && $answer->analysis->newmanFindings->isNotEmpty())

                        @php
                            $stageLabels = [
                                'reading' => 'Reading (Membaca)',
                                'comprehension' => 'Comprehension (Memahami)',
                                'transformation' => 'Transformation (Transformasi)',
                                'process_skills' => 'Process Skills (Keterampilan Proses)',
                                'encoding' => 'Encoding (Penulisan Jawaban)',
                            ];

                            $statusLabels = [
                                'no_error_indicated' => 'Tidak ditemukan indikasi kesalahan',
                                'error_indicated' => 'Terdapat indikasi kesalahan',
                                'insufficient_evidence' => 'Bukti belum mencukupi',
                            ];

                            $statusColors = [
                                'no_error_indicated' => 'border-emerald-100 bg-emerald-50 text-emerald-700',
                                'error_indicated' => 'border-red-100 bg-red-50 text-red-700',
                                'insufficient_evidence' => 'border-amber-100 bg-amber-50 text-amber-700',
                            ];

                            $stageOrder = [
                                'reading' => 1,
                                'comprehension' => 2,
                                'transformation' => 3,
                                'process_skills' => 4,
                                'encoding' => 5,
                            ];

                            $stageIcons = [
                                'reading' => '📖',
                                'comprehension' => '💡',
                                'transformation' => '🔄',
                                'process_skills' => '🧮',
                                'encoding' => '🎯',
                            ];
                        @endphp

                        <div class="space-y-5">

                            @foreach(
                                $answer->analysis->newmanFindings->sortBy(
                                    fn ($finding) => $stageOrder[$finding->stage] ?? 99
                                ) as $finding
                            )

                                @php
                                    $verificationResponses = $answer->analysis
                                        ->verificationResponses
                                        ->filter(function ($response) use ($finding) {
                                            return $response->verificationQuestion
                                                && $response->verificationQuestion->target_stage === $finding->stage;
                                        });

                                    $existingRecommendations = $finding->remedialRecommendations;

                                    $existingMaterialIds = $existingRecommendations
                                        ->pluck('remedial_material_id')
                                        ->all();

                                    $availableMaterials = $remedialMaterials
                                        ->filter(function ($material) use ($finding) {
                                            return $material->newmanStages->contains(
                                                'stage',
                                                $finding->stage
                                            );
                                        })
                                        ->whereNotIn('id', $existingMaterialIds);

                                    $recommendationStatusLabels = [
                                        'pending' => 'Belum Dikerjakan',
                                        'in_progress' => 'Sedang Dikerjakan',
                                        'completed' => 'Sudah Diselesaikan',
                                    ];

                                    $recommendationStatusColors = [
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'in_progress' => 'bg-blue-100 text-blue-700',
                                        'completed' => 'bg-emerald-100 text-emerald-700',
                                    ];
                                @endphp


                                {{-- KARTU TEMUAN NEWMAN --}}
                                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">

                                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 bg-slate-50/80 p-5">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-blue-100 to-cyan-100 text-xl">
                                                {{ $stageIcons[$finding->stage] ?? '📌' }}
                                            </span>

                                            <div>
                                                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                                    Tahap Newman {{ $stageOrder[$finding->stage] ?? '' }}
                                                </p>
                                                <h4 class="mt-1 font-extrabold text-slate-800">
                                                    {{ $stageLabels[$finding->stage] ?? ucfirst($finding->stage) }}
                                                </h4>
                                            </div>
                                        </div>

                                        <span class="inline-flex rounded-full border px-3 py-2 text-xs font-bold {{ $statusColors[$finding->finding_status] ?? 'border-slate-200 bg-slate-100 text-slate-700' }}">
                                            {{ $statusLabels[$finding->finding_status] ?? $finding->finding_status }}
                                        </span>
                                    </div>


                                    <div class="space-y-5 p-5">

                                        {{-- BUKTI --}}
                                        <div>
                                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Bukti</p>
                                            <p class="mt-2 whitespace-pre-line text-sm leading-7 text-slate-700">
                                                {{ $finding->evidence ?? 'Belum tersedia bukti yang cukup.' }}
                                            </p>
                                        </div>

                                        {{-- KETERANGAN --}}
                                        <div>
                                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Keterangan Analisis</p>
                                            <p class="mt-2 whitespace-pre-line text-sm leading-7 text-slate-600">
                                                {{ $finding->reason ?? '-' }}
                                            </p>
                                        </div>


                                        {{-- BUKTI VERIFIKASI SISWA --}}
                                        @if($verificationResponses->isNotEmpty())
                                            <div class="rounded-2xl border border-blue-100 bg-blue-50/70 p-5">

                                                <div class="flex items-center gap-3">
                                                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 text-blue-700">💬</span>
                                                    <div>
                                                        <h5 class="font-bold text-blue-900">Bukti Verifikasi Siswa</h5>
                                                        <p class="mt-1 text-xs text-blue-700">Respons siswa sebagai bukti tambahan untuk ditinjau guru.</p>
                                                    </div>
                                                </div>

                                                <div class="mt-4 space-y-3">
                                                    @foreach($verificationResponses as $response)
                                                        <div class="rounded-xl border border-blue-100 bg-white p-4">

                                                            <p class="text-sm font-bold leading-6 text-slate-700">
                                                                {{ $response->verificationQuestion->question_text }}
                                                            </p>

                                                            <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-800">
                                                                {{ $response->response_text ?? 'Tidak ada jawaban.' }}
                                                            </p>

                                                            <p class="mt-3 text-xs text-slate-500">
                                                                Dijawab: {{ $response->answered_at?->format('d M Y, H:i') ?? '-' }}
                                                            </p>

                                                            <div class="mt-3 rounded-lg bg-blue-50 p-3">
                                                                <p class="text-[11px] font-bold uppercase tracking-wider text-blue-700">Panduan Interpretasi</p>
                                                                <p class="mt-1 text-xs leading-5 text-blue-800">
                                                                    {{ $response->verificationQuestion->interpretation_guide ?? 'Belum tersedia.' }}
                                                                </p>
                                                            </div>

                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif


                                        {{-- Validasi tahap dilakukan sekaligus melalui ringkasan diagnosis topik. --}}
                                        {{-- REKOMENDASI REMEDIASI --}}
                                        <div class="border-t border-slate-100 pt-5">

                                            <div class="flex items-center gap-3">
                                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">💡</span>
                                                <div>
                                                    <h4 class="font-extrabold text-slate-800">Rekomendasi Remediasi</h4>
                                                    <p class="mt-1 text-xs text-slate-400">Materi pembelajaran berdasarkan temuan kesulitan ini.</p>
                                                </div>
                                            </div>


                                            {{-- REKOMENDASI YANG SUDAH DIBERIKAN --}}
                                            @if($existingRecommendations->isNotEmpty())

                                                <div class="mt-4 space-y-3">

                                                    @foreach($existingRecommendations as $recommendation)

                                                        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-5">

                                                            <div class="flex flex-wrap items-start justify-between gap-3">
                                                                <p class="font-bold text-emerald-900">
                                                                    {{ $recommendation->remedialMaterial->title ?? 'Materi tidak tersedia' }}
                                                                </p>

                                                                <span class="rounded-full px-3 py-1.5 text-xs font-bold {{ $recommendationStatusColors[$recommendation->status] ?? 'bg-gray-100 text-gray-700' }}">
                                                                    {{ $recommendationStatusLabels[$recommendation->status] ?? ucfirst($recommendation->status) }}
                                                                </span>
                                                            </div>

                                                            <p class="mt-3 text-sm leading-6 text-slate-600">
                                                                {{ $recommendation->reason }}
                                                            </p>

                                                            <p class="mt-3 text-xs text-slate-500">
                                                                Direkomendasikan oleh: {{ $recommendation->recommender->name ?? 'Guru' }}
                                                            </p>

                                                            <p class="mt-1 text-xs text-slate-500">
                                                                {{ $recommendation->recommended_at?->format('d M Y, H:i') }}
                                                            </p>

                                                        </div>

                                                    @endforeach

                                                </div>

                                            @endif


                                            {{-- RIWAYAT PENGERJAAN REMEDIASI --}}
                                            @if($existingRecommendations->isNotEmpty())

                                                @foreach($existingRecommendations as $recommendation)

                                                    @php
                                                        $history = $recommendation->remedialAttempts;
                                                    @endphp

                                                    <div class="mt-4 rounded-2xl border border-blue-100 bg-blue-50/70 p-5">

                                                        <div class="flex items-center gap-3">
                                                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-100 text-blue-700">📚</span>
                                                            <h5 class="font-bold text-blue-900">Riwayat Pengerjaan Siswa</h5>
                                                        </div>

                                                        @if($history->isNotEmpty())

                                                            <p class="mt-2 text-sm text-blue-700">
                                                                Total pengerjaan: {{ $history->count() }} kali
                                                            </p>

                                                            <div class="mt-4 space-y-3">

                                                                @foreach($history as $historyIndex => $historyAttempt)

                                                                    <div class="rounded-xl border border-blue-100 bg-white p-4">

                                                                        <div class="flex flex-wrap items-center justify-between gap-2">
                                                                            <p class="font-bold text-slate-800">
                                                                                Percobaan {{ $historyIndex + 1 }}
                                                                            </p>

                                                                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">
                                                                                {{ ucfirst(str_replace('_', ' ', $historyAttempt->status)) }}
                                                                            </span>
                                                                        </div>

                                                                        @if($historyAttempt->status === 'completed')

                                                                            <div class="mt-4 grid grid-cols-2 gap-3 md:grid-cols-4">

                                                                                <div class="rounded-xl bg-emerald-50 p-3">
                                                                                    <p class="text-xs text-slate-500">Nilai</p>
                                                                                    <p class="mt-1 text-xl font-extrabold text-emerald-600">
                                                                                        {{ $historyAttempt->score }}
                                                                                    </p>
                                                                                </div>

                                                                                <div class="rounded-xl bg-blue-50 p-3">
                                                                                    <p class="text-xs text-slate-500">Total Soal</p>
                                                                                    <p class="mt-1 text-xl font-extrabold text-slate-800">
                                                                                        {{ $historyAttempt->answers_count }}
                                                                                    </p>
                                                                                </div>

                                                                                <div class="rounded-xl bg-emerald-50 p-3">
                                                                                    <p class="text-xs text-slate-500">Benar</p>
                                                                                    <p class="mt-1 text-xl font-extrabold text-emerald-600">
                                                                                        {{ $historyAttempt->correct_answers_count }}
                                                                                    </p>
                                                                                </div>

                                                                                <div class="rounded-xl bg-red-50 p-3">
                                                                                    <p class="text-xs text-slate-500">Salah</p>
                                                                                    <p class="mt-1 text-xl font-extrabold text-red-600">
                                                                                        {{ $historyAttempt->wrong_answers_count }}
                                                                                    </p>
                                                                                </div>

                                                                            </div>

                                                                        @endif

                                                                        <div class="mt-4 space-y-1 border-t border-slate-100 pt-3 text-xs text-slate-500">
                                                                            <p>Mulai: {{ $historyAttempt->started_at?->format('d M Y, H:i') ?? '-' }}</p>
                                                                            <p>Selesai: {{ $historyAttempt->completed_at?->format('d M Y, H:i') ?? 'Belum selesai' }}</p>
                                                                        </div>

                                                                    </div>

                                                                @endforeach

                                                            </div>

                                                        @else

                                                            <p class="mt-3 text-sm text-slate-600">
                                                                Siswa belum memiliki riwayat pengerjaan remediasi.
                                                            </p>

                                                        @endif

                                                    </div>

                                                @endforeach

                                            @endif


                                            {{-- FORM REKOMENDASI --}}
                                            @if(
                                                $answer->analysis &&
                                                $topicReview &&
                                                $topicReview->reviewed_at &&
                                                $topicReview->decision === 'confirmed' &&
                                                $answer->analysis->reviewed_at &&
                                                $answer->analysis->review_decision === 'confirmed' &&
                                                $finding->finding_status === 'error_indicated' &&
                                                $finding->reviewed_at &&
                                                $finding->teacher_decision === 'confirmed'
                                            )

                                                @if($availableMaterials->isNotEmpty())

                                                    <form
                                                        action="{{ route('teacher.analyses.recommend', $finding->id) }}"
                                                        method="POST"
                                                        class="mt-5 space-y-4 rounded-2xl border border-emerald-100 bg-emerald-50/50 p-5"
                                                    >
                                                        @csrf

                                                        <div>
                                                            <label class="detail-label">Pilih Materi Remediasi</label>

                                                            <select name="remedial_material_id" required class="detail-input">
                                                                <option value="">Pilih materi yang sesuai</option>

                                                                @foreach($availableMaterials as $material)
                                                                    <option
                                                                        value="{{ $material->id }}"
                                                                        @selected(old('remedial_material_id') == $material->id)
                                                                    >
                                                                        {{ $material->title }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div>
                                                            <label class="detail-label">Alasan Rekomendasi</label>

                                                            <textarea
                                                                name="reason"
                                                                rows="3"
                                                                required
                                                                minlength="10"
                                                                maxlength="3000"
                                                                placeholder="Jelaskan mengapa materi ini sesuai dengan kesulitan siswa..."
                                                                class="detail-input"
                                                            >{{ old('reason') }}</textarea>
                                                        </div>

                                                        <div class="flex justify-end">
                                                            <button type="submit"
                                                                    class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-100 transition hover:-translate-y-0.5 hover:shadow-xl">
                                                                Berikan Rekomendasi
                                                                <span>→</span>
                                                            </button>
                                                        </div>
                                                    </form>

                                                @else

                                                    <p class="mt-4 rounded-xl border border-amber-100 bg-amber-50 p-4 text-sm leading-6 text-amber-700">
                                                        Semua materi yang tersedia sudah direkomendasikan atau belum tersedia materi yang sesuai.
                                                    </p>

                                                @endif

                                            @elseif(
                                                $answer->analysis &&
                                                $topicReview &&
                                                $topicReview->reviewed_at &&
                                                $topicReview->decision === 'confirmed' &&
                                                $finding->finding_status !== 'error_indicated'
                                            )

                                                <p class="mt-4 rounded-xl border border-slate-100 bg-slate-50 p-4 text-sm leading-6 text-slate-600">
                                                    Temuan ini belum menunjukkan indikasi kesalahan yang memenuhi syarat untuk rekomendasi remediasi.
                                                </p>

                                            @else

                                                <p class="mt-4 rounded-xl border border-amber-100 bg-amber-50 p-4 text-sm leading-6 text-amber-700">
                                                    Konfirmasi diagnosis keseluruhan topik pada Ringkasan Analisis Newman di atas untuk membuka rekomendasi remedial.
                                                </p>

                                            @endif

                                        </div>

                                    </div>
                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="rounded-2xl border border-amber-100 bg-amber-50 p-5 text-sm leading-6 text-amber-700">
                            Analisis Newman belum tersedia untuk jawaban ini.
                        </div>

                    @endif
                </div>


                {{-- Verifikasi guru dilakukan satu kali pada ringkasan diagnosis topik di atas. --}}

            </div>
        </section>

    @endforeach


    {{-- CATATAN PENTING --}}
    <section class="relative overflow-hidden rounded-[26px] border border-indigo-100 bg-gradient-to-br from-indigo-50 via-blue-50 to-cyan-50 p-6 md:p-7">

        <div class="flex items-start gap-4">
            <div class="detail-float flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white text-2xl shadow-sm">
                💡
            </div>

            <div>
                <h3 class="text-lg font-extrabold text-indigo-950">
                    Catatan Penting untuk Guru
                </h3>

                <p class="mt-2 text-sm leading-7 text-indigo-900/80">
                    Hasil analisis merupakan indikasi awal berdasarkan jawaban, langkah pengerjaan, dan penjelasan siswa. Hasil ini bukan diagnosis definitif. Guru perlu meninjau bukti yang tersedia dan melakukan verifikasi lebih lanjut sebelum menentukan tindak lanjut pembelajaran.
                </p>
            </div>
        </div>

    </section>

</div>

@endsection
