
@extends('layouts.student')

@section('title', 'Hasil Petualangan Belajar')

@section('content')

@php
    $correctCount = $attempt->answers->where('is_correct', true)->count();
    $wrongCount = $attempt->answers->where('is_correct', false)->count();
    $totalCount = $attempt->answers->count();

    $score = (float) $attempt->score;

    $successRate = $totalCount > 0
        ? round(($correctCount / $totalCount) * 100)
        : 0;

    if ($score >= 90) {
        $level = 'Luar Biasa!';
        $message = 'Kamu berhasil menunjukkan pemahaman yang sangat baik. Terus pertahankan semangat belajarmu!';
        $emoji = '🏆';
        $theme = 'from-yellow-200 via-amber-100 to-orange-100';
        $badge = 'bg-yellow-100 text-yellow-800';
    } elseif ($score >= 75) {
        $level = 'Hebat Sekali!';
        $message = 'Kamu sudah memahami sebagian besar materi. Sedikit latihan lagi akan membuatmu semakin hebat!';
        $emoji = '🌟';
        $theme = 'from-sky-200 via-cyan-100 to-emerald-100';
        $badge = 'bg-sky-100 text-sky-800';
    } elseif ($score >= 60) {
        $level = 'Terus Berkembang!';
        $message = 'Kamu sudah berusaha dengan baik. Pelajari kembali bagian yang belum dipahami, ya!';
        $emoji = '🌱';
        $theme = 'from-emerald-200 via-green-100 to-lime-100';
        $badge = 'bg-emerald-100 text-emerald-800';
    } else {
        $level = 'Jangan Menyerah!';
        $message = 'Tidak apa-apa jika belum berhasil. Setiap latihan adalah kesempatan untuk belajar menjadi lebih baik!';
        $emoji = '💪';
        $theme = 'from-violet-200 via-purple-100 to-pink-100';
        $badge = 'bg-violet-100 text-violet-800';
    }
@endphp

