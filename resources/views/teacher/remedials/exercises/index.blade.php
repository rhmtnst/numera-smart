
@extends('layouts.teacher')

@section('title', 'Soal Latihan Remediasi')

@section('content')

<style>
    .exercise-card {
        border: 1px solid #e8eef6;
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 8px 28px rgba(31, 65, 105, .045);
    }

    .exercise-stat {
        position: relative;
        overflow: hidden;
        border: 1px solid #e8eef6;
        border-radius: 20px;
        background: #fff;
        padding: 21px;
        transition: .25s ease;
    }

    .exercise-stat:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(31, 65, 105, .08);
    }

    .exercise-stat::after {
        position: absolute;
        right: -22px;
        top: -25px;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: var(--stat-glow, #eff6ff);
        content: "";
        opacity: .8;
    }

    .exercise-float {
        animation: exerciseFloat 4s ease-in-out infinite;
    }

    .exercise-float-delay {
        animation: exerciseFloat 5s ease-in-out infinite;
        animation-delay: .8s;
    }

    .exercise-row {
        border-bottom: 1px solid #edf1f6;
        padding: 22px;
        transition: background .2s ease;
    }

    .exercise-row:last-child {
        border-bottom: 0;
    }

    .exercise-row:hover {
        background: #fbfdff;
    }

    .exercise-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border-radius: 11px;
        padding: 9px 13px;
        font-size: 12px;
        font-weight: 700;
        transition: .2s ease;
    }

    .exercise-action:hover {
        transform: translateY(-1px);
    }

    @keyframes exerciseFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    @media (prefers-reduced-motion: reduce) {
        .exercise-float,
        .exercise-float-delay {
            animation: none;
        }

        .exercise-stat,
        .exercise-row,
        .exercise-action {
            transition: none;
        }
    }

    @media (max-width: 640px) {
        .exercise-row {
            padding: 17px;
        }
    }
</style>

