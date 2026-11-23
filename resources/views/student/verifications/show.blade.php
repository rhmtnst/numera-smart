
@extends('layouts.student')

@section('title', 'Verifikasi Pemahaman')

@section('content')
@php
    $stageLabels = [
        'reading' => 'Membaca',
        'comprehension' => 'Memahami',
        'transformation' => 'Transformasi',
        'process_skills' => 'Keterampilan Proses',
        'encoding' => 'Menuliskan Jawaban',
    ];

    $stageIcons = [
        'reading' => '📖',
        'comprehension' => '💡',
        'transformation' => '🔄',
        'process_skills' => '🧮',
        'encoding' => '✍️',
    ];

    $stageColors = [
        'reading' => 'bg-sky-100 text-sky-700',
        'comprehension' => 'bg-violet-100 text-violet-700',
        'transformation' => 'bg-amber-100 text-amber-700',
        'process_skills' => 'bg-emerald-100 text-emerald-700',
        'encoding' => 'bg-pink-100 text-pink-700',
    ];

    $questionCount = $questions->count();
    $answeredCount = $questions->filter(
        fn ($question) => filled(
            old(
                'responses.'.$question->id,
                $responses->get($question->id)?->response_text
            )
        )
    )->count();
@endphp

<div class="mx-auto max-w-6xl px-4 py-7 sm:px-6 lg:px-8">

    {{-- KEMBALI --}}
    <a href="{{ route('student.dashboard') }}"
       class="mb-6 inline-flex items-center gap-2 rounded-full border border-white bg-white px-5 py-3 text-sm font-bold text-sky-700 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
        ← Kembali ke Beranda
    </a>

    {{-- HERO --}}
    <section class="relative mb-7 overflow-hidden rounded-[2rem] border-4 border-white bg-gradient-to-br from-cyan-200 via-sky-100 to-violet-200 p-7 shadow-lg sm:p-10">

        <div class="pointer-events-none absolute -right-12 -top-16 h-64 w-64 rounded-full bg-yellow-200/70"></div>
        <div class="pointer-events-none absolute -bottom-24 right-1/3 h-56 w-56 rounded-full bg-emerald-200/70"></div>

        <div class="relative z-10 grid items-center gap-7 md:grid-cols-[1fr_220px]">

            <div>
                <span class="inline-flex rounded-full border border-white bg-white/80 px-4 py-2 text-xs font-extrabold uppercase tracking-wide text-sky-700">
                    ✨ Misi Terakhir Petualangan
                </span>

                <h1 class="mt-5 max-w-2xl text-3xl font-black leading-tight text-sky-950 sm:text-4xl">
                    Yuk, Ceritakan Cara Berpikirmu!
                </h1>

                <p class="mt-4 max-w-xl text-sm leading-7 text-sky-900 sm:text-base">
                    Jawab beberapa pertanyaan berikut. Tidak perlu takut salah!
                    Ceritakan bagaimana kamu memahami dan menyelesaikan soal.
                </p>

                <div class="mt-5 flex flex-wrap gap-3">
                    <span class="rounded-full bg-white px-4 py-2 text-sm font-bold text-sky-800 shadow-sm">
                        🧠 Misi Pemahaman
                    </span>
                    <span class="rounded-full bg-white px-4 py-2 text-sm font-bold text-emerald-700 shadow-sm">
                        ⭐ Kamu Pasti Bisa!
                    </span>
                </div>
            </div>

            <div class="mx-auto flex h-40 w-40 items-center justify-center rounded-[2rem] border-4 border-white bg-gradient-to-br from-yellow-200 to-orange-200 text-7xl shadow-xl sm:h-48 sm:w-48">
                🧑‍🚀
            </div>

        </div>
    </section>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-5 text-emerald-800 shadow-sm">
            <p class="font-bold">🎉 Jawaban berhasil disimpan!</p>
            <p class="mt-1 text-sm">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('info'))
        <div class="mb-6 rounded-2xl border border-sky-200 bg-sky-50 p-5 text-sky-800 shadow-sm">
            <p class="font-bold">ℹ️ Informasi verifikasi</p>
            <p class="mt-1 text-sm">{{ session('info') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-5 text-rose-700">
            <p class="font-bold">Ada jawaban yang perlu diperiksa.</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($questions->isEmpty())

        <section class="rounded-[2rem] border-4 border-white bg-white p-8 text-center shadow-lg">
            <div class="text-6xl">🗺️</div>
            <h2 class="mt-4 text-2xl font-black text-sky-900">
                Belum Ada Misi Baru
            </h2>
            @if(isset($missingStages) && $missingStages->isNotEmpty())
                <p class="mx-auto mt-2 max-w-lg text-sm leading-6 text-amber-700">
                    Bank pertanyaan untuk sebagian tahap Newman belum tersedia. Guru perlu memeriksa hasil analisis atau melengkapi bank pertanyaan.
                </p>
            @else
                <p class="mx-auto mt-2 max-w-lg text-sm leading-6 text-gray-500">
                    Saat ini tidak ada bukti tambahan yang perlu kamu lengkapi. Tahap yang masih membutuhkan peninjauan akan diperiksa oleh guru.
                </p>
            @endif
            <a href="{{ route('student.dashboard') }}"
               class="mt-6 inline-flex rounded-full bg-sky-500 px-6 py-3 font-bold text-white shadow-md transition hover:bg-sky-600">
                Kembali ke Beranda →
            </a>
        </section>

    @else

        {{-- PROGRESS --}}
        <section class="mb-7 rounded-[1.8rem] border-2 border-white bg-white p-6 shadow-md">

            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-widest text-sky-500">
                        PROGRES MISI
                    </span>
                    <h2 class="mt-1 text-xl font-black text-sky-950">
                        Perjalanan Pemahamanmu
                    </h2>
                </div>

                <span class="rounded-full bg-emerald-100 px-4 py-2 text-sm font-extrabold text-emerald-700">
                    {{ $answeredCount }}/{{ $questionCount }} Terjawab
                </span>
            </div>

            <div class="mt-5 h-4 overflow-hidden rounded-full bg-slate-100">
                <div class="h-full rounded-full bg-gradient-to-r from-cyan-400 to-emerald-400 transition-all duration-500"
                     style="width: {{ $questionCount > 0 ? ($answeredCount / $questionCount) * 100 : 0 }}%">
                </div>
            </div>

            <p class="mt-2 text-xs font-semibold text-gray-400">
                Terus semangat! Setiap jawaban membantumu belajar lebih baik 🌱
            </p>

        </section>

        {{-- TAHAPAN NEWMAN --}}
        <section class="mb-7">
            <div class="mb-4">
                <span class="text-xs font-extrabold uppercase tracking-widest text-violet-500">
                    PETA PETUALANGAN
                </span>
                <h2 class="mt-1 text-2xl font-black text-sky-950">
                    Tahapan Berpikir 🧩
                </h2>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
                @foreach([
                    ['reading', 'Membaca', '📖', 'bg-sky-100'],
                    ['comprehension', 'Memahami', '💡', 'bg-violet-100'],
                    ['transformation', 'Mengubah', '🔄', 'bg-amber-100'],
                    ['process_skills', 'Menghitung', '🧮', 'bg-emerald-100'],
                    ['encoding', 'Menjawab', '✍️', 'bg-pink-100'],
                ] as [$stage, $label, $icon, $color])
                    <div class="rounded-2xl border-2 border-white {{ $color }} p-4 text-center shadow-sm">
                        <div class="text-3xl">{{ $icon }}</div>
                        <p class="mt-2 text-xs font-extrabold text-slate-700">
                            {{ $label }}
                        </p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- FORM VERIFIKASI --}}
       {{-- FORM VERIFIKASI --}}