<section class="mx-auto max-w-6xl px-4 py-8">

    {{-- NAVIGASI --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">

        <a href="{{ route('student.remedials.show', $attempt->material) }}"
           class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-bold text-sky-700 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
            ← Kembali ke Materi
        </a>

        <span class="rounded-full bg-amber-100 px-5 py-2 text-xs font-bold text-amber-700">
            🏅 PENCAPAIAN BELAJAR
        </span>

    </div>

    {{-- HERO HASIL --}}
    <div class="relative mb-7 overflow-hidden rounded-[2rem] border-4 border-white bg-gradient-to-r {{ $theme }} p-7 shadow-lg sm:p-10">

        <div class="pointer-events-none absolute -right-10 -top-16 h-56 w-56 rounded-full bg-white/40"></div>
        <div class="pointer-events-none absolute -bottom-24 left-1/3 h-64 w-64 rounded-full bg-white/30"></div>

        <div class="relative z-10 grid items-center gap-8 md:grid-cols-[1fr_240px]">

            <div>

                <span class="inline-flex rounded-full border border-white bg-white/80 px-4 py-2 text-xs font-bold tracking-wide text-sky-700">
                    🎉 MISI BERHASIL DISELESAIKAN!
                </span>

                <h1 class="mt-5 text-3xl font-black leading-tight text-sky-950 sm:text-4xl">
                    Petualanganmu Selesai!
                </h1>

                <p class="mt-3 text-lg font-bold text-sky-900">
                    {{ $attempt->material->title }}
                </p>

                <p class="mt-3 max-w-xl text-sm leading-7 text-sky-900">
                    {{ $message }}
                </p>

                <div class="mt-5 flex flex-wrap gap-2">

                    <span class="rounded-full bg-white px-4 py-2 text-xs font-bold text-sky-700 shadow-sm">
                        🎒 Kelas {{ $attempt->material->topic->grade_level }}
                    </span>

                    <span class="rounded-full bg-white px-4 py-2 text-xs font-bold text-emerald-700 shadow-sm">
                        📚 {{ $attempt->material->topic->title }}
                    </span>

                    <span class="rounded-full bg-white px-4 py-2 text-xs font-bold text-orange-600 shadow-sm">
                        ✏️ {{ $totalCount }} Soal
                    </span>

                </div>

            </div>

            {{-- ILUSTRASI --}}
            <div class="mx-auto flex h-48 w-48 flex-col items-center justify-center rounded-[2rem] border-4 border-white bg-white/70 shadow-lg">

                <span class="text-7xl">{{ $emoji }}</span>

                <span class="mt-3 rounded-full px-4 py-2 text-sm font-black {{ $badge }}">
                    {{ $level }}
                </span>

            </div>

        </div>

    </div>

    {{-- NILAI --}}
    <div class="mb-7 rounded-3xl border border-sky-100 bg-white p-6 shadow-sm sm:p-8">

        <div class="text-center">

            <span class="text-xs font-bold tracking-widest text-sky-500">
                HASIL PETUALANGANMU
            </span>

            <h2 class="mt-2 text-2xl font-black text-slate-800">
                Lihat Nilai Hebatmu!
            </h2>

            <div class="mx-auto mt-7 flex h-44 w-44 flex-col items-center justify-center rounded-full border-[12px] border-emerald-100 bg-gradient-to-br from-emerald-50 to-cyan-50 shadow-inner">

                <span class="text-5xl font-black text-emerald-600">
                    {{ number_format($score, 0) }}
                </span>

                <span class="mt-1 text-sm font-bold text-slate-500">
                    Nilai Akhir
                </span>

            </div>

            <p class="mt-5 text-sm font-semibold text-slate-600">
                {{ $correctCount }} dari {{ $totalCount }} soal berhasil kamu jawab dengan benar.
            </p>

        </div>

        <div class="mt-7">

            <div class="mb-2 flex items-center justify-between text-xs font-bold">
                <span class="text-slate-500">Ketepatan Jawaban</span>
                <span class="text-emerald-600">{{ $successRate }}%</span>
            </div>

            <div class="h-4 overflow-hidden rounded-full bg-slate-100">
                <div class="h-full rounded-full bg-gradient-to-r from-emerald-400 to-teal-400"
                     style="width: {{ $successRate }}%">
                </div>
            </div>

        </div>

    </div>

    {{-- RINGKASAN STATISTIK --}}
    <div class="mb-8">

        <div class="mb-4">
            <span class="text-xs font-bold tracking-widest text-violet-500">
                📊 RINGKASAN MISI
            </span>

            <h2 class="mt-1 text-2xl font-black text-slate-800">
                Pencapaianmu!
            </h2>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">

            <div class="rounded-3xl border border-emerald-100 bg-emerald-50 p-6">

                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold text-emerald-800">Jawaban Benar</span>
                    <span class="text-3xl">✅</span>
                </div>

                <h3 class="mt-4 text-4xl font-black text-emerald-600">
                    {{ $correctCount }}
                </h3>

                <p class="mt-1 text-xs text-emerald-700">
                    Hebat! Terus pertahankan!
                </p>

            </div>

            <div class="rounded-3xl border border-rose-100 bg-rose-50 p-6">

                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold text-rose-800">Jawaban Salah</span>
                    <span class="text-3xl">💡</span>
                </div>

                <h3 class="mt-4 text-4xl font-black text-rose-600">
                    {{ $wrongCount }}
                </h3>

                <p class="mt-1 text-xs text-rose-700">
                    Bagian yang bisa kamu pelajari lagi.
                </p>

            </div>

            <div class="rounded-3xl border border-sky-100 bg-sky-50 p-6">

                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold text-sky-800">Total Soal</span>
                    <span class="text-3xl">📝</span>
                </div>

                <h3 class="mt-4 text-4xl font-black text-sky-600">
                    {{ $totalCount }}
                </h3>

                <p class="mt-1 text-xs text-sky-700">
                    Semua tantangan latihanmu.
                </p>

            </div>

        </div>

    </div>

    {{-- PEMBAHASAN --}}
    <div class="mb-5">

        <span class="text-xs font-bold tracking-widest text-orange-500">
            🔎 AYO BELAJAR DARI JAWABAN
        </span>

        <h2 class="mt-1 text-2xl font-black text-slate-800">
            Pembahasan Setiap Soal
        </h2>

        <p class="mt-2 text-sm leading-6 text-slate-500">
            Yuk, periksa kembali jawabanmu dan pahami cara mendapatkan jawaban yang benar.
        </p>

    </div>

    <div class="space-y-5">

        @foreach($attempt->answers as $index => $answer)

            @php
                $isCorrect = (bool) $answer->is_correct;

                $questionTheme = $isCorrect
                    ? 'border-emerald-200 bg-emerald-50'
                    : 'border-rose-200 bg-rose-50';
            @endphp

            <article class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm">

                {{-- HEADER SOAL --}}
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-4 sm:px-7">

                    <div class="flex items-center gap-3">

                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-sky-100 text-lg font-black text-sky-700">
                            {{ $index + 1 }}
                        </div>

                        <div>
                            <span class="text-xs font-bold tracking-wider text-sky-500">
                                PEMBAHASAN
                            </span>

                            <h3 class="font-black text-slate-800">
                                Soal {{ $index + 1 }}
                            </h3>
                        </div>

                    </div>

                    @if($isCorrect)
                        <span class="rounded-full bg-emerald-100 px-4 py-2 text-xs font-bold text-emerald-700">
                            ✓ Jawaban Benar
                        </span>
                    @else
                        <span class="rounded-full bg-rose-100 px-4 py-2 text-xs font-bold text-rose-700">
                            ✕ Perlu Dipelajari
                        </span>
                    @endif

                </div>

                <div class="p-5 sm:p-7">

                    {{-- PERTANYAAN --}}
                    <div>
                        <span class="text-xs font-bold text-sky-500">
                            PERTANYAAN
                        </span>

                        <p class="mt-2 text-base font-bold leading-7 text-slate-800">
                            {{ $answer->exercise->question_text }}
                        </p>
                    </div>

                    {{-- JAWABAN SISWA --}}
                    <div class="mt-5 rounded-2xl border p-4 {{ $questionTheme }}">

                        <span class="text-xs font-bold {{ $isCorrect ? 'text-emerald-700' : 'text-rose-700' }}">
                            JAWABANMU
                        </span>

                        <p class="mt-2 font-bold text-slate-800">
                            {{ $answer->answer_text ?: 'Belum ada jawaban' }}
                        </p>

                    </div>

                    {{-- KUNCI JAWABAN --}}
                    <div class="mt-4 rounded-2xl border border-emerald-100 bg-emerald-50 p-4">

                        <span class="text-xs font-bold text-emerald-700">
                            🌟 JAWABAN YANG BENAR
                        </span>

                        <p class="mt-2 font-bold text-emerald-900">
                            {{ $answer->exercise->correct_answer }}
                        </p>

                    </div>

                    {{-- PENJELASAN --}}
                    @if($answer->exercise->explanation)

                        <div class="mt-4 rounded-2xl border border-sky-100 bg-sky-50 p-5">

                            <div class="flex items-center gap-2">
                                <span class="text-xl">💡</span>

                                <h4 class="font-black text-sky-900">
                                    Yuk, Pahami Pembahasannya!
                                </h4>
                            </div>

                            <p class="mt-3 whitespace-pre-line text-sm leading-7 text-sky-900">
                                {{ $answer->exercise->explanation }}
                            </p>

                        </div>

                    @endif

                </div>

            </article>

        @endforeach

    </div>

    {{-- PENUTUP --}}
    <div class="relative mt-9 overflow-hidden rounded-3xl border-4 border-white bg-gradient-to-r from-cyan-100 via-emerald-100 to-yellow-100 p-7 text-center shadow-md sm:p-9">

        <div class="text-5xl">🌈</div>

        <h2 class="mt-4 text-2xl font-black text-sky-950">
            Belajar Tidak Berhenti di Sini!
        </h2>

        <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-sky-900">
            Setiap latihan membuatmu semakin pintar.
            Teruslah mencoba, jangan takut salah, dan jadilah petualang numerasi yang hebat!
        </p>

        <a href="{{ route('student.remedials.show', $attempt->material) }}"
           class="mt-6 inline-flex items-center justify-center rounded-full bg-gradient-to-r from-emerald-400 to-teal-500 px-8 py-3 font-black text-white shadow-md transition hover:-translate-y-1 hover:shadow-lg">
            Kembali ke Materi →
        </a>

    </div>

    <div class="mt-8 text-center text-xs font-medium text-slate-400">
        🌟 NUMERA SMART · Terus Belajar, Terus Bertumbuh!
    </div>

</section>

@endsection
