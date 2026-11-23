
@extends('layouts.student')

@section('title', $topic->title)

@section('content')

<div class="student-learning-page mx-auto max-w-7xl px-4 py-6 md:px-7 md:py-9">

    {{-- NAVIGASI --}}
    <a href="{{ route('student.topics.index', $topic->learning_domain_id) }}"
       class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-bold text-sky-700 shadow-sm ring-1 ring-sky-100 transition hover:-translate-x-1 hover:bg-sky-50">
        <span class="text-lg">←</span>
        Kembali ke Dunia Pembelajaran
    </a>

    {{-- HERO PEMBELAJARAN --}}
    <section class="relative mt-6 overflow-hidden rounded-[2rem] border-4 border-white bg-gradient-to-br from-cyan-200 via-sky-100 to-emerald-100 p-6 shadow-xl shadow-sky-100 md:p-9">

        <div class="pointer-events-none absolute -right-12 -top-16 h-64 w-64 rounded-full bg-yellow-200/70"></div>
        <div class="pointer-events-none absolute -bottom-28 right-1/4 h-64 w-64 rounded-full bg-emerald-200/50"></div>

        <div class="relative z-10 grid items-center gap-6 md:grid-cols-[1.5fr_0.8fr]">

            <div>
                <span class="inline-flex items-center gap-2 rounded-full border border-white bg-white/80 px-4 py-2 text-xs font-black tracking-wide text-sky-700">
                    ✨ MISI NUMERASI DIMULAI
                </span>

                <h1 class="mt-5 max-w-2xl text-3xl font-black leading-tight text-sky-950 md:text-5xl">
                    {{ $topic->title }}
                </h1>

                <p class="mt-4 max-w-xl text-sm font-medium leading-7 text-sky-900 md:text-base">
                    {{ $topic->description ?: 'Ayo belajar, bermain, dan menaklukkan tantangan numerasi bersama NUMERA SMART!' }}
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    <span class="rounded-2xl bg-white px-4 py-3 text-sm font-bold text-sky-800 shadow-sm">
                        🎒 Kelas {{ $topic->grade_level }}
                    </span>
                    <span class="rounded-2xl bg-white px-4 py-3 text-sm font-bold text-emerald-800 shadow-sm">
                        ⭐ Ayo belajar!
                    </span>
                </div>
            </div>

            <div class="relative flex min-h-48 items-center justify-center">
                <div class="absolute h-44 w-44 rounded-full bg-white/60 md:h-56 md:w-56"></div>

                <div class="relative flex h-36 w-36 items-center justify-center rounded-[2.5rem] border-4 border-white bg-gradient-to-br from-emerald-300 to-cyan-400 text-7xl shadow-xl md:h-48 md:w-48 md:text-8xl">
                    🧮
                </div>

                <span class="absolute right-3 top-3 rotate-12 rounded-2xl bg-yellow-300 px-4 py-2 text-2xl shadow-lg">✨</span>
                <span class="absolute bottom-3 left-3 -rotate-12 rounded-2xl bg-white px-4 py-2 text-2xl shadow-lg">➕</span>
            </div>

        </div>
    </section>

    {{-- INFORMASI TOPIK --}}
    <section class="mt-7 grid gap-4 sm:grid-cols-2">

        <div class="flex items-center gap-4 rounded-3xl border-2 border-sky-100 bg-white p-5 shadow-sm">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-sky-100 text-3xl">
                🎓
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-sky-500">Petualang</p>
                <h2 class="mt-1 text-xl font-black text-slate-800">Kelas {{ $topic->grade_level }}</h2>
            </div>
        </div>

        <div class="flex items-center gap-4 rounded-3xl border-2 border-amber-100 bg-white p-5 shadow-sm">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-100 text-3xl">
                📝
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-amber-600">Tantangan tersedia</p>
                <h2 class="mt-1 text-xl font-black text-slate-800">
                    {{ $topic->available_questions_count }} Soal
                </h2>
            </div>
        </div>

    </section>

    {{-- MATERI PEMBELAJARAN --}}
    @if($topic->learningMaterial)

        <section class="mt-9">

            <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <span class="text-xs font-black tracking-widest text-emerald-600">📚 ZONA BELAJAR</span>
                   <h2 class="mt-2 text-2xl font-black text-slate-800 md:text-3xl">
    Materi Pembelajaran
</h2>
<p class="mt-2 text-sm text-slate-500">
    Ayo pahami materinya sebelum memulai tantangan!