<div class="space-y-7">

    {{-- NAVIGASI DAN HEADER --}}
    <section class="space-y-5">

        <a href="{{ route('teacher.remedials.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 transition hover:gap-3 hover:text-blue-800">
            <span>←</span>
            Kembali ke Materi Remediasi
        </a>

        {{-- HERO --}}
        <div class="relative overflow-hidden rounded-[26px] bg-gradient-to-br from-[#087cf0] via-[#12afe9] to-[#35d99a] px-6 py-8 text-white shadow-xl shadow-blue-500/10 sm:px-9 sm:py-10">

            <div class="pointer-events-none absolute -right-12 -top-20 h-64 w-64 rounded-full border-[35px] border-white/10"></div>
            <div class="pointer-events-none absolute -bottom-24 right-36 h-56 w-56 rounded-full bg-white/10 blur-2xl"></div>

            <div class="relative z-10 grid items-center gap-6 md:grid-cols-[1fr_auto]">

                <div>
                    <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/15 px-3 py-1.5 text-xs font-semibold text-white/95 backdrop-blur">
                        <span>NUMERA SMART</span>
                        <span class="text-white/60">/</span>
                        <span>REMEDIASI</span>
                        <span class="text-white/60">/</span>
                        <span>SOAL LATIHAN</span>
                    </div>

                    <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                        Soal Latihan Remediasi
                    </h1>

                    <p class="mt-3 max-w-xl text-sm leading-relaxed text-white/85 sm:text-base">
                        Kelola soal latihan untuk membantu siswa memperkuat pemahaman dan memperbaiki kesulitan belajar.
                    </p>

                    <div class="mt-5 inline-flex max-w-full items-center gap-2 rounded-full border border-white/20 bg-white/15 px-4 py-2 text-xs font-semibold backdrop-blur">
                        <span>📚</span>
                        <span class="truncate">{{ $material->title }}</span>
                    </div>
                </div>

                <div class="exercise-float hidden h-36 w-36 items-center justify-center rounded-[30px] border border-white/20 bg-white/15 shadow-lg backdrop-blur-sm md:flex">
                    <svg viewBox="0 0 150 150" class="h-32 w-32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="25" y="27" width="85" height="99" rx="13" fill="white" fill-opacity=".95"/>
                        <rect x="40" y="43" width="55" height="6" rx="3" fill="#B7DDFB"/>
                        <rect x="40" y="59" width="48" height="5" rx="2.5" fill="#D3E8F9"/>
                        <rect x="40" y="73" width="55" height="5" rx="2.5" fill="#D3E8F9"/>
                        <rect x="40" y="87" width="35" height="5" rx="2.5" fill="#D3E8F9"/>
                        <circle cx="105" cy="105" r="23" fill="#D1FAE5"/>
                        <path d="M94 105L102 113L117 96" stroke="#07975A" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22 43L14 43" stroke="white" stroke-width="4" stroke-linecap="round"/>
                        <path d="M119 34L127 26" stroke="white" stroke-width="4" stroke-linecap="round"/>
                        <path d="M124 62L133 62" stroke="white" stroke-width="4" stroke-linecap="round"/>
                        <path d="M22 113L15 120" stroke="white" stroke-width="4" stroke-linecap="round"/>
                    </svg>
                </div>

            </div>
        </div>

        {{-- TOMBOL TAMBAH --}}
        <div class="flex justify-end">
            <a href="{{ route('teacher.remedials.exercises.create', $material) }}"
               class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 via-sky-500 to-emerald-500 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:shadow-xl sm:w-auto">
                <span class="text-lg">+</span>
                Tambah Soal Latihan
            </a>
        </div>

    </section>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            <span class="text-lg">✓</span>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <span class="text-lg">⚠️</span>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-5 text-sm text-red-700">
            <div class="flex items-center gap-2 font-bold">
                <span>⚠️</span>
                Terjadi Kesalahan
            </div>

            <ul class="mt-3 list-inside list-disc space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- INFORMASI MATERI --}}
    <section class="exercise-card p-5 sm:p-6">

        <div class="flex flex-wrap items-center justify-between gap-4">

            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-2xl">
                    📖
                </div>

                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                        Materi Pembelajaran
                    </p>

                    <h2 class="mt-1 text-lg font-extrabold text-gray-800">
                        {{ $material->title }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ $material->topic->title ?? 'Topik tidak tersedia' }}
                    </p>
                </div>
            </div>

            <span class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-bold
                {{ $material->status === 'published'
                    ? 'bg-green-50 text-green-700'
                    : 'bg-amber-50 text-amber-700' }}">

                <span class="h-2 w-2 rounded-full
                    {{ $material->status === 'published' ? 'bg-green-500' : 'bg-amber-500' }}">
                </span>

                {{ $material->status === 'published' ? 'Dipublikasikan' : 'Draft' }}
            </span>

        </div>
    </section>

    {{-- STATISTIK --}}
    <section class="grid grid-cols-1 gap-4 sm:grid-cols-3">

        <div class="exercise-stat" style="--stat-glow:#dbeafe;">
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500">Total Soal</p>
                    <p class="mt-3 text-3xl font-extrabold text-blue-600">
                        {{ $material->exercises->count() }}
                    </p>
                    <p class="mt-1 text-xs text-gray-400">Seluruh soal latihan</p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-2xl">
                    📝
                </div>
            </div>
        </div>

        <div class="exercise-stat" style="--stat-glow:#d1fae5;">
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500">Soal Aktif</p>
                    <p class="mt-3 text-3xl font-extrabold text-emerald-600">
                        {{ $material->exercises->where('is_active', true)->count() }}
                    </p>
                    <p class="mt-1 text-xs text-gray-400">Siap ditampilkan ke siswa</p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-2xl">
                    ✓
                </div>
            </div>
        </div>

        <div class="exercise-stat" style="--stat-glow:#ffedd5;">
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500">Soal Nonaktif</p>
                    <p class="mt-3 text-3xl font-extrabold text-orange-500">
                        {{ $material->exercises->where('is_active', false)->count() }}
                    </p>
                    <p class="mt-1 text-xs text-gray-400">Belum ditampilkan ke siswa</p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-orange-50 text-2xl">
                    ⏸
                </div>
            </div>
        </div>

    </section>

    {{-- DAFTAR SOAL --}}
    <section class="exercise-card overflow-hidden">

        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 p-5 sm:p-6">
            <div>
                <h2 class="text-lg font-extrabold text-gray-800">
                    Daftar Soal Latihan
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Kelola pertanyaan, status, dan pengaturan soal remediasi.
                </p>
            </div>

            <span class="rounded-full bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-700">
                {{ $exercises->total() }} Soal
            </span>
        </div>

        @forelse($exercises as $index => $exercise)

            <article class="exercise-row">

                <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                    {{-- INFORMASI SOAL --}}
                    <div class="min-w-0 flex-1">

                        <div class="flex flex-wrap items-center gap-2">

                            <span class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-extrabold text-blue-700">
                                Soal {{ $exercises->firstItem() + $index }}
                            </span>

                            <span class="rounded-full bg-violet-50 px-3 py-1.5 text-xs font-semibold text-violet-700">
                                {{ $exercise->question_type === 'multiple_choice'
                                    ? 'Pilihan Ganda'
                                    : 'Isian Singkat' }}
                            </span>

                            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-bold
                                {{ $exercise->is_active
                                    ? 'bg-green-50 text-green-700'
                                    : 'bg-gray-100 text-gray-500' }}">

                                <span class="h-1.5 w-1.5 rounded-full
                                    {{ $exercise->is_active ? 'bg-green-500' : 'bg-gray-400' }}">
                                </span>

                                {{ $exercise->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>

                        </div>

                        <h3 class="mt-4 text-sm font-bold leading-relaxed text-gray-800 sm:text-base">
                            {{ $exercise->question_text }}
                        </h3>

                        {{-- PILIHAN JAWABAN --}}
                        @if($exercise->question_type === 'multiple_choice')

                            <div class="mt-4 grid gap-2 sm:grid-cols-2">

                                @foreach($exercise->options ?? [] as $label => $option)

                                    <div class="flex items-start gap-3 rounded-xl border border-gray-100 bg-gray-50/80 p-3">
                                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-white text-xs font-extrabold text-gray-600 shadow-sm">
                                            {{ $label }}
                                        </span>

                                        <span class="pt-1 text-sm leading-relaxed text-gray-600">
                                            {{ $option }}
                                        </span>
                                    </div>

                                @endforeach

                            </div>

                        @endif

                        {{-- METADATA --}}
                        <div class="mt-5 flex flex-wrap gap-x-5 gap-y-2 border-t border-gray-100 pt-4 text-xs font-medium text-gray-400">
                            <span class="inline-flex items-center gap-1.5">
                                <span>⭐</span>
                                Bobot: {{ $exercise->points }} poin
                            </span>

                            <span class="inline-flex items-center gap-1.5">
                                <span>↕</span>
                                Urutan: {{ $exercise->sort_order }}
                            </span>

                            <span class="inline-flex items-center gap-1.5">
                                <span>👥</span>
                                Jawaban tersimpan: {{ $exercise->answers_count }}
                            </span>
                        </div>

                    </div>

                    {{-- AKSI --}}
                    <div class="flex flex-wrap gap-2 lg:max-w-[300px] lg:justify-end">

                        <a href="{{ route('teacher.remedials.exercises.edit', [$material, $exercise->id]) }}"
                           class="exercise-action border border-blue-100 bg-blue-50 text-blue-700 hover:bg-blue-100">
                            <span>✏️</span>
                            Edit
                        </a>

                        <form action="{{ route('teacher.remedials.exercises.toggle', [$material, $exercise->id]) }}"
                              method="POST">
                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="exercise-action
                                    {{ $exercise->is_active
                                        ? 'bg-orange-50 text-orange-700 hover:bg-orange-100'
                                        : 'bg-green-50 text-green-700 hover:bg-green-100' }}">

                                <span>{{ $exercise->is_active ? '⏸' : '▶' }}</span>
                                {{ $exercise->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>

                        <form action="{{ route('teacher.remedials.exercises.destroy', [$material, $exercise->id]) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="exercise-action bg-red-50 text-red-600 hover:bg-red-100">
                                <span>🗑</span>
                                Hapus
                            </button>
                        </form>

                    </div>

                </div>

            </article>

        @empty

            {{-- EMPTY STATE --}}
            <div class="px-6 py-14 text-center sm:py-16">

                <div class="exercise-float mx-auto flex h-24 w-24 items-center justify-center rounded-[28px] bg-gradient-to-br from-blue-50 to-emerald-50 text-5xl">
                    📝
                </div>

                <h3 class="mt-6 text-xl font-extrabold text-gray-800">
                    Belum Ada Soal Latihan
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-gray-500">
                    Materi ini belum memiliki soal latihan. Tambahkan soal agar siswa dapat menguji pemahaman dan berlatih kembali.
                </p>

                <a href="{{ route('teacher.remedials.exercises.create', $material) }}"
                   class="mt-6 inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-emerald-500 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-500/15 transition hover:-translate-y-0.5 hover:shadow-xl">
                    <span>+</span>
                    Tambahkan Soal Pertama
                </a>

            </div>

        @endforelse

        {{-- PAGINATION --}}
        @if($exercises->hasPages())
            <div class="border-t border-gray-100 bg-gray-50/50 p-5 sm:p-6">
                {{ $exercises->links() }}
            </div>
        @endif

    </section>

    {{-- INFORMASI --}}
    <section class="relative overflow-hidden rounded-[22px] border border-blue-100 bg-gradient-to-br from-blue-50 via-cyan-50 to-emerald-50 p-5 sm:p-6">

        <div class="pointer-events-none absolute -right-10 -top-10 h-36 w-36 rounded-full bg-blue-200/20 blur-2xl"></div>

        <div class="relative z-10 flex items-start gap-4">
            <div class="exercise-float-delay flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-xl shadow-sm">
                💡
            </div>

            <div>
                <h3 class="font-extrabold text-gray-800">
                    Informasi Pengelolaan Soal
                </h3>

                <p class="mt-2 text-sm leading-relaxed text-gray-600">
                    Soal yang berstatus aktif dapat ditampilkan kepada siswa ketika materi remediasi dipublikasikan. Pastikan pertanyaan, pilihan jawaban, dan bobot soal sudah sesuai sebelum mengaktifkannya.
                </p>
            </div>
        </div>

    </section>

</div>

@endsection
