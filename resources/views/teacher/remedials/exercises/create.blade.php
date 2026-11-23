
@extends('layouts.teacher')

@section('title', 'Tambah Soal Remediasi')

@section('content')
<div class="space-y-6">

    {{-- HERO --}}
    <section class="relative overflow-hidden rounded-[28px] bg-gradient-to-r from-[#087cf0] via-[#12afe9] to-[#35d99a] p-6 text-white shadow-lg sm:p-8">
        <div class="relative z-10 flex flex-col justify-between gap-6 lg:flex-row lg:items-center">
            <div class="max-w-2xl">
                <a href="{{ route('teacher.remedials.exercises.index', $material) }}"
                   class="inline-flex items-center gap-2 text-sm font-semibold text-white/85 transition hover:text-white">
                    <span>←</span> Kembali ke Daftar Soal
                </a>

                <div class="mt-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/15 px-3 py-1.5 text-xs font-semibold backdrop-blur">
                    <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                    BANK SOAL REMEDIASI
                </div>

                <h1 class="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">
                    Tambah Soal Latihan
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-6 text-white/85 sm:text-base">
                    Buat latihan yang membantu siswa memahami kembali materi dan memperbaiki kesalahan belajarnya.
                </p>

                <div class="mt-5 inline-flex max-w-full items-center gap-2 rounded-xl border border-white/20 bg-white/15 px-4 py-3 text-sm backdrop-blur">
                    <span>📚</span>
                    <span class="truncate">Materi: <strong>{{ $material->title }}</strong></span>
                </div>
            </div>

            <div class="hidden shrink-0 lg:block">
                <div class="relative flex h-44 w-44 items-center justify-center">
                    <div class="absolute inset-3 rounded-full bg-white/15 animate-pulse"></div>
                    <div class="absolute inset-0 rounded-full border border-white/20"></div>
                    <svg class="relative h-36 w-36 animate-[floatBook_4s_ease-in-out_infinite]"
                         viewBox="0 0 180 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M34 48C34 42.477 38.477 38 44 38H84C94 38 102 46 102 56V137C102 127 94 119 84 119H44C38.477 119 34 114.523 34 109V48Z"
                              fill="white" fill-opacity=".95"/>
                        <path d="M146 48C146 42.477 141.523 38 136 38H96C86 38 78 46 78 56V137C78 127 86 119 96 119H136C141.523 119 146 114.523 146 109V48Z"
                              fill="#E8FFF5"/>
                        <path d="M90 55V137" stroke="#0C9B9B" stroke-width="3" stroke-linecap="round"/>
                        <path d="M48 62H77M48 76H77M48 90H69"
                              stroke="#1687D9" stroke-width="4" stroke-linecap="round"/>
                        <path d="M103 62H132M103 76H132M103 90H126"
                              stroke="#22B987" stroke-width="4" stroke-linecap="round"/>
                        <circle cx="132" cy="28" r="12" fill="#A7F3D0"/>
                        <path d="M127 28L131 32L138 24" stroke="#087C70" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M26 119L31 124L40 113" stroke="#D1FAE5" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="pointer-events-none absolute -right-12 -top-16 h-56 w-56 rounded-full bg-white/10 blur-2xl"></div>
        <div class="pointer-events-none absolute -bottom-20 right-1/3 h-48 w-48 rounded-full bg-emerald-300/20 blur-3xl"></div>
    </section>

    {{-- ERROR VALIDASI --}}
    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-5 text-sm text-red-700">
            <div class="flex items-start gap-3">
                <span class="text-xl">⚠️</span>
                <div>
                    <p class="font-bold">Periksa kembali isian berikut:</p>
                    <ul class="mt-2 list-inside list-disc space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('teacher.remedials.exercises.store', $material) }}"
          method="POST"
          class="space-y-6">
        @csrf

        {{-- INFORMASI SOAL --}}
        <section class="overflow-hidden rounded-[24px] border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-gradient-to-r from-blue-50/80 to-cyan-50/50 px-6 py-5 sm:px-7">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-100 text-xl">📝</div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-800">Informasi Soal</h2>
                        <p class="mt-0.5 text-sm text-slate-500">Tentukan jenis dan isi pertanyaan latihan.</p>
                    </div>
                </div>
            </div>

            <div class="space-y-6 p-6 sm:p-7">

                {{-- JENIS SOAL --}}
                <div>
                    <label for="question_type" class="mb-2 block text-sm font-bold text-slate-700">
                        Jenis Soal <span class="text-red-500">*</span>
                    </label>
                    <select name="question_type"
                            id="question_type"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">
                        <option value="multiple_choice"
                            {{ old('question_type', 'multiple_choice') === 'multiple_choice' ? 'selected' : '' }}>
                            Pilihan Ganda
                        </option>
                        <option value="short_answer"
                            {{ old('question_type') === 'short_answer' ? 'selected' : '' }}>
                            Isian Singkat
                        </option>
                    </select>
                    <p class="mt-2 text-xs text-slate-400">Pilih format jawaban yang akan dikerjakan siswa.</p>
                </div>

                {{-- PERTANYAAN --}}
                <div>
                    <label for="question_text" class="mb-2 block text-sm font-bold text-slate-700">
                        Pertanyaan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="question_text"
                              id="question_text"
                              rows="4"
                              required
                              placeholder="Tuliskan pertanyaan latihan..."
                              class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">{{ old('question_text') }}</textarea>
                </div>

                {{-- PILIHAN GANDA --}}
                <div id="multiple_choice_section" class="space-y-4 rounded-2xl border border-blue-100 bg-blue-50/40 p-5">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-lg">🔤</div>
                        <div>
                            <h3 class="font-extrabold text-slate-800">Pilihan Jawaban</h3>
                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Isi keempat pilihan jawaban dan tentukan jawaban yang benar.
                            </p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach(['A', 'B', 'C', 'D'] as $option)
                            <div>
                                <label for="option_{{ $option }}" class="mb-2 flex items-center gap-2 text-sm font-bold text-slate-700">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-white text-xs font-extrabold text-blue-600 shadow-sm">{{ $option }}</span>
                                    Pilihan {{ $option }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="option_{{ $option }}"
                                       name="options[{{ $option }}]"
                                       value="{{ old('options.'.$option) }}"
                                       maxlength="255"
                                       placeholder="Masukkan pilihan {{ $option }}"
                                       class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ISIAN SINGKAT --}}
                <div id="short_answer_section" class="hidden rounded-2xl border border-emerald-100 bg-emerald-50/50 p-5">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-lg">✏️</div>
                        <div>
                            <h3 class="font-extrabold text-slate-800">Kunci Jawaban Isian Singkat</h3>
                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Tuliskan jawaban yang akan digunakan sistem untuk mencocokkan jawaban siswa.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- KUNCI JAWABAN --}}
                <div>
                    <label for="correct_answer_choice" class="mb-2 block text-sm font-bold text-slate-700">
                        Kunci Jawaban <span class="text-red-500">*</span>
                    </label>

                    <select name="correct_answer"
                            id="correct_answer_choice"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">
                        <option value="">Pilih jawaban yang benar</option>
                        @foreach(['A', 'B', 'C', 'D'] as $option)
                            <option value="{{ $option }}"
                                {{ old('correct_answer') === $option ? 'selected' : '' }}>
                                Pilihan {{ $option }}
                            </option>
                        @endforeach
                    </select>

                    <input type="text"
                           name="correct_answer"
                           id="correct_answer_text"
                           value="{{ old('question_type') === 'short_answer' ? old('correct_answer') : '' }}"
                           maxlength="255"
                           placeholder="Contoh: 200"
                           class="hidden w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-100">
                    <p class="mt-2 text-xs text-slate-400">
                        Untuk pilihan ganda, pilih huruf jawaban. Untuk isian singkat, masukkan jawaban yang tepat.
                    </p>
                </div>

                {{-- PEMBAHASAN --}}
                <div>
                    <label for="explanation" class="mb-2 block text-sm font-bold text-slate-700">
                        Pembahasan Jawaban
                    </label>
                    <textarea name="explanation"
                              id="explanation"
                              rows="3"
                              placeholder="Jelaskan cara mendapatkan jawaban yang benar..."
                              class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">{{ old('explanation') }}</textarea>
                    <p class="mt-2 text-xs text-slate-400">
                        Pembahasan akan membantu siswa memahami kesalahan jawabannya.
                    </p>
                </div>
            </div>
        </section>

        {{-- PENGATURAN SOAL --}}
        <section class="overflow-hidden rounded-[24px] border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-gradient-to-r from-emerald-50/80 to-teal-50/50 px-6 py-5 sm:px-7">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-100 text-xl">⚙️</div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-800">Pengaturan Soal</h2>
                        <p class="mt-0.5 text-sm text-slate-500">Atur bobot, urutan, dan status soal.</p>
                    </div>
                </div>
            </div>

            <div class="space-y-5 p-6 sm:p-7">
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="points" class="mb-2 block text-sm font-bold text-slate-700">
                            Bobot Nilai <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                               id="points"
                               name="points"
                               min="1"
                               max="100"
                               required
                               value="{{ old('points', 1) }}"
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">
                        <p class="mt-2 text-xs text-slate-400">Nilai yang diperoleh siswa jika menjawab benar.</p>
                    </div>

                    <div>
                        <label for="sort_order" class="mb-2 block text-sm font-bold text-slate-700">
                            Urutan Soal
                        </label>
                        <input type="number"
                               id="sort_order"
                               name="sort_order"
                               min="0"
                               value="{{ old('sort_order', 0) }}"
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">
                        <p class="mt-2 text-xs text-slate-400">Menentukan posisi soal dalam daftar latihan.</p>
                    </div>
                </div>

                <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50/60 p-4 transition hover:bg-emerald-50">
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           {{ old('is_active', '1') ? 'checked' : '' }}
                           class="h-5 w-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <span>
                        <span class="block text-sm font-bold text-slate-800">Aktifkan soal setelah disimpan</span>
                        <span class="mt-1 block text-xs text-slate-500">Soal dapat digunakan dalam latihan remediasi siswa.</span>
                    </span>
                </label>
            </div>
        </section>

        {{-- TOMBOL AKSI --}}
        <div class="flex flex-col-reverse justify-end gap-3 sm:flex-row">
            <a href="{{ route('teacher.remedials.exercises.index', $material) }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-bold text-slate-600 transition hover:bg-slate-50">
                Batal
            </a>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#087cf0] to-[#16b9c8] px-7 py-3 text-sm font-bold text-white shadow-lg shadow-blue-200/60 transition hover:-translate-y-0.5 hover:shadow-xl">
                <span>✓</span>
                Simpan Soal
            </button>
        </div>
    </form>
