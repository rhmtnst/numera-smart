
@extends('layouts.student')

@section('title', 'Petualangan Asesmen Numerasi')

@section('content')

@php
    $totalQuestions = $attempt->answers->count();
    $answeredQuestions = $attempt->answers->filter(fn ($answer) => !empty($answer->answered_at))->count();
    $progress = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0;
@endphp

<section class="mx-auto max-w-6xl px-4 py-7 md:px-7">

    {{-- HEADER PETUALANGAN --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('student.dashboard') }}"
           class="inline-flex items-center gap-2 rounded-full border border-white bg-white px-5 py-3 text-sm font-bold text-sky-700 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
            ← Kembali ke Beranda
        </a>

        <span class="rounded-full border border-amber-200 bg-amber-100 px-4 py-2 text-xs font-extrabold text-amber-700">
            ⭐ MISI NUMERASI
        </span>
    </div>

    {{-- HERO --}}
    <div class="relative overflow-hidden rounded-[2rem] border-4 border-white bg-gradient-to-br from-cyan-200 via-sky-100 to-emerald-100 p-6 shadow-lg md:p-9">
        <div class="pointer-events-none absolute -right-10 -top-16 h-56 w-56 rounded-full bg-yellow-200/70"></div>
        <div class="pointer-events-none absolute -bottom-24 right-1/4 h-56 w-56 rounded-full bg-emerald-200/70"></div>

        <div class="relative z-10 grid items-center gap-7 md:grid-cols-[1fr_auto]">
            <div>
                <span class="inline-flex rounded-full bg-white/80 px-4 py-2 text-xs font-extrabold tracking-wide text-sky-700">
                    🚀 SAATNYA MENUNJUKKAN KEMAMPUANMU!
                </span>

                <h1 class="mt-5 max-w-2xl text-3xl font-black leading-tight text-sky-950 md:text-4xl">
                    Ayo Taklukkan Tantangan Numerasi!
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-7 text-sky-900">
                    {{ $attempt->topic->title }}
                </p>

                <div class="mt-5 flex flex-wrap gap-3">
                    <span class="rounded-full bg-white px-4 py-2 text-sm font-bold text-sky-700 shadow-sm">
                        🎒 {{ $totalQuestions }} Soal
                    </span>
                    <span class="rounded-full bg-white px-4 py-2 text-sm font-bold text-emerald-700 shadow-sm">
                        🌟 Kamu Pasti Bisa!
                    </span>
                </div>
            </div>

            <div class="mx-auto flex h-36 w-36 items-center justify-center rounded-[2rem] border-4 border-white bg-gradient-to-br from-yellow-200 to-orange-200 text-7xl shadow-lg md:h-44 md:w-44">
                🧠
            </div>
        </div>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 font-semibold text-emerald-700">
            🎉 {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 p-5 text-rose-700">
            <p class="font-extrabold">Ups! Ada jawaban yang perlu diperiksa.</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- PROGRES --}}
    <div class="mt-6 rounded-[1.7rem] border-2 border-white bg-white p-5 shadow-sm md:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="text-xs font-extrabold tracking-wider text-sky-600">PROGRES PETUALANGAN</p>
                <h2 class="mt-1 text-xl font-black text-slate-800">Perjalananmu Hari Ini</h2>
            </div>

            <span class="rounded-full bg-emerald-100 px-4 py-2 text-sm font-extrabold text-emerald-700">
                {{ $answeredQuestions }}/{{ $totalQuestions }} Terjawab
            </span>
        </div>

        <div class="mt-5 h-4 overflow-hidden rounded-full bg-slate-100">
            <div class="h-full rounded-full bg-gradient-to-r from-cyan-400 via-sky-400 to-emerald-400 transition-all duration-500"
                 style="width: {{ $progress }}%">
            </div>
        </div>

        <div class="mt-2 flex justify-between text-xs font-semibold text-slate-400">
            <span>Terus semangat! 🌱</span>
            <span>{{ $progress }}%</span>
        </div>
    </div>

    {{-- FORM JAWABAN --}}
    <form action="{{ route('student.assessments.answers.save', $attempt->id) }}"
          method="POST"
          class="mt-8">
        @csrf

        <div class="mb-5 flex items-center justify-between gap-3">
            <div>
                <span class="text-xs font-extrabold tracking-widest text-emerald-600">ZONA TANTANGAN</span>
                <h2 class="mt-1 text-2xl font-black text-slate-800">Pilih Jawabanmu! 🎯</h2>
            </div>
            <span class="hidden rounded-full bg-purple-100 px-4 py-2 text-xs font-bold text-purple-700 sm:inline-flex">
                ✨ Berpikir dan Berkreasi
            </span>
        </div>

        <div class="space-y-7">

            @foreach($attempt->answers as $index => $answer)

                @php
                    $question = $answer->question;

                    $savedOption = old(
                        "answers.{$answer->id}.option_label",
                        $answer->answer_text
                    );

                    $savedSteps = old(
                        "answers.{$answer->id}.working_steps",
                        $answer->working_steps
                    );

                    $savedExplanation = old(
                        "answers.{$answer->id}.student_explanation",
                        $answer->student_explanation
                    );

                    $cardColors = [
                        ['bg' => 'bg-cyan-50', 'text' => 'text-cyan-700', 'number' => 'bg-cyan-400'],
                        ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'number' => 'bg-purple-400'],
                        ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'number' => 'bg-amber-400'],
                        ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'number' => 'bg-emerald-400'],
                    ];

                    $color = $cardColors[$index % 4];
                @endphp

                <article class="overflow-hidden rounded-[1.8rem] border-2 border-white bg-white shadow-md transition duration-300 hover:-translate-y-1 hover:shadow-lg">

                    {{-- HEADER SOAL --}}
                    <div class="{{ $color['bg'] }} flex flex-wrap items-center justify-between gap-3 px-5 py-5 md:px-7">
                        <div class="flex items-center gap-3">
                            <div class="{{ $color['number'] }} flex h-12 w-12 items-center justify-center rounded-2xl text-xl font-black text-white shadow-sm">
                                {{ $index + 1 }}
                            </div>

                            <div>
                                <p class="text-xs font-extrabold tracking-wider {{ $color['text'] }}">
                                    TANTANGAN {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </p>
                                <h3 class="text-lg font-black text-slate-800">
                                    Soal {{ $index + 1 }}
                                </h3>
                            </div>
                        </div>

                        <span class="rounded-full bg-white px-4 py-2 text-xs font-bold {{ $color['text'] }}">
                            {{ ucfirst(str_replace('_', ' ', $question->difficulty)) }}
                        </span>
                    </div>

                    <div class="p-5 md:p-7">

                        {{-- STIMULUS --}}
                        @if($question->stimulus)
                            <div class="mb-5 rounded-2xl border border-sky-100 bg-sky-50 p-5">
                                <p class="mb-2 text-xs font-extrabold tracking-wider text-sky-600">
                                    📖 BACA PETUNJUK BERIKUT
                                </p>
                                <div class="whitespace-pre-line text-sm leading-7 text-sky-950">
                                    {{ $question->stimulus }}
                                </div>
                            </div>
                        @endif

                        {{-- PERTANYAAN --}}
                        <div class="rounded-2xl bg-slate-50 p-5">
                            <p class="mb-2 text-xs font-extrabold tracking-wider text-slate-400">
                                💡 PERTANYAAN
                            </p>
                            <h4 class="text-lg font-bold leading-8 text-slate-800 md:text-xl">
                                {{ $question->question_text }}
                            </h4>
                        </div>

                        {{-- PILIHAN JAWABAN --}}
                        <div class="mt-6">
                            <p class="mb-4 text-sm font-extrabold text-slate-700">
                                🧩 Pilih satu jawaban yang menurutmu benar!
                            </p>

                            <div class="grid gap-3 sm:grid-cols-2">
                                @foreach($question->options->sortBy('sort_order') as $option)
                                    <label class="group flex cursor-pointer items-center gap-3 rounded-2xl border-2 border-slate-100 bg-white p-4 transition hover:border-sky-300 hover:bg-sky-50 has-[:checked]:border-emerald-400 has-[:checked]:bg-emerald-50">
                                        <input
                                            type="radio"
                                            name="answers[{{ $answer->id }}][option_label]"
                                            value="{{ $option->option_label }}"
                                            class="h-5 w-5 accent-emerald-500"
                                            @checked($savedOption === $option->option_label)
                                        >

                                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-sky-100 font-black text-sky-700 transition group-hover:scale-105">
                                            {{ $option->option_label }}
                                        </span>

                                        <span class="text-sm font-semibold leading-6 text-slate-700">
                                            {{ $option->option_text }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- LANGKAH PENGERJAAN --}}
                        <div class="mt-7 rounded-2xl border border-amber-100 bg-amber-50 p-5">
                            <label for="steps-{{ $answer->id }}"
                                   class="mb-3 block font-extrabold text-amber-900">
                                ✏️ Ceritakan Cara Menghitungmu
                            </label>

                            <p class="mb-3 text-xs leading-5 text-amber-800">
                                Tuliskan langkah-langkah yang kamu gunakan untuk menemukan jawaban.
                            </p>

                            <textarea
                                id="steps-{{ $answer->id }}"
                                name="answers[{{ $answer->id }}][working_steps]"
                                rows="3"
                                placeholder="Contoh: Pertama saya menghitung..., kemudian..."
                                class="w-full rounded-2xl border-2 border-amber-100 bg-white p-4 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-amber-400 focus:ring-4 focus:ring-amber-100"
                            >{{ $savedSteps }}</textarea>
                        </div>

                        {{-- PENJELASAN SISWA --}}
                        <div class="mt-4 rounded-2xl border border-purple-100 bg-purple-50 p-5">
                            <label for="explanation-{{ $answer->id }}"
                                   class="mb-3 block font-extrabold text-purple-900">
                                💭 Mengapa Kamu Memilih Jawaban Itu?
                            </label>

                            <p class="mb-3 text-xs leading-5 text-purple-800">
                                Tidak perlu takut salah. Jelaskan alasanmu menggunakan bahasamu sendiri.
                            </p>

                            <textarea
                                id="explanation-{{ $answer->id }}"
                                name="answers[{{ $answer->id }}][student_explanation]"
                                rows="2"
                                placeholder="Saya memilih jawaban ini karena..."
                                class="w-full rounded-2xl border-2 border-purple-100 bg-white p-4 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-purple-400 focus:ring-4 focus:ring-purple-100"
                            >{{ $savedExplanation }}</textarea>
                        </div>

                        @if($answer->answered_at)
                            <div class="mt-5 inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-2 text-xs font-bold text-emerald-700">
                                ✓ Jawaban pernah disimpan
                            </div>
                        @endif

                    </div>
                </article>

            @endforeach

        </div>

        {{-- MOTIVASI --}}
        <div class="mt-8 flex items-center gap-4 rounded-[1.7rem] border-2 border-yellow-200 bg-gradient-to-r from-yellow-100 to-orange-50 p-5">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white text-3xl shadow-sm">
                🦉
            </div>
            <div>
                <h3 class="font-black text-amber-900">Pesan dari NUMERA!</h3>
                <p class="mt-1 text-sm leading-6 text-amber-800">
                    Setiap soal adalah kesempatan untuk belajar. Tidak perlu terburu-buru, pahami langkahmu dan lakukan yang terbaik! 🌟
                </p>
            </div>
        </div>

        {{-- SIMPAN --}}
        <div class="mt-7 flex justify-center sm:justify-end">
            <button type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 px-8 py-4 font-extrabold text-white shadow-lg shadow-emerald-200 transition hover:-translate-y-1 hover:shadow-xl sm:w-auto">
                💾 Simpan Jawaban
            </button>
        </div>

    </form>

    {{-- SELESAIKAN ASESMEN --}}
    <div class="mt-5 rounded-[1.8rem] border-2 border-sky-100 bg-sky-50 p-5 md:p-6">
        <div class="flex flex-col items-center justify-between gap-5 sm:flex-row">
            <div>
                <h3 class="text-lg font-black text-sky-950">
                    🏁 Sudah Menjawab Semua Soal?
                </h3>
                <p class="mt-1 text-sm leading-6 text-sky-800">
                    Periksa kembali jawabanmu. Jika sudah yakin, selesaikan tantangan ini!
                </p>
            </div>

            <form action="{{ route('student.assessments.finish', $attempt->id) }}"
                  method="POST"
                  onsubmit="return confirm('Apakah kamu yakin ingin menyelesaikan asesmen ini? Setelah selesai, jawaban tidak dapat diubah lagi.');">
                @csrf

                <button type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-sky-500 to-blue-600 px-7 py-4 font-extrabold text-white shadow-lg shadow-sky-200 transition hover:-translate-y-1 hover:shadow-xl sm:w-auto">
                    🏆 Selesaikan Tantangan →
                </button>
            </form>
        </div>
    </div>

</section>

@endsection
