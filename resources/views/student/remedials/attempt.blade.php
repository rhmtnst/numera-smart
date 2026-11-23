
@extends('layouts.student')

@section('title', 'Petualangan Latihan Remediasi')

@section('content')

@php
    $totalQuestions = $attempt->answers->count();
    $answeredQuestions = $attempt->answers->whereNotNull('answered_at')->count();
    $progress = $totalQuestions > 0
        ? round(($answeredQuestions / $totalQuestions) * 100)
        : 0;
@endphp

<section class="mx-auto max-w-6xl px-4 py-8">

    {{-- NAVIGASI --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('student.remedials.show', $attempt->material) }}"
           class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-bold text-sky-700 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
            ← Kembali ke Materi
        </a>

        <span class="rounded-full bg-amber-100 px-5 py-2 text-xs font-bold text-amber-700">
            ⭐ MISI LATIHAN
        </span>
    </div>

    {{-- HERO --}}
    <div class="relative mb-6 overflow-hidden rounded-[2rem] border-4 border-white bg-gradient-to-r from-cyan-200 via-sky-100 to-violet-200 p-7 shadow-lg sm:p-9">

        <div class="pointer-events-none absolute -right-8 -top-12 h-48 w-48 rounded-full bg-yellow-200/80"></div>
        <div class="pointer-events-none absolute bottom-[-75px] right-1/4 h-52 w-52 rounded-full bg-emerald-200/80"></div>

        <div class="relative z-10 grid items-center gap-7 md:grid-cols-[1fr_190px]">

            <div>
                <span class="inline-flex rounded-full border border-white bg-white/80 px-4 py-2 text-xs font-bold tracking-wide text-sky-700">
                    🌱 SAATNYA MENCOBA LAGI!
                </span>

                <h1 class="mt-5 max-w-2xl text-3xl font-black leading-tight text-sky-950 sm:text-4xl">
                    Ayo Selesaikan Tantanganmu!
                </h1>

                <p class="mt-4 max-w-xl text-sm leading-7 text-sky-900">
                    Kerjakan latihan dengan santai dan teliti.
                    Setiap jawaban membantumu menjadi semakin hebat!
                </p>

                <div class="mt-5 flex flex-wrap gap-2">
                    <span class="rounded-full bg-white px-4 py-2 text-xs font-bold text-sky-700 shadow-sm">
                        🎒 Kelas {{ $attempt->material->topic->grade_level }}
                    </span>

                    <span class="rounded-full bg-white px-4 py-2 text-xs font-bold text-emerald-700 shadow-sm">
                        📚 {{ $attempt->material->topic->title }}
                    </span>

                    <span class="rounded-full bg-white px-4 py-2 text-xs font-bold text-orange-600 shadow-sm">
                        ✏️ {{ $totalQuestions }} Soal
                    </span>
                </div>
            </div>

            <div class="mx-auto flex h-40 w-40 items-center justify-center rounded-[2rem] border-4 border-white bg-amber-100 text-7xl shadow-lg md:h-44 md:w-44">
                🧠
            </div>

        </div>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-800">
            🎉 {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 p-5 text-sm text-rose-700">
            <p class="font-bold">Ups! Ada yang perlu diperiksa.</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- PROGRES LATIHAN --}}
    <div class="mb-8 rounded-3xl border border-sky-100 bg-white p-6 shadow-sm">

        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <span class="text-xs font-bold tracking-widest text-sky-500">
                    PROGRES PETUALANGAN
                </span>

                <h2 class="mt-1 text-xl font-black text-slate-800">
                    Perjalanan Latihanmu
                </h2>
            </div>

            <span class="rounded-full bg-emerald-100 px-4 py-2 text-sm font-bold text-emerald-700">
                {{ $answeredQuestions }}/{{ $totalQuestions }} Terjawab
            </span>
        </div>

        <div class="mt-5 h-4 overflow-hidden rounded-full bg-slate-100">
            <div class="h-full rounded-full bg-gradient-to-r from-cyan-400 to-emerald-400 transition-all duration-500"
                 style="width: {{ $progress }}%">
            </div>
        </div>

        <div class="mt-2 flex justify-between text-xs text-slate-400">
            <span>🌱 Terus semangat!</span>
            <span class="font-bold text-emerald-600">{{ $progress }}%</span>
        </div>
    </div>

    {{-- PETA LATIHAN --}}
    <div class="mb-5">
        <span class="text-xs font-bold tracking-widest text-violet-500">
            🧩 ZONA TANTANGAN
        </span>

        <h2 class="mt-1 text-2xl font-black text-slate-800">
            Pilih dan Kerjakan Soal!
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            Baca pertanyaannya, pikirkan jawabannya, lalu simpan hasilnya.
        </p>
    </div>

    {{-- DAFTAR SOAL --}}
    <div class="space-y-6">

        @foreach($attempt->answers as $index => $answer)

            @php
                $exercise = $answer->exercise;
                $isMultipleChoice = $exercise->question_type === 'multiple_choice';

                $colors = [
                    ['bg' => 'bg-sky-100', 'text' => 'text-sky-700', 'border' => 'border-sky-200', 'icon' => '🐳'],
                    ['bg' => 'bg-violet-100', 'text' => 'text-violet-700', 'border' => 'border-violet-200', 'icon' => '🦄'],
                    ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'icon' => '⭐'],
                    ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'icon' => '🐸'],
                ];

                $theme = $colors[$index % count($colors)];
            @endphp

            <article class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                {{-- HEADER KARTU --}}
                <div class="{{ $theme['bg'] }} flex flex-wrap items-center justify-between gap-3 border-b {{ $theme['border'] }} px-5 py-4 sm:px-7">

                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-2xl shadow-sm">
                            {{ $theme['icon'] }}
                        </div>

                        <div>
                            <span class="text-xs font-bold {{ $theme['text'] }}">
                                MISI {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>

                            <h3 class="font-black text-slate-800">
                                Tantangan {{ $index + 1 }}
                            </h3>
                        </div>
                    </div>

                    <div class="rounded-full bg-white px-4 py-2 text-xs font-bold text-slate-600 shadow-sm">
                        ⭐ {{ $exercise->points }} Poin
                    </div>

                </div>

                <div class="p-5 sm:p-7">

                    {{-- PERTANYAAN --}}
                    <div class="mb-6">
                        <span class="text-xs font-bold tracking-wider text-sky-500">
                            PERTANYAAN
                        </span>

                        <h2 class="mt-3 text-lg font-bold leading-8 text-slate-800 sm:text-xl">
                            {{ $exercise->question_text }}
                        </h2>
                    </div>

                    {{-- FORM JAWABAN --}}
                    <form
                        action="{{ route('student.remedials.attempts.answer', $attempt) }}"
                        method="POST"
                    >
                        @csrf

                        <input
                            type="hidden"
                            name="remedial_answer_id"
                            value="{{ $answer->id }}"
                        >

                        @if($isMultipleChoice)

                            <div class="mb-3 flex items-center gap-2">
                                <span class="text-lg">🎯</span>
                                <h3 class="font-bold text-slate-700">
                                    Pilih jawaban yang benar!
                                </h3>
                            </div>

                            <div class="grid gap-3 sm:grid-cols-2">

                                @foreach(($exercise->options ?? []) as $label => $option)

                                    <label class="group flex cursor-pointer items-start gap-3 rounded-2xl border-2 border-slate-100 bg-slate-50 p-4 transition hover:border-emerald-300 hover:bg-emerald-50">

                                        <input
                                            type="radio"
                                            name="answer_text"
                                            value="{{ $label }}"
                                            class="mt-1 h-5 w-5 accent-emerald-500"
                                            required
                                            {{ $answer->answer_text === (string) $label ? 'checked' : '' }}
                                        >

                                        <span class="flex h-7 min-w-7 items-center justify-center rounded-lg bg-white text-sm font-black text-emerald-700 shadow-sm">
                                            {{ $label }}
                                        </span>

                                        <span class="text-sm font-medium leading-6 text-slate-700">
                                            {{ $option }}
                                        </span>

                                    </label>

                                @endforeach

                            </div>

                        @else

                            <div class="mb-3 flex items-center gap-2">
                                <span class="text-lg">✏️</span>
                                <label class="font-bold text-slate-700">
                                    Tuliskan jawabanmu!
                                </label>
                            </div>

                            <input
                                type="text"
                                name="answer_text"
                                value="{{ $answer->answer_text }}"
                                placeholder="Ketik jawabanmu di sini..."
                                maxlength="1000"
                                required
                                class="w-full rounded-2xl border-2 border-slate-100 bg-slate-50 px-5 py-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-100"
                            >

                        @endif

                        {{-- STATUS DAN TOMBOL --}}
                        <div class="mt-6 flex flex-wrap items-center justify-between gap-3 border-t border-dashed border-slate-200 pt-5">

                            @if($answer->answered_at)
                                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-2 text-xs font-bold text-emerald-700">
                                    ✓ Jawaban tersimpan
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-4 py-2 text-xs font-bold text-amber-700">
                                    ⏳ Belum dijawab
                                </span>
                            @endif

                            <button
                                type="submit"
                                class="rounded-full bg-gradient-to-r from-emerald-400 to-teal-500 px-6 py-3 text-sm font-black text-white shadow-md transition hover:-translate-y-1 hover:shadow-lg"
                            >
                                Simpan Jawaban ✓
                            </button>

                        </div>

                    </form>

                </div>
            </article>

        @endforeach

    </div>

    {{-- PETUNJUK SEBELUM MENGUMPULKAN --}}
    <div class="mt-8 overflow-hidden rounded-3xl border border-amber-200 bg-gradient-to-r from-amber-100 to-yellow-50 p-6 sm:p-7">

        <div class="flex items-start gap-4">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white text-3xl shadow-sm">
                🏆
            </div>

            <div>
                <h3 class="text-lg font-black text-amber-900">
                    Hebat! Tinggal Satu Langkah Lagi!
                </h3>

                <p class="mt-2 text-sm leading-7 text-amber-800">
                    Periksa kembali jawabanmu. Pastikan semua soal sudah dijawab dan disimpan sebelum mengumpulkan latihan.
                    Setelah dikumpulkan, jawaban tidak dapat diubah kembali.
                </p>
            </div>
        </div>

        <div class="mt-5 flex flex-wrap items-center justify-between gap-4">

            <span class="rounded-full bg-white px-4 py-2 text-xs font-bold text-amber-700">
                {{ $answeredQuestions }} dari {{ $totalQuestions }} soal tersimpan
            </span>

            <form
                action="{{ route('student.remedials.attempts.submit', $attempt) }}"
                method="POST"
                onsubmit="return confirm('Apakah kamu yakin ingin mengumpulkan latihan ini? Jawaban tidak dapat diubah setelah dikumpulkan.');"
            >
                @csrf

                <button
                    type="submit"
                    class="rounded-full bg-gradient-to-r from-orange-400 to-amber-500 px-7 py-3 font-black text-white shadow-md transition hover:-translate-y-1 hover:shadow-lg"
                >
                    Kumpulkan Latihan →
                </button>

            </form>

        </div>
    </div>

    <div class="mt-8 text-center text-xs font-medium text-slate-400">
        🌈 NUMERA SMART · Terus Belajar, Terus Bertumbuh!
    </div>

</section>

@endsection
