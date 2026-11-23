
@extends('layouts.teacher')

@section('title', 'Edit Soal Remediasi')

@section('content')

<style>
    .remedial-edit-card {
        border: 1px solid #e8eef6;
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 8px 28px rgba(31, 65, 105, .045);
    }

    .remedial-edit-section {
        border: 1px solid #e8eef6;
        border-radius: 18px;
        background: #fff;
        padding: 22px;
    }

    .remedial-edit-field {
        width: 100%;
        border: 1px solid #dce5ef;
        border-radius: 13px;
        background: #f9fbfe;
        padding: 13px 15px;
        color: #34465e;
        outline: none;
        transition: .2s ease;
    }

    .remedial-edit-field:focus {
        border-color: #2798ed;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(39, 152, 237, .12);
    }

    .remedial-edit-field::placeholder {
        color: #a0aec0;
    }

    .remedial-edit-label {
        display: block;
        margin-bottom: 9px;
        color: #34465e;
        font-size: 13px;
        font-weight: 700;
    }

    .remedial-option {
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid #e8eef6;
        border-radius: 14px;
        background: #fbfdff;
        padding: 11px 13px;
        transition: .2s ease;
    }

    .remedial-option:focus-within {
        border-color: #93c5fd;
        background: #f4faff;
    }

    .remedial-option-letter {
        display: flex;
        width: 37px;
        height: 37px;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #eaf4ff;
        color: #147bd1;
        font-weight: 800;
    }

    .remedial-option input {
        min-width: 0;
        flex: 1;
        border: 0;
        background: transparent;
        padding: 8px 2px;
        color: #34465e;
        outline: none;
    }

    .remedial-option input::placeholder {
        color: #a0aec0;
    }

    .remedial-float {
        animation: remedialFloat 4s ease-in-out infinite;
    }

    .remedial-float-delay {
        animation: remedialFloat 5s ease-in-out infinite;
        animation-delay: .8s;
    }

    @keyframes remedialFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    @media (prefers-reduced-motion: reduce) {
        .remedial-float,
        .remedial-float-delay {
            animation: none;
        }

        .remedial-edit-field,
        .remedial-option {
            transition: none;
        }
    }

    @media (max-width: 640px) {
        .remedial-edit-section {
            padding: 16px;
        }
    }
</style>

