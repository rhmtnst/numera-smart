
@extends('layouts.teacher')

@section('title', $editing ? 'Edit Materi Utama' : 'Tambah Materi Utama')

@section('content')

<style>
    .material-float {
        animation: materialFloat 4s ease-in-out infinite;
    }

    .material-float-delay {
        animation: materialFloat 5s ease-in-out infinite;
        animation-delay: .8s;
    }

    .material-star {
        animation: materialStar 2.5s ease-in-out infinite;
        transform-box: fill-box;
        transform-origin: center;
    }

    .material-input {
        width: 100%;
        border: 1px solid #d9e8f1;
        border-radius: 13px;
        background: #f9fcff;
        padding: 13px 15px;
        color: #24445b;
        font-size: 14px;
        transition: all .2s ease;
    }

    .material-input:focus {
        outline: none;
        border-color: #0ea5e9;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(14,165,233,.10);
    }

    .material-label {
        display: block;
        margin-bottom: 9px;
        color: #24445b;
        font-size: 13px;
        font-weight: 700;
    }

    .material-card {
        transition: box-shadow .25s ease, transform .25s ease;
    }

    .material-card:hover {
        box-shadow: 0 16px 35px rgba(22, 113, 173, .08);
    }

    @keyframes materialFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    @keyframes materialStar {
        0%, 100% { opacity: .5; transform: scale(.9) rotate(0deg); }
        50% { opacity: 1; transform: scale(1.12) rotate(10deg); }
    }

    @media (prefers-reduced-motion: reduce) {
        .material-float,
        .material-float-delay,
        .material-star {
            animation: none !important;
        }
    }
</style>