@if($analysis->reviewed_at !== null)

    <div class="mb-6 rounded-2xl border-2 border-emerald-200 bg-emerald-50 p-6 shadow-sm">
        <div class="flex items-start gap-4">
            <div class="text-4xl">🏆</div>
            <div>
                <h2 class="text-lg font-black text-emerald-900">
                    Misi Verifikasi Selesai!
                </h2>
                <p class="mt-2 text-sm leading-6 text-emerald-800">
                    Hebat! Guru sudah memeriksa jawabanmu.
                    Kamu tidak perlu mengisi atau mengirim jawaban ini lagi.
                </p>
            </div>
        </div>
    </div>

@else

<form method="POST"
      action="{{ route('student.verifications.store', $analysis) }}">
            @csrf

            <div class="mb-5 flex items-center justify-between gap-3">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-widest text-emerald-600">
                        ZONA TANTANGAN
                    </span>
                    <h2 class="mt-1 text-2xl font-black text-sky-950">
                        Jawab Pertanyaannya!
                    </h2>
                </div>
                <span class="text-3xl">🎯</span>
            </div>

            <div class="space-y-5">

                @foreach($questions as $question)

                    @php
                        $stage = $question->target_stage;
                        $label = $stageLabels[$stage] ?? ucfirst(str_replace('_', ' ', $stage));
                        $icon = $stageIcons[$stage] ?? '⭐';
                        $color = $stageColors[$stage] ?? 'bg-sky-100 text-sky-700';

                        $savedResponse = old(
                            'responses.'.$question->id,
                            $responses->get($question->id)?->response_text
                        );
                    @endphp

                    <article class="overflow-hidden rounded-[1.8rem] border-2 border-white bg-white shadow-md transition duration-300 hover:-translate-y-1 hover:shadow-lg">

                        <div class="flex items-center justify-between gap-3 border-b border-slate-100 bg-gradient-to-r from-sky-50 to-violet-50 p-5 sm:p-6">

                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl {{ $color }} text-2xl">
                                    {{ $icon }}
                                </div>

                                <div>
                                    <span class="text-xs font-extrabold uppercase tracking-wider text-sky-500">
                                        Tantangan {{ $loop->iteration }}
                                    </span>
                                    <h3 class="font-black text-sky-950">
                                        {{ $label }}
                                    </h3>
                                </div>
                            </div>

                            <span class="rounded-full bg-white px-3 py-1 text-xs font-bold text-sky-600 shadow-sm">
                                ⭐ {{ $loop->iteration }}
                            </span>

                        </div>

                        <div class="p-5 sm:p-7">

                            <h4 class="text-base font-bold leading-7 text-slate-800 sm:text-lg">
                                {{ $question->question_text }}
                            </h4>

                            @if($question->response_type === 'multiple_choice')

                                <div class="mt-5 grid gap-3 sm:grid-cols-2">

                                    @foreach($question->options ?? [] as $option)

                                        @php
                                            $optionValue = is_array($option)
                                                ? ($option['value'] ?? $option['label'] ?? '')
                                                : $option;

                                            $optionLabel = is_array($option)
                                                ? ($option['label'] ?? $optionValue)
                                                : $option;
                                        @endphp

                                        <label class="group flex cursor-pointer items-center gap-3 rounded-2xl border-2 border-slate-100 bg-slate-50 p-4 transition hover:border-cyan-300 hover:bg-cyan-50 has-[:checked]:border-emerald-400 has-[:checked]:bg-emerald-50">

                                            <input
                                                type="radio"
                                                name="responses[{{ $question->id }}]"
                                                value="{{ $optionValue }}"
                                                required
                                                @checked($savedResponse == $optionValue)
                                                class="h-5 w-5 accent-emerald-500"
                                            >

                                            <span class="font-semibold text-slate-700 group-hover:text-sky-800">
                                                {{ $optionLabel }}
                                            </span>

                                        </label>

                                    @endforeach

                                </div>

                            @else

                                <div class="mt-5 rounded-2xl bg-amber-50 p-4 sm:p-5">

                                    <label for="response-{{ $question->id }}"
                                           class="mb-3 block text-sm font-extrabold text-amber-900">
                                        ✏️ Tuliskan jawabanmu di sini
                                    </label>

                                    <textarea
                                        id="response-{{ $question->id }}"
                                        name="responses[{{ $question->id }}]"
                                        rows="4"
                                        required
                                        maxlength="5000"
                                        class="w-full rounded-2xl border-2 border-amber-100 bg-white p-4 text-sm leading-7 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-amber-400 focus:ring-4 focus:ring-amber-100"
                                        placeholder="Ceritakan jawabanmu dengan bahasamu sendiri..."
                                    >{{ $savedResponse }}</textarea>

                                    <p class="mt-2 text-xs text-amber-700">
                                        💡 Tidak perlu takut salah. Ceritakan apa yang kamu pikirkan!
                                    </p>

                                </div>

                            @endif

                            @error('responses.'.$question->id)
                                <p class="mt-3 rounded-xl bg-rose-50 p-3 text-sm font-semibold text-rose-600">
                                    ⚠️ {{ $message }}
                                </p>
                            @enderror

                            @if(filled($responses->get($question->id)?->response_text))
                                <p class="mt-4 text-xs font-bold text-emerald-600">
                                    ✓ Jawaban sebelumnya sudah tersimpan
                                </p>
                            @endif

                        </div>
                    </article>

                @endforeach

            </div>

            {{-- PESAN PENYEMANGAT --}}
            <div class="mt-7 rounded-[1.8rem] border-2 border-white bg-gradient-to-r from-yellow-100 to-orange-100 p-6 shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="text-4xl">🌟</div>
                    <div>
                        <h3 class="font-black text-orange-900">
                            Kamu Hebat Sudah Sampai di Sini!
                        </h3>
                        <p class="mt-1 text-sm leading-6 text-orange-800">
                            Jawabanmu akan membantu guru memahami cara kamu berpikir.
                            Periksa kembali jawaban sebelum menyimpannya, ya!
                        </p>
                    </div>
                </div>
            </div>

            {{-- SIMPAN --}}
            <button
                type="submit"
                class="mt-6 flex w-full items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-cyan-500 to-emerald-400 px-7 py-4 text-base font-black text-white shadow-lg shadow-cyan-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-cyan-200"
            >
                💾 Simpan Jawaban Verifikasi
                <span>→</span>
            </button>

        </form>

    @endif
  @endif
</div>
@endsection
