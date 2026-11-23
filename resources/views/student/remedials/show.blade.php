
@extends('layouts.student')

@section('title', $material->title)

@section('content')

<section class="mx-auto max-w-6xl px-4 py-7 sm:px-6 lg:px-8">

    {{-- NAVIGASI --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('student.topics.show', $material->topic_id) }}"
           class="inline-flex items-center gap-2 rounded-full border border-white bg-white px-5 py-3 text-sm font-bold text-sky-700 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
            <span class="text-lg">←</span>
            Kembali ke Petualangan
        </a>

        <span class="rounded-full bg-amber-100 px-4 py-2 text-xs font-extrabold text-amber-700">
            ⭐ MISI BELAJAR KEMBALI
        </span>
    </div>

    {{-- HERO --}}
    <div class="relative isolate overflow-hidden rounded-[2rem] border-4 border-white bg-gradient-to-br from-cyan-200 via-sky-100 to-violet-200 p-7 shadow-[0_12px_25px_rgba(14,116,144,0.12)] sm:p-10">

        <div class="pointer-events-none absolute -right-12 -top-16 h-64 w-64 rounded-full bg-yellow-200/70"></div>
        <div class="pointer-events-none absolute -bottom-28 right-1/3 h-64 w-64 rounded-full bg-emerald-200/70"></div>
        <div class="pointer-events-none absolute right-8 top-10 rotate-12 text-5xl opacity-70">✨</div>
        <div class="pointer-events-none absolute bottom-8 right-1/3 text-4xl opacity-60">➕</div>

        <div class="relative z-10 grid items-center gap-8 md:grid-cols-[1fr_220px]">

            <div>
                <span class="inline-flex items-center gap-2 rounded-full border border-white/80 bg-white/80 px-4 py-2 text-xs font-extrabold tracking-wide text-sky-700">
                    🌱 SAATNYA TUMBUH LEBIH HEBAT
                </span>

                <h1 class="mt-5 max-w-2xl text-3xl font-black leading-tight text-sky-950 sm:text-4xl lg:text-5xl">
                    {{ $material->title }}
                </h1>

                <p class="mt-4 max-w-2xl text-sm font-medium leading-7 text-sky-900 sm:text-base">
                    {{ $material->description ?: 'Yuk, pelajari kembali materi ini. Setiap langkah kecil membuatmu semakin pintar!' }}
                </p>

                <div class="mt-6 flex flex-wrap gap-2">
                    <span class="rounded-full border border-white bg-white px-4 py-2 text-xs font-bold text-sky-800 shadow-sm">
                        🎒 Kelas {{ $material->topic->grade_level }}
                    </span>

                    <span class="rounded-full border border-white bg-white px-4 py-2 text-xs font-bold text-emerald-800 shadow-sm">
                        📚 {{ $material->topic->title }}
                    </span>

                    <span class="rounded-full border border-white bg-white px-4 py-2 text-xs font-bold text-orange-700 shadow-sm">
                        ✏️ {{ $material->exercises->count() }} Soal Latihan
                    </span>
                </div>
            </div>

            <div class="relative mx-auto flex h-48 w-48 items-center justify-center rounded-[2.5rem] border-4 border-white bg-gradient-to-br from-yellow-100 to-orange-200 text-8xl shadow-xl md:h-52 md:w-52">
                📖
                <span class="absolute -right-4 -top-4 flex h-14 w-14 items-center justify-center rounded-2xl border-4 border-white bg-emerald-300 text-2xl shadow-lg">⭐</span>
                <span class="absolute -bottom-3 -left-4 flex h-12 w-12 items-center justify-center rounded-2xl border-4 border-white bg-pink-200 text-xl shadow-lg">✏️</span>
            </div>

        </div>
    </div>

    {{-- PROGRES BELAJAR --}}
    <div class="mt-7 rounded-[1.75rem] border border-white bg-white p-5 shadow-sm sm:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="text-xs font-extrabold tracking-widest text-cyan-600">PETA PETUALANGAN</p>
                <h2 class="mt-1 text-lg font-black text-slate-800">Tiga Langkah Menjadi Hebat!</h2>
            </div>
            <span class="rounded-full bg-emerald-100 px-4 py-2 text-xs font-extrabold text-emerald-700">
                🚀 Kamu pasti bisa!
            </span>
        </div>

        <div class="mt-5 grid grid-cols-3 gap-3">
            <div class="rounded-2xl border-2 border-sky-100 bg-sky-50 p-3 text-center">
                <div class="text-3xl">📖</div>
                <p class="mt-2 text-xs font-extrabold text-sky-800">Pelajari</p>
            </div>
            <div class="rounded-2xl border-2 border-violet-100 bg-violet-50 p-3 text-center">
                <div class="text-3xl">💡</div>
                <p class="mt-2 text-xs font-extrabold text-violet-800">Pahami</p>
            </div>
            <div class="rounded-2xl border-2 border-emerald-100 bg-emerald-50 p-3 text-center">
                <div class="text-3xl">🏆</div>
                <p class="mt-2 text-xs font-extrabold text-emerald-800">Berlatih</p>
            </div>
        </div>
    </div>

    {{-- MATERI UTAMA --}}
    <div class="mt-8">
        <div class="mb-5">
            <span class="text-xs font-extrabold tracking-widest text-emerald-600">🌈 ZONA BELAJAR</span>
            <h2 class="mt-2 text-2xl font-black text-slate-900 sm:text-3xl">Ayo Pahami Materinya!</h2>
            <p class="mt-2 text-sm text-slate-500">Baca perlahan dan pahami setiap penjelasan berikut.</p>
        </div>

        <div class="overflow-hidden rounded-[2rem] border-2 border-white bg-white shadow-[0_10px_25px_rgba(14,116,144,0.08)]">

            <div class="flex items-center gap-4 bg-gradient-to-r from-emerald-400 to-teal-300 px-6 py-5 sm:px-8">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border-2 border-white bg-white/90 text-3xl shadow-sm">
                    📚
                </div>
                <div>
                    <p class="text-xs font-extrabold tracking-widest text-emerald-950/70">MISI PERTAMA</p>
                    <h3 class="text-xl font-black text-emerald-950">Mari Belajar!</h3>
                </div>
            </div>

            <div class="p-6 sm:p-9">
                <div class="whitespace-pre-line text-sm leading-8 text-slate-700 sm:text-base sm:leading-9">{{ $material->content }}</div>
            </div>
        </div>
    </div>

    {{-- CONTOH DAN PEMBAHASAN --}}
    @if($material->example_content)
        <div class="mt-7 overflow-hidden rounded-[2rem] border-2 border-white bg-white shadow-[0_10px_25px_rgba(14,116,144,0.08)]">

            <div class="flex items-center gap-4 bg-gradient-to-r from-amber-200 to-yellow-100 px-6 py-5 sm:px-8">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border-2 border-white bg-white/90 text-3xl shadow-sm">
                    🧠
                </div>
                <div>
                    <p class="text-xs font-extrabold tracking-widest text-amber-800">MISI KEDUA</p>
                    <h3 class="text-xl font-black text-amber-950">Contoh Soal dan Pembahasan</h3>
                </div>
            </div>

            <div class="p-6 sm:p-9">
                <div class="whitespace-pre-line text-sm leading-8 text-slate-700 sm:text-base sm:leading-9">{{ $material->example_content }}</div>
            </div>
        </div>
    @endif

    {{-- PERSIAPAN LATIHAN --}}
    <div class="relative mt-8 overflow-hidden rounded-[2rem] border-4 border-white bg-gradient-to-br from-violet-200 via-pink-100 to-orange-100 p-6 shadow-[0_12px_25px_rgba(139,92,246,0.10)] sm:p-9">

        <div class="pointer-events-none absolute -right-12 -top-12 h-48 w-48 rounded-full bg-white/40"></div>
        <div class="pointer-events-none absolute bottom-0 right-1/3 text-5xl opacity-40">⭐</div>

        <div class="relative z-10">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <span class="rounded-full bg-white/80 px-4 py-2 text-xs font-extrabold text-violet-700">
                        🏆 MISI TERAKHIR
                    </span>

                    <h2 class="mt-4 text-2xl font-black text-violet-950 sm:text-3xl">
                        Sudah Siap Berlatih?
                    </h2>

                    <p class="mt-3 max-w-xl text-sm leading-7 text-violet-900">
                        Sekarang waktunya menunjukkan kemampuanmu! Kerjakan latihan dengan teliti dan buktikan bahwa kamu semakin memahami materi.
                    </p>
                </div>

                <div class="flex h-28 w-28 shrink-0 items-center justify-center self-center rounded-[2rem] border-4 border-white bg-white/80 text-6xl shadow-lg sm:h-32 sm:w-32">
                    🎯
                </div>
            </div>

            <div class="mt-6 flex flex-wrap items-center justify-between gap-4 rounded-2xl border border-white bg-white/80 p-5">
                <div>
                    <p class="font-black text-violet-950">Latihan Remediasi</p>
                    <p class="mt-1 text-sm text-violet-700">Ada {{ $material->exercises->count() }} soal yang menantimu!</p>
                </div>
                <span class="rounded-full bg-amber-100 px-4 py-2 text-sm font-extrabold text-amber-800">
                    ✏️ Ayo mencoba!
                </span>
            </div>

            @if($material->exercises->count() > 0)
                <form action="{{ route('student.remedials.attempts.start', $material) }}"
                      method="POST"
                      class="mt-6">
                    @csrf

                    @if($recommendation)
                        <input type="hidden" name="recommendation_id" value="{{ $recommendation->id }}">
                    @endif

                    <button type="submit"
                            class="inline-flex w-full items-center justify-center gap-3 rounded-2xl border-b-4 border-emerald-700 bg-gradient-to-r from-emerald-500 to-teal-400 px-7 py-4 text-base font-black text-white shadow-lg transition hover:-translate-y-1 hover:shadow-xl active:translate-y-0 sm:w-auto">
                        🚀 Mulai Latihan Sekarang
                        <span class="text-xl">→</span>
                    </button>
                </form>
            @else
                <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 p-5 text-sm font-semibold text-amber-800">
                    🌱 Latihan untuk materi ini belum tersedia. Kamu tetap bisa mempelajari materi di atas terlebih dahulu.
                </div>
            @endif

        </div>
    </div>

    {{-- MOTIVASI --}}
    <div class="mt-7 flex items-center gap-4 rounded-2xl border-2 border-emerald-100 bg-emerald-50 p-5">
        <div class="text-4xl">🐣</div>
        <div>
            <h3 class="font-black text-emerald-900">Jangan menyerah, petualang!</h3>
            <p class="mt-1 text-sm leading-6 text-emerald-800">
                Belajar kembali bukan berarti gagal. Setiap usaha membuatmu semakin dekat dengan keberhasilan!
            </p>
        </div>
    </div>

</section>

@endsection
