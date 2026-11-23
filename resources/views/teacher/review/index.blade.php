
@extends('layouts.teacher')

@section('title', 'Review Soal')

@section('content')

<div class="space-y-7">

    {{-- HEADER --}}
    <section class="rounded-3xl bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-400 p-7 text-white shadow-lg">
        <span class="text-xs font-bold uppercase tracking-widest">
            NUMERA SMART · PENGELOLAAN SOAL
        </span>

        <h1 class="mt-3 text-3xl font-extrabold">
            Review Soal
        </h1>

        <p class="mt-3 max-w-2xl text-sm leading-6 text-white/90">
            Pilih kelas dan topik untuk memeriksa serta menyetujui
            soal yang akan digunakan dalam asesmen siswa.
        </p>
    </section>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-semibold text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-700">
            {{ session('error') }}
        </div>
    @endif

    {{-- STATISTIK --}}
    <section class="grid gap-4 sm:grid-cols-3">

        <div class="rounded-2xl border border-amber-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-semibold text-gray-500">
                Menunggu Pemeriksaan
            </p>
            <h2 class="mt-3 text-3xl font-extrabold text-amber-500">
                {{ $totalDraft }}
            </h2>
        </div>

        <div class="rounded-2xl border border-green-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-semibold text-gray-500">
                Soal Disetujui
            </p>
            <h2 class="mt-3 text-3xl font-extrabold text-green-500">
                {{ $totalApproved }}
            </h2>
        </div>

        <div class="rounded-2xl border border-orange-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-semibold text-gray-500">
                Memerlukan Revisi
            </p>
            <h2 class="mt-3 text-3xl font-extrabold text-orange-500">
                {{ $totalRevision }}
            </h2>
        </div>

    </section>

    {{-- PILIH TOPIK --}}
    <section class="space-y-6">

        <div>
            <h2 class="text-xl font-extrabold text-gray-800">
                Pilih Kelas dan Topik
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Setiap topik memiliki halaman pemeriksaan soal tersendiri.
            </p>
        </div>

        @forelse($groupedTopics as $grade => $gradeTopics)

            @php
                $gradeTotal = $gradeTopics->sum('pending_questions_count');
            @endphp

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

                {{-- HEADER KELAS --}}
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-blue-100 bg-gradient-to-r from-blue-50 to-cyan-50 p-5">

                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-blue-600">
                            Kelompok Kelas
                        </span>

                        <h3 class="mt-1 text-xl font-extrabold text-gray-800">
                            Kelas {{ $grade }}
                        </h3>
                    </div>

                    <span class="rounded-full bg-amber-100 px-4 py-2 text-xs font-bold text-amber-700">
                        {{ $gradeTotal }} soal menunggu
                    </span>

                </div>

                {{-- DAFTAR TOPIK --}}
                <div class="grid gap-4 p-5 sm:grid-cols-2">

                    @foreach($gradeTopics as $topic)

                        <a href="{{ route('teacher.review.topic', $topic) }}"
                           class="group flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-5 transition duration-200 hover:-translate-y-1 hover:border-blue-300 hover:shadow-lg">

                            <div>
                                <div class="flex items-center justify-between gap-3">

                                    <span class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-600">
                                        KELAS {{ $grade }}
                                    </span>

                                    <span class="rounded-full bg-amber-100 px-3 py-1.5 text-xs font-bold text-amber-700">
                                        {{ $topic->pending_questions_count }} soal
                                    </span>

                                </div>

                                <h4 class="mt-4 text-base font-extrabold leading-6 text-gray-800 group-hover:text-blue-600">
                                    {{ $topic->title }}
                                </h4>

                                <p class="mt-2 text-xs text-gray-500">
                                    {{ $topic->learningDomain?->name ?? 'Materi Numerasi' }}
                                </p>
                            </div>

                            <div class="mt-5 flex items-center justify-between border-t border-gray-100 pt-4">

                                <span class="text-sm font-semibold text-blue-600">
                                    Periksa soal
                                </span>

                                <span class="text-lg text-blue-500 transition group-hover:translate-x-1">
                                    →
                                </span>

                            </div>

                        </a>

                    @endforeach

                </div>

            </div>

        @empty

            <div class="rounded-2xl border border-green-200 bg-green-50 p-10 text-center">
                <div class="text-4xl">✓</div>

                <h3 class="mt-4 text-lg font-extrabold text-green-800">
                    Belum Ada Topik
                </h3>

                <p class="mt-2 text-sm text-green-700">
                    Belum ada topik yang tersedia untuk kelas penugasan Anda.
                </p>
            </div>

        @endforelse

    </section>

</div>

@endsection