</p>
                    <p class="mt-2 text-sm text-slate-500">
                        Pelajari setiap bagian sebelum memulai tantangan.
                    </p>
                </div>

                <span class="rounded-full bg-emerald-100 px-4 py-2 text-sm font-bold text-emerald-700">
                    ⏱️ {{ $topic->learningMaterial->estimated_minutes }} menit
                </span>
            </div>

            {{-- KOMPETENSI --}}
            @if($topic->learningMaterial->competency)
                <div class="relative overflow-hidden rounded-3xl border-2 border-emerald-100 bg-gradient-to-r from-emerald-50 to-cyan-50 p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white text-2xl shadow-sm">
                            🏆
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-emerald-900">Misi yang Akan Kamu Kuasai</h3>
                            <p class="mt-2 text-sm leading-7 text-emerald-900">
                                {{ $topic->learningMaterial->competency }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- TUJUAN PEMBELAJARAN --}}
            @if(count($topic->learningMaterial->objectives ?? []) > 0)
                <div class="mt-5 rounded-3xl border-2 border-violet-100 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">🎯</span>
                        <h3 class="text-xl font-black text-slate-800">Target Petualanganmu</h3>
                    </div>

                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        @foreach(($topic->learningMaterial->objectives ?? []) as $objective)
                            <div class="flex items-start gap-3 rounded-2xl bg-violet-50 p-4">
                                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-violet-200 text-sm font-black text-violet-800">
                                    ✓
                                </span>
                                <p class="text-sm font-medium leading-6 text-slate-700">
                                    {{ $objective }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ISI MATERI --}}
            <div class="mt-5 overflow-hidden rounded-3xl border-2 border-sky-100 bg-white shadow-sm">

                <div class="flex items-center gap-4 bg-gradient-to-r from-sky-100 to-cyan-50 p-6">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-3xl shadow-sm">
                        📖
                    </div>
                    <div>
                        <span class="text-xs font-black tracking-widest text-sky-600">LEVEL 01</span>
                        <h3 class="mt-1 text-xl font-black text-sky-950">Mari Memahami</h3>
                    </div>
                </div>

                <div class="p-6 md:p-8">
                    <div class="rounded-2xl bg-slate-50 p-5 md:p-7">
                        <p class="whitespace-pre-line text-sm leading-8 text-slate-700 md:text-base">
                            {{ $topic->learningMaterial->content }}
                        </p>
                    </div>
                </div>

            </div>

            {{-- CONTOH DAN PEMBAHASAN --}}
            @if($topic->learningMaterial->example_content)
                <div class="mt-5 overflow-hidden rounded-3xl border-2 border-amber-200 bg-white shadow-sm">

                    <div class="flex items-center gap-4 bg-gradient-to-r from-amber-100 to-yellow-50 p-6">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-3xl shadow-sm">
                            💡
                        </div>
                        <div>
                            <span class="text-xs font-black tracking-widest text-amber-700">LEVEL 02</span>
                            <h3 class="mt-1 text-xl font-black text-amber-950">Contoh Soal dan Pembahasan</h3>
                        </div>
                    </div>

                    <div class="p-6 md:p-8">
                        <div class="rounded-2xl bg-amber-50 p-5 md:p-7">
                            <p class="whitespace-pre-line text-sm leading-8 text-amber-950 md:text-base">
                                {{ $topic->learningMaterial->example_content }}
                            </p>
                        </div>
                    </div>

                </div>
            @endif

            {{-- REFLEKSI --}}
            @if($topic->learningMaterial->practice_prompt)
                <div class="mt-5 rounded-3xl border-2 border-pink-100 bg-gradient-to-r from-pink-50 to-violet-50 p-6 md:p-8">
                    <div class="flex items-start gap-4">
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white text-3xl shadow-sm">
                            🤔
                        </div>
                        <div>
                            <span class="text-xs font-black tracking-widest text-pink-600">LEVEL 03</span>
                            <h3 class="mt-1 text-xl font-black text-slate-800">Coba Pikirkan!</h3>
                            <p class="mt-3 whitespace-pre-line text-sm leading-7 text-slate-700">
                                {{ $topic->learningMaterial->practice_prompt }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

        </section>

    @else

        <div class="mt-8 rounded-3xl border-2 border-dashed border-amber-300 bg-amber-50 p-7">
            <div class="flex items-center gap-4">
                <span class="text-4xl">🚧</span>
                <div>
                    <h2 class="text-xl font-black text-amber-900">Materi Sedang Disiapkan</h2>
                    <p class="mt-2 text-sm leading-6 text-amber-800">
                        Topik ini sudah tersedia, tetapi materi pembelajarannya belum dipublikasikan.
                    </p>
                </div>
            </div>
        </div>

    @endif

    {{-- TANTANGAN ASESMEN --}}
    <section class="relative mt-9 overflow-hidden rounded-[2rem] border-4 border-white bg-gradient-to-br from-violet-500 via-indigo-500 to-blue-500 p-6 text-white shadow-xl shadow-indigo-100 md:p-9">

        <div class="absolute -right-10 -top-10 h-48 w-48 rounded-full bg-white/10"></div>
        <div class="absolute -bottom-20 left-1/3 h-52 w-52 rounded-full bg-white/10"></div>

        <div class="relative z-10 grid items-center gap-6 md:grid-cols-[1fr_auto]">
            <div>
                <span class="rounded-full bg-white/20 px-4 py-2 text-xs font-black tracking-wider">
                    ⭐ MISI BERIKUTNYA
                </span>

                <h2 class="mt-5 text-2xl font-black md:text-4xl">
                    Siap Menaklukkan Tantangan?
                </h2>

                <p class="mt-3 max-w-xl text-sm leading-7 text-indigo-50">
                    Buktikan pemahamanmu melalui soal-soal numerasi.
                    Kerjakan dengan teliti dan tunjukkan cara berpikirmu!
                </p>

                @if($topic->available_questions_count > 0)
                    <form action="{{ route('student.topics.start', $topic->id) }}" method="POST">
                        @csrf

                        <button type="submit"
                                class="mt-6 inline-flex items-center gap-3 rounded-2xl bg-yellow-300 px-7 py-4 text-base font-black text-indigo-950 shadow-lg transition hover:-translate-y-1 hover:bg-yellow-200">
                            🚀 Mulai Asesmen
                            <span>→</span>
                        </button>
                    </form>
                @else
                    <div class="mt-6 rounded-2xl bg-white/15 p-4 text-sm font-semibold">
                        🔒 Asesmen belum tersedia untuk topik ini.
                    </div>
                @endif
            </div>

            <div class="flex justify-center">
                <div class="flex h-36 w-36 items-center justify-center rounded-full border-4 border-white/50 bg-white/20 text-7xl shadow-lg">
                    🏅
                </div>
            </div>
        </div>

    </section>

    {{-- MATERI REMEDIASI --}}
    <section class="mt-10">

        <div class="mb-5">
            <span class="text-xs font-black tracking-widest text-emerald-600">🌱 TUMBUH DAN BELAJAR</span>
            <h2 class="mt-2 text-2xl font-black text-slate-800 md:text-3xl">
                Zona Belajar Kembali
            </h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">
                Tidak apa-apa jika belum berhasil. Setiap latihan membantumu menjadi lebih hebat!
            </p>
        </div>

        @if($topic->remedialMaterials->isNotEmpty())

            <div class="grid gap-5 md:grid-cols-2">
                @foreach($topic->remedialMaterials as $material)

                    <article class="overflow-hidden rounded-3xl border-2 border-emerald-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                        <div class="flex items-center justify-between bg-gradient-to-r from-emerald-100 to-teal-50 p-5">
                            <span class="text-4xl">🌱</span>
                            <span class="rounded-full bg-white px-4 py-2 text-xs font-black text-emerald-700">
                                {{ $material->active_exercises_count }} Soal
                            </span>
                        </div>

                        <div class="p-6">
                            <h3 class="text-lg font-black text-slate-800">
                                {{ $material->title }}
                            </h3>

                            <p class="mt-3 text-sm leading-7 text-slate-500">
                                {{ $material->description }}
                            </p>

                            <p class="mt-4 text-xs font-medium text-slate-400">
                                📅 Dipublikasikan {{ $material->published_at?->format('d M Y') }}
                            </p>

                            <a href="{{ route('student.remedials.show', $material) }}"
                               class="mt-5 flex w-full items-center justify-center gap-2 rounded-2xl bg-emerald-500 px-5 py-3.5 text-sm font-black text-white transition hover:bg-emerald-600">
                                📚 Pelajari Kembali →
                            </a>
                        </div>

                    </article>

                @endforeach
            </div>

        @else

            <div class="rounded-3xl border-2 border-dashed border-emerald-200 bg-emerald-50 p-7">
                <div class="flex items-center gap-4">
                    <span class="text-4xl">🌻</span>
                    <div>
                        <h3 class="font-black text-emerald-900">Kamu Tetap Bisa Terus Belajar!</h3>
                        <p class="mt-2 text-sm leading-6 text-emerald-800">
                            Belum ada materi belajar kembali untuk topik ini.
                        </p>
                    </div>
                </div>
            </div>

        @endif

    </section>

    {{-- MOTIVASI --}}
    <div class="mt-9 rounded-3xl border-2 border-yellow-100 bg-gradient-to-r from-yellow-50 to-orange-50 p-6 text-center">
        <div class="text-4xl">🌟</div>
        <h3 class="mt-3 text-lg font-black text-amber-900">
            Kamu Hebat karena Terus Mencoba!
        </h3>
        <p class="mt-2 text-sm text-amber-800">
            Satu langkah kecil hari ini membawamu lebih dekat pada pemahaman.
        </p>
    </div>

</div>

@endsection
