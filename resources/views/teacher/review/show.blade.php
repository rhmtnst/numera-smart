
@extends('layouts.teacher')

@section('title', 'Detail Review Soal')

@section('content')

<style>
    .review-card {
        border: 1px solid #e8eef6;
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 8px 28px rgba(31, 65, 105, .045);
    }

    .review-section {
        border: 1px solid #e9eff6;
        border-radius: 17px;
        background: #fff;
        padding: 20px;
    }

    .review-label {
        color: #8b9bb0;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .review-option {
        display: flex;
        align-items: flex-start;
        gap: 13px;
        border: 1px solid #e7edf5;
        border-radius: 15px;
        background: #fbfdff;
        padding: 16px;
        transition: .2s ease;
    }

    .review-option:hover {
        border-color: #bfdbfe;
        transform: translateY(-1px);
    }

    .review-option-correct {
        border-color: #a7e8c5;
        background: linear-gradient(120deg, #f0fdf4, #f5fffa);
    }

    .review-option-letter {
        display: flex;
        width: 36px;
        height: 36px;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #edf4fc;
        color: #3478bd;
        font-weight: 800;
    }

    .review-option-correct .review-option-letter {
        background: #d1fae5;
        color: #07834d;
    }

    .review-action {
        border: 1px solid #e8eef6;
        border-radius: 18px;
        background: #fff;
        padding: 20px;
    }

    .review-field {
        width: 100%;
        border: 1px solid #dce5ef;
        border-radius: 14px;
        background: #f9fbfe;
        padding: 14px 16px;
        color: #34465e;
        outline: none;
        transition: .2s ease;
    }

    .review-field:focus {
        border-color: #2798ed;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(39, 152, 237, .12);
    }

    .review-float {
        animation: reviewFloat 4s ease-in-out infinite;
    }

    .review-float-delay {
        animation: reviewFloat 5s ease-in-out infinite;
        animation-delay: .8s;
    }

    @keyframes reviewFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    @media (prefers-reduced-motion: reduce) {
        .review-float,
        .review-float-delay {
            animation: none;
        }

        .review-option {
            transition: none;
        }
    }

    @media (max-width: 640px) {
        .review-section,
        .review-action {
            padding: 16px;
        }
    }
</style>

<div class="space-y-7">

    {{-- NAVIGASI --}}
  <a href="{{ route('teacher.review.topic', $question->topic_id) }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 transition hover:gap-3 hover:text-blue-800">
        <span>←</span>
        Kembali ke Review Soal
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
                    <span>REVIEW SOAL</span>
                    <span class="text-white/60">/</span>
                    <span>DETAIL</span>
                </div>

                <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                    Pemeriksaan Soal
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-relaxed text-white/85 sm:text-base">
                    Periksa kualitas pertanyaan, pilihan jawaban, kunci jawaban, dan pembahasan sebelum soal digunakan dalam pembelajaran.
                </p>
            </div>

            <div class="review-float hidden h-36 w-36 items-center justify-center rounded-[30px] border border-white/20 bg-white/15 shadow-lg backdrop-blur-sm md:flex">
                <svg viewBox="0 0 150 150" class="h-32 w-32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="32" y="20" width="82" height="108" rx="13" fill="white" fill-opacity=".95"/>
                    <rect x="45" y="38" width="53" height="7" rx="3.5" fill="#B7DDFB"/>
                    <rect x="45" y="55" width="42" height="5" rx="2.5" fill="#D3E8F9"/>
                    <rect x="45" y="69" width="53" height="5" rx="2.5" fill="#D3E8F9"/>
                    <rect x="45" y="83" width="34" height="5" rx="2.5" fill="#D3E8F9"/>
                    <circle cx="100" cy="103" r="22" fill="#D1FAE5"/>
                    <path d="M89 103L97 111L112 94" stroke="#07975A" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M27 43L20 43" stroke="white" stroke-width="4" stroke-linecap="round"/>
                    <path d="M120 36L126 30" stroke="white" stroke-width="4" stroke-linecap="round"/>
                    <path d="M123 63L132 63" stroke="white" stroke-width="4" stroke-linecap="round"/>
                    <path d="M27 111L20 117" stroke="white" stroke-width="4" stroke-linecap="round"/>
                </svg>
            </div>

        </div>
    </section>

    {{-- STATUS DAN INFORMASI --}}
    <section class="review-card p-5 sm:p-7">

        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="review-label">Status pemeriksaan</p>
                <h2 class="mt-1 text-lg font-bold text-gray-800">Informasi Soal</h2>
            </div>

            <div class="flex flex-wrap gap-2">
                <span class="rounded-full border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700">
                    {{ ucfirst(str_replace('_', ' ', $question->review_status)) }}
                </span>

                <span class="rounded-full bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-700">
                    {{ ucfirst($question->difficulty) }}
                </span>

                <span class="rounded-full bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-600">
                    {{ ucfirst(str_replace('_', ' ', $question->question_type)) }}
                </span>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">

            <div class="rounded-2xl bg-blue-50/70 p-4">
                <p class="review-label">Topik</p>
                <p class="mt-2 font-bold text-gray-800">
                    {{ $question->topic?->title ?? 'Tidak tersedia' }}
                </p>
            </div>

            <div class="rounded-2xl bg-cyan-50/70 p-4">
                <p class="review-label">Kelas</p>
                <p class="mt-2 font-bold text-gray-800">
                    {{ $question->topic?->grade_level ?? '-' }}
                </p>
            </div>

            <div class="rounded-2xl bg-emerald-50/70 p-4">
                <p class="review-label">Poin</p>
                <p class="mt-2 font-bold text-gray-800">
                    {{ $question->points }}
                    <span class="text-xs font-medium text-gray-400">poin</span>
                </p>
            </div>

        </div>
    </section>

    {{-- DETAIL ISI SOAL --}}
    <section class="review-card space-y-6 p-5 sm:p-7">

        <div class="flex items-center gap-3 border-b border-gray-100 pb-5">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-50 text-xl">
                📋
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-800">Konten Soal</h2>
                <p class="text-xs text-gray-500">Tinjau seluruh komponen sebelum mengambil keputusan.</p>
            </div>
        </div>

        {{-- STIMULUS --}}
        <div class="review-section">
            <div class="mb-3 flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-100 text-xs font-extrabold text-indigo-700">01</span>
                <h3 class="font-bold text-gray-800">Stimulus Soal</h3>
            </div>

            <div class="rounded-xl bg-indigo-50/80 p-5 text-sm leading-7 text-gray-700">
                {{ $question->stimulus ?: 'Tidak ada stimulus tambahan.' }}
            </div>
        </div>

        {{-- PERTANYAAN --}}
        <div class="review-section">
            <div class="mb-3 flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-100 text-xs font-extrabold text-blue-700">02</span>
                <h3 class="font-bold text-gray-800">Pertanyaan</h3>
            </div>

            <div class="rounded-xl bg-blue-50/70 p-5 text-sm leading-7 text-gray-700">
                {{ $question->question_text }}
            </div>
        </div>

        {{-- PILIHAN JAWABAN --}}
        <div class="review-section">
            <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-violet-100 text-xs font-extrabold text-violet-700">03</span>
                    <h3 class="font-bold text-gray-800">Pilihan Jawaban</h3>
                </div>

                <span class="text-xs text-gray-400">Jawaban yang benar ditandai hijau</span>
            </div>

            <div class="space-y-3">
                @forelse ($question->options as $option)

                    <div class="review-option {{ $option->is_correct ? 'review-option-correct' : '' }}">

                        <span class="review-option-letter">
                            {{ $option->option_label }}
                        </span>

                        <div class="min-w-0 flex-1 pt-1">
                            <p class="text-sm leading-relaxed text-gray-700">
                                {{ $option->option_text }}
                            </p>
                        </div>

                        @if ($option->is_correct)
                            <span class="inline-flex shrink-0 items-center gap-1 rounded-full bg-green-100 px-3 py-1.5 text-[10px] font-extrabold text-green-700 sm:text-xs">
                                <span>✓</span>
                                <span>Kunci Jawaban</span>
                            </span>
                        @endif

                    </div>

                @empty

                    <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-600">
                        Belum ada pilihan jawaban.
                    </div>

                @endforelse
            </div>
        </div>

        {{-- KUNCI JAWABAN --}}
        <div class="review-section">
            <div class="mb-3 flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-100 text-xs font-extrabold text-green-700">04</span>
                <h3 class="font-bold text-gray-800">Kunci Jawaban</h3>
            </div>

            <div class="flex items-center gap-4 rounded-xl border border-green-200 bg-gradient-to-r from-green-50 to-emerald-50 p-5">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-green-100 text-xl font-extrabold text-green-700">
                    {{ $question->correct_answer ?? '?' }}
                </div>
                <div>
                    <p class="text-xs font-semibold text-green-700">Jawaban yang benar</p>
                    <p class="mt-1 text-sm font-bold text-green-800">
                        {{ $question->correct_answer ?? 'Belum ditentukan' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- PEMBAHASAN --}}
        <div class="review-section">
            <div class="mb-3 flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-amber-100 text-xs font-extrabold text-amber-700">05</span>
                <h3 class="font-bold text-gray-800">Pembahasan</h3>
            </div>

            <div class="rounded-xl bg-amber-50/70 p-5 text-sm leading-7 text-gray-700">
                {{ $question->explanation ?: 'Belum ada pembahasan.' }}
            </div>
        </div>

    </section>

    {{-- KEPUTUSAN GURU --}}
    @if ($question->review_status === 'draft')

        <section class="review-card overflow-hidden">

            <div class="bg-gradient-to-r from-[#eff7ff] to-[#effcf7] p-5 sm:p-7">
                <div class="flex items-start gap-4">
                    <div class="review-float flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white text-2xl shadow-sm">
                        ⚖️
                    </div>
                    <div>
                        <h2 class="text-xl font-extrabold text-gray-800">
                            Keputusan Pemeriksaan
                        </h2>
                        <p class="mt-2 max-w-2xl text-sm leading-relaxed text-gray-500">
                            Setujui soal jika sudah layak digunakan atau minta revisi jika masih terdapat kekurangan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="space-y-6 p-5 sm:p-7">

                {{-- SETUJUI --}}
                <div class="review-action">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-100 text-lg">
                            ✓
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Setujui Soal</h3>
                            <p class="text-xs text-gray-500">Soal dinilai sudah layak digunakan.</p>
                        </div>
                    </div>

                    <form
                        action="{{ route('teacher.review.approve', $question) }}"
                        method="POST"
                        onsubmit="return confirm('Apakah kamu yakin ingin menyetujui soal ini?')"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-green-600 to-emerald-500 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-green-500/15 transition hover:-translate-y-0.5 hover:shadow-xl sm:w-auto"
                        >
                            <span>✓</span>
                            Setujui Soal
                        </button>
                    </form>
                </div>

                <div class="flex items-center gap-3">
                    <div class="h-px flex-1 bg-gray-100"></div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Atau</span>
                    <div class="h-px flex-1 bg-gray-100"></div>
                </div>

                {{-- MINTA REVISI --}}
                <div class="review-action">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-lg">
                            ↻
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Minta Revisi</h3>
                            <p class="text-xs text-gray-500">Berikan catatan agar pembuat soal dapat memperbaikinya.</p>
                        </div>
                    </div>

                    <form
                        action="{{ route('teacher.review.revision', $question) }}"
                        method="POST"
                        class="space-y-4"
                    >
                        @csrf

                        <div>
                            <label class="mb-2 block text-sm font-bold text-gray-700">
                                Catatan Revisi <span class="text-red-500">*</span>
                            </label>

                            <textarea
                                name="review_notes"
                                rows="5"
                                required
                                minlength="10"
                                maxlength="2000"
                                placeholder="Tuliskan bagian yang harus diperbaiki dan alasan revisinya..."
                                class="review-field resize-y text-sm"
                            >{{ old('review_notes') }}</textarea>

                            @error('review_notes')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror

                            <p class="mt-2 text-xs text-gray-400">
                                Minimal 10 karakter dan maksimal 2.000 karakter.
                            </p>
                        </div>

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-amber-500/15 transition hover:-translate-y-0.5 hover:shadow-xl sm:w-auto"
                            onclick="return confirm('Kirim permintaan revisi untuk soal ini?')"
                        >
                            <span>↻</span>
                            Minta Revisi
                        </button>
                    </form>
                </div>

            </div>
        </section>

    @elseif ($question->review_status === 'approved')

        <section class="overflow-hidden rounded-2xl border border-green-200 bg-gradient-to-r from-green-50 to-emerald-50 p-6">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-green-100 text-2xl">
                    ✓
                </div>
                <div>
                    <h2 class="font-extrabold text-green-800">Soal Telah Disetujui</h2>
                    <p class="mt-1 text-sm text-green-700">
                        Soal ini sudah disetujui dan dinyatakan layak digunakan.
                    </p>
                </div>
            </div>
        </section>

    @elseif ($question->review_status === 'revision_requested')

        <section class="overflow-hidden rounded-2xl border border-amber-200 bg-gradient-to-r from-amber-50 to-orange-50 p-6">
            <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-100 text-2xl">
                    ⚠️
                </div>
                <div class="min-w-0">
                    <h2 class="font-extrabold text-amber-900">Soal Memerlukan Revisi</h2>
                    <p class="mt-1 text-sm text-amber-700">
                        Soal ini perlu diperbaiki berdasarkan catatan pemeriksaan berikut.
                    </p>

                    <div class="mt-4 rounded-xl border border-amber-200/80 bg-white/70 p-4">
                        <p class="mb-2 text-xs font-extrabold uppercase tracking-wider text-amber-700">
                            Catatan Revisi
                        </p>
                        <p class="text-sm leading-relaxed text-amber-900">
                            {{ $question->review_notes }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

    @endif

</div>

@endsection
