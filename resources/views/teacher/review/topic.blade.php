
@extends('layouts.teacher')

@section('title', 'Review Soal - ' . $topic->title)

@section('content')

<div class="space-y-7">

    {{-- KEMBALI --}}
    <a href="{{ route('teacher.review.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-800">
        <span>←</span>
        Kembali ke Daftar Topik
    </a>

    {{-- HEADER --}}
    <section class="rounded-3xl bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 p-7 text-white shadow-lg">

        <span class="text-xs font-bold uppercase tracking-widest">
            NUMERA SMART · REVIEW SOAL
        </span>

        <h1 class="mt-3 text-2xl font-extrabold sm:text-3xl">
            {{ $topic->title }}
        </h1>

        <div class="mt-4 flex flex-wrap items-center gap-3">

            <span class="rounded-full bg-white/20 px-4 py-2 text-xs font-bold">
                Kelas {{ $topic->grade_level }}
            </span>

            <span class="rounded-full bg-white/20 px-4 py-2 text-xs font-bold">
                {{ $questions->count() }} soal menunggu
            </span>

        </div>

        <p class="mt-4 max-w-2xl text-sm leading-6 text-white/90">
            Periksa soal dalam topik ini satu per satu.
            Soal yang disetujui akan tersedia untuk asesmen siswa.
        </p>

    </section>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-semibold text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- DAFTAR SOAL --}}
    <section class="space-y-5">

        <div class="flex flex-wrap items-center justify-between gap-3">

            <div>
                <h2 class="text-xl font-extrabold text-gray-800">
                    Daftar Soal
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Kelas {{ $topic->grade_level }} · {{ $topic->title }}
                </p>
            </div>

            <span class="rounded-full bg-blue-100 px-4 py-2 text-sm font-bold text-blue-700">
                {{ $questions->count() }} soal
            </span>

        </div>

        @forelse($questions as $index => $question)

            <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:shadow-md">

                <div class="flex flex-wrap items-center justify-between gap-3">

                    <span class="text-xs font-extrabold uppercase tracking-wider text-gray-400">
                        SOAL {{ $index + 1 }}
                    </span>

                    <div class="flex flex-wrap gap-2">

                        @if($question->review_status === 'revision_requested')
                            <span class="rounded-full bg-orange-100 px-3 py-1.5 text-xs font-bold text-orange-700">
                                Perlu Revisi
                            </span>
                        @else
                            <span class="rounded-full bg-amber-100 px-3 py-1.5 text-xs font-bold text-amber-700">
                                Draft
                            </span>
                        @endif

                        <span class="rounded-full bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-600">
                            {{ ucfirst($question->difficulty) }}
                        </span>

                    </div>

                </div>

                <p class="mt-4 text-sm font-semibold leading-7 text-gray-800">
                    {{ $question->question_text }}
                </p>

                <div class="mt-4 flex flex-wrap gap-2 text-xs text-gray-500">

                    <span class="rounded-lg bg-gray-100 px-3 py-2">
                        {{ ucfirst(str_replace('_', ' ', $question->question_type)) }}
                    </span>

                    <span class="rounded-lg bg-gray-100 px-3 py-2">
                        {{ $question->points }} poin
                    </span>

                    <span class="rounded-lg bg-gray-100 px-3 py-2">
                        Sumber: {{ ucfirst($question->source) }}
                    </span>

                </div>

                <div class="mt-5 border-t border-gray-100 pt-4">

                    <a href="{{ route('teacher.review.show', $question) }}"
                       class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:shadow-md sm:w-auto">

                        Periksa dan Setujui Soal
                        <span>→</span>

                    </a>

                </div>

            </article>

        @empty

            <div class="rounded-2xl border border-green-200 bg-green-50 p-10 text-center">

                <div class="text-4xl">✓</div>

                <h3 class="mt-4 text-lg font-extrabold text-green-800">
                    Semua Soal Sudah Diperiksa
                </h3>

                <p class="mt-2 text-sm text-green-700">
                    Tidak ada soal yang menunggu pemeriksaan
                    untuk topik ini.
                </p>

                <a href="{{ route('teacher.review.index') }}"
                   class="mt-5 inline-flex rounded-xl bg-green-600 px-5 py-3 text-sm font-bold text-white">
                    Kembali ke Daftar Topik
                </a>

            </div>

        @endforelse

    </section>

</div>

@endsection