<div class="space-y-7">

    {{-- NAVIGASI --}}
    <a href="{{ route('teacher.remedials.exercises.index', $material) }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 transition hover:gap-3 hover:text-blue-800">
        <span>←</span>
        Kembali ke Daftar Soal
    </a>

    {{-- HERO --}}
    <section class="relative overflow-hidden rounded-[26px] bg-gradient-to-br from-[#087cf0] via-[#12afe9] to-[#35d99a] px-6 py-8 text-white shadow-xl shadow-blue-500/10 sm:px-9 sm:py-10">

        <div class="pointer-events-none absolute -right-12 -top-20 h-64 w-64 rounded-full border-[35px] border-white/10"></div>
        <div class="pointer-events-none absolute -bottom-24 right-36 h-56 w-56 rounded-full bg-white/10 blur-2xl"></div>

        <div class="relative z-10 grid items-center gap-6 md:grid-cols-[1fr_auto]">

            <div>
                <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/15 px-3 py-1.5 text-xs font-semibold backdrop-blur">
                    <span>NUMERA SMART</span>
                    <span class="text-white/60">/</span>
                    <span>REMEDIASI</span>
                    <span class="text-white/60">/</span>
                    <span>EDIT SOAL</span>
                </div>

                <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                    Edit Soal Latihan
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-relaxed text-white/85 sm:text-base">
                    Perbarui pertanyaan, pilihan jawaban, pembahasan, dan pengaturan soal latihan remediasi.
                </p>

                <div class="mt-5 inline-flex max-w-full items-center gap-2 rounded-full border border-white/20 bg-white/15 px-4 py-2 text-xs font-semibold backdrop-blur">
                    <span>📚</span>
                    <span class="truncate">{{ $material->title }}</span>
                </div>
            </div>

            <div class="remedial-float hidden h-36 w-36 items-center justify-center rounded-[30px] border border-white/20 bg-white/15 shadow-lg backdrop-blur-sm md:flex">
                <svg viewBox="0 0 150 150" class="h-32 w-32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="28" y="23" width="85" height="105" rx="13" fill="white" fill-opacity=".95"/>
                    <rect x="43" y="41" width="53" height="6" rx="3" fill="#B7DDFB"/>
                    <rect x="43" y="57" width="45" height="5" rx="2.5" fill="#D3E8F9"/>
                    <rect x="43" y="71" width="53" height="5" rx="2.5" fill="#D3E8F9"/>
                    <rect x="43" y="85" width="35" height="5" rx="2.5" fill="#D3E8F9"/>
                    <path d="M91 108L105 94" stroke="#07975A" stroke-width="7" stroke-linecap="round"/>
                    <path d="M87 112L93 109L90 103" stroke="#07975A" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="105" cy="94" r="5" fill="#D1FAE5"/>
                    <path d="M22 43L14 43" stroke="white" stroke-width="4" stroke-linecap="round"/>
                    <path d="M120 35L128 27" stroke="white" stroke-width="4" stroke-linecap="round"/>
                    <path d="M124 63L133 63" stroke="white" stroke-width="4" stroke-linecap="round"/>
                    <path d="M22 113L15 120" stroke="white" stroke-width="4" stroke-linecap="round"/>
                </svg>
            </div>

        </div>
    </section>

    {{-- NOTIFIKASI VALIDASI --}}
    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-5 text-sm text-red-700">
            <div class="flex items-center gap-2 font-bold">
                <span>⚠️</span>
                Periksa Kembali Isian Berikut
            </div>

            <ul class="mt-3 list-inside list-disc space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <span class="text-lg">⚠️</span>
            {{ session('error') }}
        </div>
    @endif

    {{-- INFORMASI MATERI --}}
    <section class="remedial-edit-card flex flex-wrap items-center justify-between gap-4 p-5 sm:p-6">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-2xl">
                📖
            </div>

            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                    Materi Pembelajaran
                </p>
                <h2 class="mt-1 font-extrabold text-gray-800">
                    {{ $material->title }}
                </h2>
            </div>
        </div>

        <span class="rounded-full bg-blue-50 px-4 py-2 text-xs font-bold text-blue-700">
            ✏️ Mode Edit
        </span>
    </section>

    {{-- FORM EDIT --}}
    <form action="{{ route('teacher.remedials.exercises.update', [$material, $exercise->id]) }}"
          method="POST"
          class="space-y-6">

        @csrf
        @method('PUT')

        {{-- INFORMASI SOAL --}}
        <section class="remedial-edit-card p-5 sm:p-7">

            <div class="mb-6 flex items-center gap-3 border-b border-gray-100 pb-5">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-xl">
                    📝
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-gray-800">
                        Informasi Soal
                    </h2>
                    <p class="text-xs text-gray-500">
                        Perbarui jenis dan isi pertanyaan.
                    </p>
                </div>
            </div>

            <div class="space-y-5">

                {{-- JENIS SOAL --}}
                <div>
                    <label for="question_type" class="remedial-edit-label">
                        Jenis Soal <span class="text-red-500">*</span>
                    </label>

                    <select name="question_type"
                            id="question_type"
                            required
                            class="remedial-edit-field">

                        <option value="multiple_choice"
                            {{ old('question_type', $exercise->question_type) === 'multiple_choice' ? 'selected' : '' }}>
                            Pilihan Ganda
                        </option>

                        <option value="short_answer"
                            {{ old('question_type', $exercise->question_type) === 'short_answer' ? 'selected' : '' }}>
                            Isian Singkat
                        </option>

                    </select>
                </div>

                {{-- PERTANYAAN --}}
                <div>
                    <label class="remedial-edit-label">
                        Pertanyaan <span class="text-red-500">*</span>
                    </label>

                    <textarea name="question_text"
                              rows="4"
                              required
                              placeholder="Tuliskan pertanyaan latihan remediasi..."
                              class="remedial-edit-field resize-y">{{ old('question_text', $exercise->question_text) }}</textarea>
                </div>

                {{-- PILIHAN GANDA --}}
                <div id="multiple_choice_section" class="space-y-4 rounded-2xl border border-blue-100 bg-blue-50/40 p-4 sm:p-5">

                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-lg shadow-sm">
                            🔠
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">
                                Pilihan Jawaban
                            </h3>
                            <p class="text-xs text-gray-500">
                                Perbarui pilihan A, B, C, dan D.
                            </p>
                        </div>
                    </div>

                    @foreach(['A', 'B', 'C', 'D'] as $option)
                        <div>
                            <label class="mb-2 block text-xs font-bold text-gray-600">
                                Pilihan {{ $option }} <span class="text-red-500">*</span>
                            </label>

                            <div class="remedial-option">
                                <span class="remedial-option-letter">
                                    {{ $option }}
                                </span>

                                <input type="text"
                                       name="options[{{ $option }}]"
                                       value="{{ old('options.'.$option, $exercise->options[$option] ?? '') }}"
                                       maxlength="255"
                                       placeholder="Tuliskan pilihan jawaban {{ $option }}...">
                            </div>
                        </div>
                    @endforeach

                </div>

                {{-- KUNCI JAWABAN --}}
                <div>
                    <label class="remedial-edit-label">
                        Kunci Jawaban <span class="text-red-500">*</span>
                    </label>

                    <select name="correct_answer"
                            id="correct_answer_choice"
                            class="remedial-edit-field">

                        <option value="">Pilih jawaban yang benar</option>

                        @foreach(['A', 'B', 'C', 'D'] as $option)
                            <option value="{{ $option }}"
                                {{ old('correct_answer', $exercise->correct_answer) === $option ? 'selected' : '' }}>
                                Pilihan {{ $option }}
                            </option>
                        @endforeach

                    </select>

                    <input type="text"
                           name="correct_answer"
                           id="correct_answer_text"
                           value="{{ old('question_type', $exercise->question_type) === 'short_answer' ? old('correct_answer', $exercise->correct_answer) : '' }}"
                           maxlength="255"
                           placeholder="Contoh: 623"
                           class="remedial-edit-field hidden">
                </div>

                {{-- PEMBAHASAN --}}
                <div>
                    <label class="remedial-edit-label">
                        Pembahasan Jawaban
                    </label>

                    <textarea name="explanation"
                              rows="4"
                              placeholder="Jelaskan cara memperoleh jawaban yang benar..."
                              class="remedial-edit-field resize-y">{{ old('explanation', $exercise->explanation) }}</textarea>
                </div>

            </div>
        </section>

        {{-- PENGATURAN SOAL --}}
        <section class="remedial-edit-card p-5 sm:p-7">

            <div class="mb-6 flex items-center gap-3 border-b border-gray-100 pb-5">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-xl">
                    ⚙️
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-gray-800">
                        Pengaturan Soal
                    </h2>
                    <p class="text-xs text-gray-500">
                        Atur bobot penilaian, urutan, dan status soal.
                    </p>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">

                <div>
                    <label class="remedial-edit-label">
                        Bobot Nilai <span class="text-red-500">*</span>
                    </label>

                    <input type="number"
                           name="points"
                           min="1"
                           max="100"
                           required
                           value="{{ old('points', $exercise->points) }}"
                           class="remedial-edit-field">
                </div>

                <div>
                    <label class="remedial-edit-label">
                        Urutan Soal
                    </label>

                    <input type="number"
                           name="sort_order"
                           min="0"
                           value="{{ old('sort_order', $exercise->sort_order) }}"
                           class="remedial-edit-field">
                </div>

            </div>

            {{-- STATUS AKTIF --}}
            <div class="mt-6 rounded-2xl border border-emerald-100 bg-emerald-50/50 p-4">
                <label class="flex cursor-pointer items-center gap-4">

                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           {{ old('is_active', $exercise->is_active) ? 'checked' : '' }}
                           class="h-5 w-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">

                    <div>
                        <p class="text-sm font-bold text-gray-800">
                            Aktifkan Soal
                        </p>
                        <p class="mt-1 text-xs text-gray-500">
                            Soal aktif dapat ditampilkan kepada siswa sesuai status publikasi materi.
                        </p>
                    </div>

                </label>
            </div>

        </section>

        {{-- TOMBOL AKSI --}}
        <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:items-center sm:justify-between">

            <a href="{{ route('teacher.remedials.exercises.index', $material) }}"
               class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-3 text-sm font-bold text-gray-600 transition hover:bg-gray-50">
                Batal
            </a>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 via-sky-500 to-emerald-500 px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:shadow-xl">
                <span>💾</span>
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

