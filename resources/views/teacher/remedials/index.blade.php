
@extends('layouts.teacher')

@section('title', 'Kelola Materi Remediasi')

@section('content')

<style>
    .remedial-float {
        animation: remedialFloat 4s ease-in-out infinite;
    }

    .remedial-float-delay {
        animation: remedialFloat 5s ease-in-out infinite;
        animation-delay: .7s;
    }

    .remedial-sparkle {
        animation: remedialSparkle 2.5s ease-in-out infinite;
        transform-box: fill-box;
        transform-origin: center;
    }

    .remedial-card {
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .remedial-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 35px rgba(25, 110, 170, .10);
    }

    @keyframes remedialFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    @keyframes remedialSparkle {
        0%, 100% { opacity: .55; transform: scale(.9) rotate(0deg); }
        50% { opacity: 1; transform: scale(1.15) rotate(12deg); }
    }

    @media (prefers-reduced-motion: reduce) {
        .remedial-float,
        .remedial-float-delay,
        .remedial-sparkle {
            animation: none !important;
        }
    }
</style>

<div class="relative mx-auto max-w-7xl space-y-7 overflow-hidden">

    {{-- DEKORASI --}}
    <div class="pointer-events-none absolute -right-20 top-20 h-64 w-64 rounded-full bg-cyan-200/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-20 top-[35rem] h-64 w-64 rounded-full bg-blue-200/20 blur-3xl"></div>


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
                    Materi Remediasi
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-7 text-white/90 md:text-base">
                    Bantu siswa memahami konsep numerasi melalui materi tambahan,
                    latihan bertahap, dan pembelajaran yang sesuai kebutuhan mereka.
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('teacher.remedials.create') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-bold text-blue-600 shadow-lg transition hover:-translate-y-1 hover:shadow-xl">
                        <span class="text-lg">+</span>
                        Tambah Materi
                    </a>

                    <div class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/15 px-5 py-3 text-sm font-semibold backdrop-blur">
                        <span>💡</span>
                        Pembelajaran lebih terarah
                    </div>
                </div>
            </div>

            {{-- ILUSTRASI ANIMASI --}}
            <div class="mx-auto hidden h-48 w-full max-w-[230px] lg:block">
                <svg viewBox="0 0 240 190"
                     class="h-full w-full"
                     xmlns="http://www.w3.org/2000/svg"
                     role="img"
                     aria-label="Ilustrasi buku pembelajaran remediasi">

                    <circle cx="120" cy="96" r="85" fill="white" fill-opacity=".10"/>

                    <g class="remedial-sparkle" fill="#FFF1A8">
                        <path d="M38 25 L43 37 L55 42 L43 47 L38 59 L33 47 L21 42 L33 37 Z"/>
                    </g>

                    <g class="remedial-sparkle" fill="white" style="animation-delay:.8s">
                        <path d="M199 28 L203 38 L213 42 L203 46 L199 56 L195 46 L185 42 L195 38 Z"/>
                    </g>

                    <g class="remedial-float" transform="translate(35 45)">
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

                    <g class="remedial-float-delay" transform="translate(157 112)">
                        <circle cx="24" cy="24" r="21" fill="#FFF1A8"/>
                        <path d="M24 10 V25 L34 31" stroke="#D28B00" stroke-width="4" stroke-linecap="round" fill="none"/>
                    </g>
                </svg>
            </div>

        </div>
    </section>


    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-5 text-emerald-700 shadow-sm">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-xl">✓</span>
            <div>
                <p class="font-bold">Berhasil</p>
                <p class="mt-1 text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center gap-3 rounded-2xl border border-red-200 bg-red-50 p-5 text-red-700 shadow-sm">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-xl">!</span>
            <div>
                <p class="font-bold">Terjadi Kesalahan</p>
                <p class="mt-1 text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-5 text-red-700 shadow-sm">
            <p class="font-bold">Periksa kembali data berikut:</p>
            <ul class="mt-2 list-inside list-disc space-y-1 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- JUDUL RINGKASAN --}}
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <p class="text-xs font-bold uppercase tracking-[.18em] text-blue-500">Ringkasan Aktivitas</p>
            <h2 class="mt-1 text-xl font-extrabold text-slate-800">Statistik Materi Remediasi</h2>
            <p class="mt-1 text-sm text-slate-500">Pantau pengelolaan materi pembelajaran tambahan.</p>
        </div>

        <span class="rounded-full border border-blue-100 bg-white px-4 py-2 text-xs font-semibold text-blue-600 shadow-sm">
            Data NUMERA SMART
        </span>
    </div>


    {{-- STATISTIK --}}
    <section class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">

        <div class="relative overflow-hidden rounded-[23px] border border-blue-100 bg-white p-6 shadow-sm">
            <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-blue-100/70"></div>

            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Materi</p>
                    <p class="mt-3 text-4xl font-extrabold text-blue-600">{{ $materials->total() }}</p>
                    <p class="mt-2 text-xs text-slate-400">Seluruh materi remediasi</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-500 text-xl text-white shadow-lg shadow-blue-200">
                    📚
                </div>
            </div>

            <div class="mt-5 h-1.5 overflow-hidden rounded-full bg-blue-50">
                <div class="h-full w-full rounded-full bg-blue-500"></div>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-[23px] border border-emerald-100 bg-white p-6 shadow-sm">
            <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-emerald-100/70"></div>

            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Materi Dipublikasikan</p>
                    <p class="mt-3 text-4xl font-extrabold text-emerald-500">
                        {{ $materials->getCollection()->where('status', 'published')->count() }}
                    </p>
                    <p class="mt-2 text-xs text-slate-400">Materi yang sudah tersedia</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-500 text-xl text-white shadow-lg shadow-emerald-200">
                    ✓
                </div>
            </div>

            <div class="mt-5 h-1.5 overflow-hidden rounded-full bg-emerald-50">
                <div class="h-full w-full rounded-full bg-emerald-400"></div>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-[23px] border border-amber-100 bg-white p-6 shadow-sm">
            <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-amber-100/70"></div>

            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Materi Draft</p>
                    <p class="mt-3 text-4xl font-extrabold text-amber-500">
                        {{ $materials->getCollection()->where('status', 'draft')->count() }}
                    </p>
                    <p class="mt-2 text-xs text-slate-400">Materi belum dipublikasikan</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-500 text-xl text-white shadow-lg shadow-amber-200">
                    ✎
                </div>
            </div>

            <div class="mt-5 h-1.5 overflow-hidden rounded-full bg-amber-50">
                <div class="h-full w-full rounded-full bg-amber-400"></div>
            </div>
        </div>

    </section>


    {{-- DAFTAR MATERI --}}
    <section class="overflow-hidden rounded-[25px] border border-white bg-white shadow-[0_12px_35px_rgba(38,105,160,.07)]">

        <div class="flex flex-col gap-3 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-cyan-50 p-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 text-xl text-white shadow-lg shadow-blue-100">
                    📖
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[.16em] text-blue-500">Manajemen Konten</p>
                    <h2 class="mt-1 text-lg font-extrabold text-slate-800">Daftar Materi Pembelajaran</h2>
                    <p class="mt-1 text-xs text-slate-500">Materi dikelompokkan berdasarkan topik numerasi.</p>
                </div>
            </div>

            <span class="w-fit rounded-full border border-blue-100 bg-white px-4 py-2 text-xs font-bold text-blue-600">
                {{ $materials->total() }} materi
            </span>
        </div>


        @forelse($materials as $material)

            <article class="remedial-card border-b border-slate-100 p-6 last:border-0">

                <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">

                    {{-- INFORMASI MATERI --}}
                    <div class="flex min-w-0 items-start gap-4">

                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-100 to-cyan-100 text-2xl shadow-sm">
                            📘
                        </div>

                        <div class="min-w-0 flex-1">

                            <h3 class="text-base font-extrabold text-slate-800">
                                {{ $material->title }}
                            </h3>

                            <p class="mt-1 text-sm font-semibold text-blue-600">
                                {{ $material->topic->title ?? 'Topik tidak tersedia' }}
                            </p>

                            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                                {{ $material->description ?: 'Tidak ada deskripsi.' }}
                            </p>

                            <div class="mt-4 flex flex-wrap gap-2">

                                <span class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700">
                                    <span>📝</span>
                                    {{ $material->exercises_count }} soal latihan
                                </span>

                                <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-2 text-xs font-medium text-slate-600">
                                    <span>📅</span>
                                    Dibuat {{ $material->created_at->format('d M Y') }}
                                </span>

                            </div>
                        </div>
                    </div>


                    {{-- STATUS DAN AKSI --}}
                    <div class="flex shrink-0 flex-col gap-3 xl:min-w-[185px]">

                        @if($material->status === 'published')
                            <span class="inline-flex items-center justify-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-xs font-bold text-emerald-700">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                Dipublikasikan
                            </span>
                        @else
                            <span class="inline-flex items-center justify-center gap-2 rounded-full bg-amber-50 px-4 py-2 text-xs font-bold text-amber-700">
                                <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                Draft
                            </span>
                        @endif

                        <a href="{{ route('teacher.remedials.exercises.index', $material) }}"
                           class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-50 px-4 py-2.5 text-sm font-bold text-indigo-700 transition hover:bg-indigo-100">
                            📝 Kelola Soal
                        </a>

                        <a href="{{ route('teacher.remedials.results.index', $material) }}"
                           class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-50 px-4 py-2.5 text-sm font-bold text-blue-700 transition hover:bg-blue-100">
                            📊 Hasil Siswa
                        </a>

                        <a href="{{ route('teacher.remedials.edit', $material) }}"
                           class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                            ✏️ Edit Materi
                        </a>

                        <form action="{{ route('teacher.remedials.publish', $material) }}"
                              method="POST">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="w-full rounded-xl bg-emerald-50 px-4 py-2.5 text-sm font-bold text-emerald-700 transition hover:bg-emerald-100">
                                {{ $material->status === 'published' ? '↩ Tarik Publikasi' : '✓ Publikasikan' }}
                            </button>
                        </form>

                        <form action="{{ route('teacher.remedials.destroy', $material) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="w-full rounded-xl bg-red-50 px-4 py-2.5 text-sm font-bold text-red-600 transition hover:bg-red-100">
                                🗑 Hapus Materi
                            </button>
                        </form>

                    </div>

                </div>

            </article>

        @empty

            <div class="px-6 py-16 text-center">

                <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-[28px] bg-gradient-to-br from-blue-100 to-cyan-100 text-5xl">
                    📚
                </div>

                <h3 class="mt-5 text-lg font-extrabold text-slate-800">
                    Belum Ada Materi Remediasi
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                    Mulai dengan membuat materi pembelajaran tambahan
                    berdasarkan topik numerasi siswa.
                </p>

                <a href="{{ route('teacher.remedials.create') }}"
                   class="mt-6 inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-200 transition hover:-translate-y-1 hover:shadow-xl">
                    <span class="text-lg">+</span>
                    Buat Materi Pertama
                </a>

            </div>

        @endforelse


        {{-- PAGINATION --}}
        @if($materials->hasPages())
            <div class="border-t border-slate-100 bg-slate-50/70 p-6">
                {{ $materials->links() }}
            </div>
        @endif

    </section>

</div>

@endsection