<div class="relative mx-auto max-w-6xl space-y-7 overflow-hidden">

    {{-- DEKORASI --}}
    <div class="pointer-events-none absolute -right-24 top-10 h-72 w-72 rounded-full bg-cyan-200/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-24 top-[35rem] h-72 w-72 rounded-full bg-blue-200/20 blur-3xl"></div>


    {{-- NAVIGASI --}}
    <div class="relative z-10">
        <a href="{{ route('teacher.learning-materials.index') }}"
           class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-white px-4 py-2.5 text-sm font-semibold text-blue-600 shadow-sm transition hover:-translate-x-1 hover:shadow-md">
            <span>←</span>
            Kembali ke Materi Utama
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
                    NUMERA SMART · RUANG GURU
                </div>

                <h1 class="mt-5 text-3xl font-extrabold tracking-tight md:text-4xl">
                    {{ $editing ? 'Edit Materi Utama' : 'Buat Materi Baru' }}
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-7 text-white/90 md:text-base">
                    {{ $editing
                        ? 'Perbarui isi materi pembelajaran agar semakin mudah dipahami oleh siswa.'
                        : 'Susun materi pembelajaran yang menarik, terstruktur, dan membantu siswa memahami numerasi.' }}
                </p>

                <div class="mt-6 inline-flex items-center gap-3 rounded-full border border-white/30 bg-white/15 px-5 py-3 text-sm font-semibold backdrop-blur">
                    <span class="text-xl">📚</span>
                    {{ $editing ? 'Perbarui konten pembelajaran' : 'Mulai susun pembelajaran' }}
                </div>
            </div>

            {{-- ILUSTRASI BUKU ANIMASI --}}
            <div class="mx-auto hidden h-48 w-full max-w-[230px] lg:block">
                <svg viewBox="0 0 240 190"
                     class="h-full w-full"
                     xmlns="http://www.w3.org/2000/svg"
                     role="img"
                     aria-label="Ilustrasi buku dan materi pembelajaran">

                    <circle cx="120" cy="96" r="85" fill="white" fill-opacity=".10"/>

                    <g class="material-star" fill="#FFF1A8">
                        <path d="M38 25 L43 37 L55 42 L43 47 L38 59 L33 47 L21 42 L33 37 Z"/>
                    </g>

                    <g class="material-star" fill="white" style="animation-delay:.7s">
                        <path d="M199 28 L203 38 L213 42 L203 46 L199 56 L195 46 L185 42 L195 38 Z"/>
                    </g>

                    <g class="material-float" transform="translate(35 45)">
                        <path d="M8 18 Q46 4 83 22 V126 Q45 108 8 122 Z"
                              fill="#DDF7FF"/>
                        <path d="M83 22 Q120 4 158 18 V122 Q120 108 83 126 Z"
                              fill="#FFFFFF"/>
                        <path d="M83 22 V126" stroke="#8AD9F2" stroke-width="4"/>
                        <path d="M23 39 Q50 32 69 41" stroke="#159DE5" stroke-width="5" stroke-linecap="round"/>
                        <path d="M23 57 Q50 50 69 59" stroke="#9BCDE3" stroke-width="4" stroke-linecap="round"/>
                        <path d="M23 74 Q50 67 69 76" stroke="#9BCDE3" stroke-width="4" stroke-linecap="round"/>
                        <path d="M99 39 Q125 32 145 41" stroke="#36CFA3" stroke-width="5" stroke-linecap="round"/>
                        <path d="M99 57 Q125 50 145 59" stroke="#9BCDE3" stroke-width="4" stroke-linecap="round"/>
                        <path d="M99 74 Q125 67 145 76" stroke="#9BCDE3" stroke-width="4" stroke-linecap="round"/>
                    </g>

                    <g class="material-float-delay" transform="translate(157 112)">
                        <circle cx="24" cy="24" r="21" fill="#FFF1A8"/>
                        <path d="M24 10 V25 L34 31" stroke="#D28B00" stroke-width="4" stroke-linecap="round" fill="none"/>
                    </g>
                </svg>
            </div>

        </div>
    </section>


    {{-- NOTIFIKASI VALIDASI --}}
    @if($errors->any())
        <div class="relative rounded-2xl border border-red-200 bg-red-50 p-5 text-sm text-red-700 shadow-sm">
            <div class="flex items-start gap-3">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-100 text-lg">!</span>
                <div>
                    <p class="font-bold">Materi belum dapat disimpan</p>
                    <p class="mt-1">{{ $errors->first() }}</p>
                    <ul class="mt-2 list-inside list-disc">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif


    {{-- INFORMASI FORM --}}
    <div class="relative flex items-start gap-3 rounded-2xl border border-blue-100 bg-blue-50/80 p-5">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-xl shadow-sm">💡</span>
        <div>
            <p class="font-bold text-blue-900">Panduan Penyusunan Materi</p>
            <p class="mt-1 text-sm leading-6 text-blue-800">
                Lengkapi informasi materi, kompetensi, tujuan pembelajaran, isi materi, contoh, dan latihan reflektif. Materi akan disimpan sebagai draft sebelum dipublikasikan.
            </p>
        </div>
    </div>


    {{-- FORM UTAMA --}}
    <form
        method="POST"
        action="{{ $editing
            ? route('teacher.learning-materials.update', $material)
            : route('teacher.learning-materials.store') }}"
        class="relative space-y-7"
    >
        @csrf

        @if($editing)
            @method('PUT')
        @endif


        {{-- BAGIAN 1: INFORMASI MATERI --}}
        <section class="material-card overflow-hidden rounded-[25px] border border-white bg-white shadow-[0_12px_35px_rgba(38,105,160,.07)]">

            <div class="flex items-center gap-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-cyan-50 p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 text-xl text-white shadow-lg shadow-blue-100">
                    📘
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[.16em] text-blue-500">Bagian 01</p>
                    <h2 class="mt-1 text-lg font-extrabold text-slate-800">Informasi Materi</h2>
                    <p class="mt-1 text-xs text-slate-500">Tentukan topik dan identitas materi pembelajaran.</p>
                </div>
            </div>

            <div class="space-y-5 p-6 md:p-7">

                @if($editing)

                    <div class="rounded-2xl border border-blue-100 bg-blue-50/70 p-5">
                        <p class="text-xs font-bold uppercase tracking-wider text-blue-500">Topik Pembelajaran</p>
                        <p class="mt-2 font-bold text-slate-800">
                            {{ $material->topic?->title }}
                        </p>
                        <p class="mt-1 text-sm text-slate-500">
                            Kelas {{ $material->topic?->grade_level }}
                            · {{ $material->topic?->learningDomain?->name }}
                        </p>
                    </div>

                @else

                    <div>
                        <label class="material-label" for="topic_id">Pilih Topik Pembelajaran</label>

                        <select id="topic_id" name="topic_id" required class="material-input">
                            @foreach($topics as $topic)
                                <option value="{{ $topic->id }}"
                                    @selected(old('topic_id') == $topic->id)>
                                    Kelas {{ $topic->grade_level }}
                                    · {{ $topic->learningDomain?->name }}
                                    · {{ $topic->title }}
                                </option>
                            @endforeach
                        </select>

                        @error('topic_id')
                            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                @endif

                <div>
                    <label class="material-label" for="title">Judul Materi</label>
                    <input
                        id="title"
                        name="title"
                        required
                        value="{{ old('title', $material->title) }}"
                        placeholder="Contoh: Mengenal Pecahan dan Desimal"
                        class="material-input"
                    >
                    @error('title')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="material-label" for="competency">Kompetensi Pembelajaran</label>
                    <input
                        id="competency"
                        name="competency"
                        required
                        value="{{ old('competency', $material->competency) }}"
                        placeholder="Kemampuan yang diharapkan setelah belajar"
                        class="material-input"
                    >
                    @error('competency')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if($editing)
                    <div class="rounded-xl border border-amber-100 bg-amber-50 p-4 text-sm leading-6 text-amber-800">
                        <strong>Catatan:</strong> Topik materi tidak dapat diubah melalui form edit ini.
                    </div>
                @endif

            </div>
        </section>


        {{-- BAGIAN 2: TUJUAN PEMBELAJARAN --}}
        <section class="material-card overflow-hidden rounded-[25px] border border-white bg-white shadow-[0_12px_35px_rgba(38,105,160,.07)]">

            <div class="flex items-center gap-4 border-b border-slate-100 bg-gradient-to-r from-cyan-50 to-emerald-50 p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-500 to-emerald-400 text-xl text-white shadow-lg shadow-cyan-100">
                    🎯
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[.16em] text-cyan-600">Bagian 02</p>
                    <h2 class="mt-1 text-lg font-extrabold text-slate-800">Tujuan Pembelajaran</h2>
                    <p class="mt-1 text-xs text-slate-500">Tuliskan hasil belajar yang diharapkan dari siswa.</p>
                </div>
            </div>

            <div class="space-y-4 p-6 md:p-7">

                @for($i = 0; $i < 3; $i++)
                    <div>
                        <label class="material-label" for="objective_{{ $i }}">
                            Tujuan Pembelajaran {{ $i + 1 }}
                        </label>

                        <input
                            id="objective_{{ $i }}"
                            name="objectives[]"
                            value="{{ old('objectives.'.$i, $material->objectives[$i] ?? '') }}"
                            placeholder="Tuliskan tujuan pembelajaran {{ $i + 1 }}"
                            class="material-input"
                        >

                        @error('objectives.'.$i)
                            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endfor

                <div class="rounded-xl bg-emerald-50 p-4 text-xs leading-6 text-emerald-800">
                    <strong>Tips:</strong> Gunakan kalimat yang menjelaskan kemampuan konkret yang diharapkan dapat dilakukan siswa setelah mempelajari materi.
                </div>

            </div>
        </section>


        {{-- BAGIAN 3: ISI MATERI --}}
        <section class="material-card overflow-hidden rounded-[25px] border border-white bg-white shadow-[0_12px_35px_rgba(38,105,160,.07)]">

            <div class="flex items-center gap-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-indigo-50 p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-500 text-xl text-white shadow-lg shadow-blue-100">
                    ✍️
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[.16em] text-indigo-500">Bagian 03</p>
                    <h2 class="mt-1 text-lg font-extrabold text-slate-800">Konten Pembelajaran</h2>
                    <p class="mt-1 text-xs text-slate-500">Susun penjelasan materi dengan bahasa yang mudah dipahami.</p>
                </div>
            </div>

            <div class="space-y-6 p-6 md:p-7">

                <div>
                    <label class="material-label" for="content">Isi Materi</label>

                    <textarea
                        id="content"
                        name="content"
                        rows="12"
                        required
                        placeholder="Tuliskan penjelasan materi pembelajaran secara terstruktur di sini..."
                        class="material-input resize-y leading-7"
                    >{{ old('content', $material->content) }}</textarea>

                    @error('content')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-2 text-xs text-slate-400">
                        Tuliskan penjelasan utama, konsep, dan langkah-langkah pembelajaran.
                    </p>
                </div>

                <div>
                    <label class="material-label" for="example_content">Contoh dan Pembahasan</label>

                    <textarea
                        id="example_content"
                        name="example_content"
                        rows="7"
                        placeholder="Tuliskan contoh soal beserta pembahasannya..."
                        class="material-input resize-y leading-7"
                    >{{ old('example_content', $material->example_content) }}</textarea>

                    @error('example_content')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="material-label" for="practice_prompt">Latihan Reflektif</label>

                    <textarea
                        id="practice_prompt"
                        name="practice_prompt"
                        rows="4"
                        placeholder="Tuliskan pertanyaan atau aktivitas reflektif untuk siswa..."
                        class="material-input resize-y leading-7"
                    >{{ old('practice_prompt', $material->practice_prompt) }}</textarea>

                    @error('practice_prompt')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </section>


        {{-- BAGIAN 4: ESTIMASI WAKTU --}}
        <section class="material-card overflow-hidden rounded-[25px] border border-white bg-white shadow-[0_12px_35px_rgba(38,105,160,.07)]">

            <div class="flex items-center gap-4 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-orange-50 p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-400 to-orange-400 text-xl text-white shadow-lg shadow-orange-100">
                    ⏱️
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[.16em] text-orange-500">Bagian 04</p>
                    <h2 class="mt-1 text-lg font-extrabold text-slate-800">Estimasi Waktu</h2>
                    <p class="mt-1 text-xs text-slate-500">Tentukan perkiraan waktu yang diperlukan untuk mempelajari materi.</p>
                </div>
            </div>

            <div class="p-6 md:p-7">
                <div class="max-w-sm">
                    <label class="material-label" for="estimated_minutes">
                        Estimasi Waktu (Menit)
                    </label>

                    <div class="relative">
                        <input
                            id="estimated_minutes"
                            type="number"
                            name="estimated_minutes"
                            min="5"
                            max="90"
                            value="{{ old('estimated_minutes', $material->estimated_minutes ?: 15) }}"
                            class="material-input pr-20"
                        >
                        <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-slate-400">
                            Menit
                        </span>
                    </div>

                    @error('estimated_minutes')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-2 text-xs text-slate-400">
                        Waktu yang diperbolehkan: 5–90 menit.
                    </p>
                </div>
            </div>
        </section>


        {{-- TOMBOL AKSI --}}
        <section class="relative overflow-hidden rounded-[25px] border border-blue-100 bg-gradient-to-r from-blue-50 via-cyan-50 to-emerald-50 p-6 md:p-7">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h3 class="font-extrabold text-slate-800">
                        {{ $editing ? 'Simpan Perubahan Materi?' : 'Siap Menyimpan Materi?' }}
                    </h3>

                    <p class="mt-1 text-sm leading-6 text-slate-500">
                        Materi akan disimpan sebagai draft dan dapat dipublikasikan setelah diperiksa.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">

                    <a
                        href="{{ route('teacher.learning-materials.index') }}"
                        class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-6 py-3 text-sm font-bold text-slate-600 shadow-sm transition hover:bg-slate-50"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#087cf0] to-[#12b5ed] px-7 py-3 text-sm font-bold text-white shadow-lg shadow-blue-200 transition hover:-translate-y-0.5 hover:shadow-xl"
                    >
                        <span>✓</span>
                        {{ $editing ? 'Simpan Perubahan' : 'Simpan sebagai Draft' }}
                    </button>

                </div>

            </div>
        </section>

    </form>

</div>

@endsection