{{-- JAVASCRIPT: PERGANTIAN JENIS SOAL --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const typeSelect = document.getElementById('question_type');
    const multipleChoiceSection = document.getElementById('multiple_choice_section');
    const correctAnswerChoice = document.getElementById('correct_answer_choice');
    const correctAnswerText = document.getElementById('correct_answer_text');

    const optionInputs = document.querySelectorAll(
        '#multiple_choice_section input[name^="options"]'
    );

    function updateQuestionForm() {

        const isMultipleChoice = typeSelect.value === 'multiple_choice';

        // Tampilkan atau sembunyikan pilihan jawaban.
        multipleChoiceSection.classList.toggle('hidden', !isMultipleChoice);

        correctAnswerChoice.classList.toggle('hidden', !isMultipleChoice);
        correctAnswerText.classList.toggle('hidden', isMultipleChoice);

        // Aktifkan hanya input sesuai jenis soal.
        correctAnswerChoice.disabled = !isMultipleChoice;
        correctAnswerText.disabled = isMultipleChoice;

        // Atur validasi wajib isi.
        correctAnswerChoice.required = isMultipleChoice;
        correctAnswerText.required = !isMultipleChoice;

        // Pilihan A-D hanya wajib untuk pilihan ganda.
        optionInputs.forEach(input => {
            input.required = isMultipleChoice;
            input.disabled = !isMultipleChoice;
        });
    }

    typeSelect.addEventListener('change', updateQuestionForm);

    // Jalankan saat halaman pertama kali dibuka.
    updateQuestionForm();

});
</script>

@endsection
