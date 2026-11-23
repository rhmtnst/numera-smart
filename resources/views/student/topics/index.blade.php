
@extends('layouts.student')

@section('title', $domain->name)

@section('content')

<section class="mx-auto max-w-6xl px-4 py-7 sm:px-6 lg:px-8">

    {{-- NAVIGASI --}}
    <div class="mb-6">
        <a href="{{ route('student.dashboard') }}"
           class="inline-flex items-center gap-2 rounded-full border border-white bg-white px-5 py-3 text-sm font-bold text-sky-700 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
            <span class="text-lg">←</span>
            Kembali ke Dashboard
        </a>
    </div>

    {{-- HERO DUNIA PEMBELAJARAN --}}
    <div class="relative isolate overflow-hidden rounded-[2rem] border-4 border-white bg-gradient-to-br from-cyan-200 via-sky-100 to-violet-200 p-7 shadow-[0_12px_25px_rgba(14,116,144,0.12)] sm:p-10">

        <div class="pointer-events-none absolute -right-12 -top-16 h-64 w-64 rounded-full bg-yellow-200/70"></div>
        <div class="pointer-events-none absolute -bottom-28 right-1/3 h-64 w-64 rounded-full bg-emerald-200/70"></div>
        <div class="pointer-events-none absolute right-10 top-8 rotate-12 text-5xl opacity-70">✨</div>
        <div class="pointer-events-none absolute bottom-8 right-1/3 text-4xl opacity-60">➕</div>

        <div class="relative z-10 grid items-center gap-8 md:grid-cols-[1fr_220px]">

            <div>
                <span class="inline-flex items-center gap-2 rounded-full border border-white/80 bg-white/80 px-4 py-2 text-xs font-extrabold tracking-wide text-sky-700">
                    🌈 DUNIA PETUALANGAN NUMERASI
                </span>

                <h1 class="mt-5 max-w-2xl text-3xl font-black leading-tight text-sky-950 sm:text-4xl lg:text-5xl">
                    {{ $domain->name }}
                </h1>

                <p class="mt-4 max-w-2xl text-sm font-medium leading-7 text-sky-900 sm:text-base">
                    {{ $domain->description ?: 'Jelajahi berbagai tantangan numerasi dan temukan keseruan belajar matematika!' }}
                </p>

                <div class="mt-6 flex flex-wrap gap-2">
                    <span class="rounded-full border border-white bg-white px-4 py-2 text-xs font-bold text-sky-800 shadow-sm">
                        🎒 Kelas {{ auth()->user()->studentProfile->grade_level }}
                    </span>

                    <span class="rounded-full border border-white bg-white px-4 py-2 text-xs font-bold text-emerald-800 shadow-sm">
                        📚 {{ $topics->count() }} Misi Pembelajaran
                    </span>

                    <span class="rounded-full border border-white bg-white px-4 py-2 text-xs font-bold text-orange-700 shadow-sm">
                        ⭐ Ayo berpetualang!
                    </span>
                </div>
            </div>

            <div class="relative mx-auto flex h-48 w-48 items-center justify-center rounded-[2.5rem] border-4 border-white bg-gradient-to-br from-yellow-100 to-orange-200 text-8xl shadow-xl md:h-52 md:w-52">
                @switch($domain->name)
                    @case('Operasi Hitung')
                        🧮
                        @break
                    @case('Pengukuran')
                        📏
                        @break
                    @case('Geometri')
                        📐
                        @break
                    @case('Data dan Penyajian')
                        📊
                        @break
                    @default
                        📚
                @endswitch

                <span class="absolute -right-4 -top-4 flex h-14 w-14 items-center justify-center rounded-2xl border-4 border-white bg-emerald-300 text-2xl shadow-lg">⭐</span>
                <span class="absolute -bottom-3 -left-4 flex h-12 w-12 items-center justify-center rounded-2xl border-4 border-white bg-pink-200 text-xl shadow-lg">🚀</span>
            </div>

        </div>
    </div>

    {{-- PETA PETUALANGAN --}}
    <div class="mt-7 rounded-[1.75rem] border border-white bg-white p-5 shadow-sm sm:p-6">

        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="text-xs font-extrabold tracking-widest text-cyan-600">🗺️ PETA PETUALANGAN</p>
                <h2 class="mt-1 text-lg font-black text-slate-800">
                    Pilih Misi Belajarmu!
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Selesaikan setiap misi untuk menjadi petualang numerasi hebat.
                </p>
            </div>

            <span class="rounded-full bg-emerald-100 px-4 py-2 text-xs font-extrabold text-emerald-700">
                🚀 {{ $topics->count() }} Misi Tersedia
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
                <p class="mt-2 text-xs font-extrabold text-emerald-800">Taklukkan</p>
            </div>
        </div>
    </div>

    {{-- DAFTAR TOPIK --}}
    <div class="mb-5 mt-9">
        <span class="text-xs font-extrabold tracking-widest text-emerald-600">
            🌟 ZONA MISI
        </span>

        <h2 class="mt-2 text-2xl font-black text-slate-900 sm:text-3xl">
            Ayo Mulai Petualanganmu!
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            Pilih salah satu kartu untuk membuka materi pembelajaran.
        </p>
    </div>

    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

        @forelse($topics as $index => $topic)

            @php
                $visuals = [
                    ['icon' => '🧮', 'bg' => 'from-orange-100 to-amber-200', 'badge' => 'bg-orange-100 text-orange-700', 'number' => 'bg-orange-400'],
                    ['icon' => '✖️', 'bg' => 'from-sky-100 to-cyan-200', 'badge' => 'bg-sky-100 text-sky-700', 'number' => 'bg-sky-400'],
                    ['icon' => '🔢', 'bg' => 'from-violet-100 to-purple-200', 'badge' => 'bg-violet-100 text-violet-700', 'number' => 'bg-violet-400'],
                    ['icon' => '📏', 'bg' => 'from-emerald-100 to-teal-200', 'badge' => 'bg-emerald-100 text-emerald-700', 'number' => 'bg-emerald-400'],
                    ['icon' => '📐', 'bg' => 'from-pink-100 to-rose-200', 'badge' => 'bg-pink-100 text-pink-700', 'number' => 'bg-pink-400'],
                    ['icon' => '📊', 'bg' => 'from-yellow-100 to-orange-200', 'badge' => 'bg-yellow-100 text-yellow-700', 'number' => 'bg-yellow-400'],
                ];

                $visual = $visuals[$index % count($visuals)];
            @endphp

            <a href="{{ route('student.topics.show', $topic->id) }}"
               class="group relative block overflow-hidden rounded-[2rem] border-2 border-white bg-white shadow-[0_8px_18px_rgba(14,116,144,0.08)] transition duration-300 hover:-translate-y-2 hover:shadow-[0_16px_28px_rgba(14,116,144,0.15)]">

                {{-- ILUSTRASI KARTU --}}
                <div class="relative flex h-40 items-center justify-center overflow-hidden bg-gradient-to-br {{ $visual['bg'] }}">

                    <div class="absolute -right-8 -top-10 h-36 w-36 rounded-full bg-white/30"></div>
                    <div class="absolute -bottom-14 -left-5 h-36 w-36 rounded-full bg-white/30"></div>

                    <span class="absolute left-5 top-5 rounded-full border border-white bg-white/90 px-3 py-1 text-xs font-extrabold text-slate-700 shadow-sm">
                        MISI {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </span>

                    <span class="relative z-10 text-7xl drop-shadow-lg transition duration-300 group-hover:scale-125 group-hover:rotate-6">
                        {{ $visual['icon'] }}
                    </span>

                    <span class="absolute bottom-4 right-5 rotate-12 text-2xl opacity-70">✨</span>
                    <span class="absolute bottom-5 left-7 -rotate-12 text-xl opacity-70">⭐</span>
                </div>

                {{-- INFORMASI KARTU --}}
                <div class="p-6">

                    <div class="flex items-center justify-between gap-2">
                        <span class="rounded-full px-3 py-1 text-xs font-extrabold {{ $visual['badge'] }}">
                            TOPIK {{ $index + 1 }}
                        </span>

                        <span class="text-xs font-bold text-slate-400">
                            📚 {{ $topic->available_questions_count }} Soal
                        </span>
                    </div>

                    <h3 class="mt-4 text-lg font-black leading-snug text-slate-800 transition group-hover:text-sky-700">
                        {{ $topic->title }}
                    </h3>

                    <p class="mt-2 min-h-[48px] text-sm leading-6 text-slate-500">
                        {{ $topic->description ?: 'Yuk, pelajari materi ini dan taklukkan tantangan numerasimu!' }}
                    </p>

                    <div class="mt-5 border-t border-dashed border-slate-200 pt-4">

                        <div class="flex flex-wrap items-center justify-between gap-2">
                            @if($topic->learningMaterial)
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-2 text-xs font-bold text-emerald-700">
                                    ✓ Materi tersedia
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-3 py-2 text-xs font-bold text-amber-700">
                                    ⏳ Materi disiapkan
                                </span>
                            @endif

                            <span class="inline-flex items-center gap-2 rounded-full bg-sky-500 px-4 py-2 text-xs font-extrabold text-white shadow-sm transition group-hover:bg-sky-600">
                                Mulai Misi
                                <span class="text-base">→</span>
                            </span>
                        </div>

                    </div>

                </div>

            </a>

        @empty

            <div class="col-span-full overflow-hidden rounded-[2rem] border-2 border-white bg-gradient-to-br from-sky-100 to-violet-100 p-8 text-center shadow-sm">

                <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-[2rem] border-4 border-white bg-white text-5xl shadow-md">
                    📚
                </div>

                <h3 class="mt-5 text-xl font-black text-slate-800">
                    Petualangan Belum Dimulai!
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm leading-7 text-slate-600">
                    Belum ada topik aktif untuk kelasmu. Hubungi guru atau administrator sekolah agar misi pembelajaran segera tersedia.
                </p>

                <a href="{{ route('student.dashboard') }}"
                   class="mt-6 inline-flex items-center gap-2 rounded-2xl bg-sky-500 px-6 py-3 font-extrabold text-white shadow-md transition hover:-translate-y-1 hover:bg-sky-600">
                    ← Kembali ke Dashboard
                </a>

            </div>

        @endforelse

    </div>

    {{-- MOTIVASI --}}
    <div class="mt-8 flex items-center gap-4 rounded-2xl border-2 border-emerald-100 bg-emerald-50 p-5">
        <div class="text-4xl">🐣</div>
        <div>
            <h3 class="font-black text-emerald-900">Kamu pasti bisa!</h3>
            <p class="mt-1 text-sm leading-6 text-emerald-800">
                Setiap topik adalah petualangan baru. Terus belajar, terus mencoba, dan jangan takut salah!
            </p>
        </div>
    </div>

</section>

@endsection