</div>

<style>
    @keyframes floatBook {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-9px); }
    }

    @media (prefers-reduced-motion: reduce) {
        .animate-pulse,
        .animate-\[floatBook_4s_ease-in-out_infinite\] {
            animation: none !important;
        }
    }
</style>

{{-- Pengaturan tampilan berdasarkan jenis soal --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('question_type');

    const multipleChoiceSection =
        document.getElementById('multiple_choice_section');

    const shortAnswerSection =
        document.getElementById('short_answer_section');

    const correctAnswerChoice =
        document.getElementById('correct_answer_choice');

    const correctAnswerText =
        document.getElementById('correct_answer_text');

    const optionInputs = document.querySelectorAll(
        '#multiple_choice_section input[name^="options"]'
    );

    function updateQuestionForm() {
        const isMultipleChoice =
            typeSelect.value === 'multiple_choice';

        multipleChoiceSection.classList.toggle(
            'hidden',
            !isMultipleChoice
        );

        shortAnswerSection.classList.toggle(
            'hidden',
            isMultipleChoice
        );

        correctAnswerChoice.classList.toggle(
            'hidden',
            !isMultipleChoice
        );

        correctAnswerText.classList.toggle(
            'hidden',
            isMultipleChoice
        );

        correctAnswerChoice.disabled = !isMultipleChoice;
        correctAnswerText.disabled = isMultipleChoice;

        optionInputs.forEach(input => {
            input.required = isMultipleChoice;
            input.disabled = !isMultipleChoice;
        });

        correctAnswerChoice.required = isMultipleChoice;
        correctAnswerText.required = !isMultipleChoice;
    }

    typeSelect.addEventListener('change', updateQuestionForm);

    updateQuestionForm();
});
</script>
@endsection
