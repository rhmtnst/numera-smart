
@extends('layouts.teacher')

@section('title', 'Dashboard Guru')

@section('content')

<div class="relative space-y-8 overflow-hidden">

    {{-- Decorative background --}}
    <div class="pointer-events-none absolute -right-24 -top-24 h-80 w-80 rounded-full bg-cyan-300/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-24 top-[35rem] h-72 w-72 rounded-full bg-blue-300/20 blur-3xl"></div>

    {{-- Welcome section --}}
    <section class="relative overflow-hidden rounded-[30px] border border-white/70 bg-gradient-to-br from-[#087cf0] via-[#12b5ed] to-[#36d99a] p-7 text-white shadow-[0_20px_50px_rgba(13,126,222,0.18)] md:p-9">

        <div class="absolute -right-16 -top-24 h-72 w-72 rounded-full bg-white/15"></div>
        <div class="absolute -bottom-32 right-1/4 h-64 w-64 rounded-full bg-[#075de0]/20"></div>
        <div class="absolute right-10 top-10 h-16 w-16 rounded-full border border-white/30 bg-white/10 backdrop-blur-md"></div>

        <div class="relative z-10 max-w-2xl">
            <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/15 px-4 py-2 text-xs font-semibold tracking-wide backdrop-blur-md">
                <span class="h-2 w-2 rounded-full bg-[#a7ffda]"></span>
                NUMERA SMART · RUANG GURU
            </div>

            <h1 class="text-3xl font-extrabold leading-tight tracking-tight md:text-4xl">
                Selamat Datang,<br>
                {{ auth()->user()->name }}!
            </h1>

            <p class="mt-4 max-w-xl text-sm leading-7 text-white/85 md:text-base">
                Pantau aktivitas pembelajaran, kelola asesmen, dan bantu setiap siswa memahami numerasi dengan lebih baik.
            </p>

            <div class="mt-7 flex flex-wrap items-center gap-3">
                <a href="{{ route('teacher.students.index') }}"
                   class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-bold text-[#087bc9] shadow-lg transition hover:-translate-y-1 hover:shadow-xl">
                    <span>♟</span>
                    Lihat Data Siswa
                    <span>→</span>
                </a>

                <a href="{{ route('teacher.questions.index') }}"
                   class="inline-flex items-center gap-2 rounded-full border border-white/40 bg-white/15 px-5 py-3 text-sm font-semibold text-white backdrop-blur-md transition hover:bg-white/25">
                    <span>▤</span>
                    Kelola Bank Soal
                </a>
            </div>
        </div>

        <div class="absolute bottom-7 right-8 hidden text-[110px] font-black leading-none text-white/15 lg:block">
            N
        </div>
    </section>


    {{-- Statistics --}}
    <section class="relative">
        <div class="mb-5 flex flex-wrap items-end justify-between gap-3">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#168bd1]">
                    Ringkasan Aktivitas
                </p>
                <h2 class="mt-1 text-xl font-extrabold tracking-tight text-slate-800">
                    Statistik Pembelajaran
                </h2>
            </div>
            <span class="rounded-full border border-white bg-white/70 px-4 py-2 text-xs font-semibold text-slate-500 shadow-sm">
                Data sistem NUMERA SMART
            </span>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Total Questions --}}
            <div class="group relative overflow-hidden rounded-[25px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_35px_rgba(38,105,160,0.13)]">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-blue-100/70 transition group-hover:scale-125"></div>
                <div class="relative flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-500">Total Bank Soal</span>
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 text-xl text-white shadow-lg shadow-blue-200">▤</span>
                </div>
                <div class="relative mt-5 text-4xl font-extrabold tracking-tight text-[#087bc9]">
                    {{ $totalQuestions }}
                </div>
                <p class="relative mt-2 text-xs text-slate-400">Seluruh soal dalam sistem</p>
                <div class="relative mt-5 h-1.5 overflow-hidden rounded-full bg-blue-50">
                    <div class="h-full w-full rounded-full bg-gradient-to-r from-blue-500 to-cyan-400"></div>
                </div>
            </div>

            {{-- Draft Questions --}}
            <div class="group relative overflow-hidden rounded-[25px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_35px_rgba(38,105,160,0.13)]">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-orange-100/70 transition group-hover:scale-125"></div>
                <div class="relative flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-500">Menunggu Review</span>
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-orange-400 to-amber-300 text-xl text-white shadow-lg shadow-orange-100">◷</span>
                </div>
                <div class="relative mt-5 text-4xl font-extrabold tracking-tight text-orange-500">
                    {{ $draftQuestions }}
                </div>
                <p class="relative mt-2 text-xs text-slate-400">Soal yang perlu diperiksa</p>
                <div class="relative mt-5 h-1.5 overflow-hidden rounded-full bg-orange-50">
                    <div class="h-full w-full rounded-full bg-gradient-to-r from-orange-400 to-amber-300"></div>
                </div>
            </div>

            {{-- Approved Questions --}}
            <div class="group relative overflow-hidden rounded-[25px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_35px_rgba(38,105,160,0.13)]">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-emerald-100/70 transition group-hover:scale-125"></div>
                <div class="relative flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-500">Soal Disetujui</span>
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-400 text-xl text-white shadow-lg shadow-emerald-100">✓</span>
                </div>
                <div class="relative mt-5 text-4xl font-extrabold tracking-tight text-emerald-500">
                    {{ $approvedQuestions }}
                </div>
                <p class="relative mt-2 text-xs text-slate-400">Siap digunakan dalam asesmen</p>
                <div class="relative mt-5 h-1.5 overflow-hidden rounded-full bg-emerald-50">
                    <div class="h-full w-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-400"></div>
                </div>
            </div>

            {{-- Students --}}
            <div class="group relative overflow-hidden rounded-[25px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_35px_rgba(38,105,160,0.13)]">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-cyan-100/70 transition group-hover:scale-125"></div>
                <div class="relative flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-500">Total Siswa</span>
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-400 text-xl text-white shadow-lg shadow-cyan-100">♟</span>
                </div>
                <div class="relative mt-5 text-4xl font-extrabold tracking-tight text-cyan-600">
                    {{ $totalStudents }}
                </div>
                <p class="relative mt-2 text-xs text-slate-400">Akun siswa terdaftar</p>
                <div class="relative mt-5 h-1.5 overflow-hidden rounded-full bg-cyan-50">
                    <div class="h-full w-full rounded-full bg-gradient-to-r from-cyan-500 to-blue-400"></div>
                </div>
            </div>

        </div>
    </section>


    {{-- Quick Access --}}
    <section class="relative">
        <div class="mb-5">
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#168bd1]">
                Ruang Kerja
            </p>
            <h2 class="mt-1 text-xl font-extrabold tracking-tight text-slate-800">
                Pengelolaan Pembelajaran
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Semua kebutuhan pengelolaan pembelajaran dalam satu tempat.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">

            {{-- Bank Soal --}}
            <a href="{{ route('teacher.questions.index') }}"
               class="group relative overflow-hidden rounded-[26px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl transition duration-300 hover:-translate-y-1.5 hover:shadow-[0_20px_40px_rgba(8,126,197,0.13)]">
                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-blue-100/70 transition group-hover:scale-125"></div>
                <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 text-2xl text-white shadow-lg shadow-blue-200">▤</div>
                <h3 class="relative mt-5 text-lg font-extrabold text-slate-800">Bank Soal</h3>
                <p class="relative mt-2 text-sm leading-6 text-slate-500">
                    Kelola soal numerasi berdasarkan kelas, domain, dan topik.
                </p>
                <div class="relative mt-5 flex items-center justify-between text-sm font-bold text-[#087bc9]">
                    Buka Bank Soal <span class="transition group-hover:translate-x-1">→</span>
                </div>
            </a>

            {{-- Review --}}
            <div class="group relative overflow-hidden rounded-[26px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl transition duration-300 hover:-translate-y-1.5 hover:shadow-[0_20px_40px_rgba(8,126,197,0.13)]">
                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-orange-100/70 transition group-hover:scale-125"></div>
                <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-orange-400 to-amber-300 text-2xl text-white shadow-lg shadow-orange-100">✎</div>
                <h3 class="relative mt-5 text-lg font-extrabold text-slate-800">Review Soal</h3>
                <p class="relative mt-2 text-sm leading-6 text-slate-500">
                    Periksa pertanyaan, pilihan jawaban, dan pembahasan sebelum disetujui.
                </p>
                <div class="relative mt-5 inline-flex rounded-full bg-orange-50 px-3 py-2 text-xs font-bold text-orange-600">
                    {{ $draftQuestions }} soal menunggu review
                </div>
            </div>

            {{-- Results --}}
            <a href="{{ route('teacher.results.index') }}"
               class="group relative overflow-hidden rounded-[26px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl transition duration-300 hover:-translate-y-1.5 hover:shadow-[0_20px_40px_rgba(8,126,197,0.13)]">
                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-emerald-100/70 transition group-hover:scale-125"></div>
                <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-400 text-2xl text-white shadow-lg shadow-emerald-100">▥</div>
                <h3 class="relative mt-5 text-lg font-extrabold text-slate-800">Hasil Asesmen</h3>
                <p class="relative mt-2 text-sm leading-6 text-slate-500">
                    Pantau hasil pengerjaan dan perkembangan numerasi siswa.
                </p>
                <div class="relative mt-5 flex items-center justify-between text-sm font-bold text-emerald-600">
                    Lihat Hasil Asesmen <span class="transition group-hover:translate-x-1">→</span>
                </div>
            </a>

            {{-- Analysis --}}
            <a href="{{ route('teacher.analyses.index') }}"
               class="group relative overflow-hidden rounded-[26px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl transition duration-300 hover:-translate-y-1.5 hover:shadow-[0_20px_40px_rgba(8,126,197,0.13)]">
                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-cyan-100/70 transition group-hover:scale-125"></div>
                <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-400 text-2xl text-white shadow-lg shadow-cyan-100">⌕</div>
                <h3 class="relative mt-5 text-lg font-extrabold text-slate-800">Analisis Kesulitan</h3>
                <p class="relative mt-2 text-sm leading-6 text-slate-500">
                    Tinjau indikasi kesulitan siswa berdasarkan tahapan Newman.
                </p>
                <div class="relative mt-5 flex items-center justify-between text-sm font-bold text-cyan-600">
                    Buka Analisis <span class="transition group-hover:translate-x-1">→</span>
                </div>
            </a>

            {{-- Remedial --}}
            <a href="{{ route('teacher.remedials.index') }}"
               class="group relative overflow-hidden rounded-[26px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl transition duration-300 hover:-translate-y-1.5 hover:shadow-[0_20px_40px_rgba(8,126,197,0.13)]">
                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-green-100/70 transition group-hover:scale-125"></div>
                <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-green-500 to-emerald-400 text-2xl text-white shadow-lg shadow-green-100">✦</div>
                <h3 class="relative mt-5 text-lg font-extrabold text-slate-800">Rekomendasi Remediasi</h3>
                <p class="relative mt-2 text-sm leading-6 text-slate-500">
                    Tinjau rekomendasi materi dan latihan sesuai kebutuhan siswa.
                </p>
                <div class="relative mt-5 flex items-center justify-between text-sm font-bold text-emerald-600">
                    Kelola Remediasi <span class="transition group-hover:translate-x-1">→</span>
                </div>
            </a>

            {{-- Students --}}
            <a href="{{ route('teacher.students.index') }}"
               class="group relative overflow-hidden rounded-[26px] border border-white bg-white/90 p-6 shadow-[0_10px_30px_rgba(38,105,160,0.07)] backdrop-blur-xl transition duration-300 hover:-translate-y-1.5 hover:shadow-[0_20px_40px_rgba(8,126,197,0.13)]">
                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-indigo-100/70 transition group-hover:scale-125"></div>
                <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-400 text-2xl text-white shadow-lg shadow-indigo-100">♟</div>
                <h3 class="relative mt-5 text-lg font-extrabold text-slate-800">Data Siswa</h3>
                <p class="relative mt-2 text-sm leading-6 text-slate-500">
                    Lihat jumlah dan informasi akun siswa yang terdaftar.
                </p>
                <div class="relative mt-5 flex items-center justify-between text-sm font-bold text-indigo-600">
                    {{ $totalStudents }} siswa · Lihat daftar <span class="transition group-hover:translate-x-1">→</span>
                </div>
            </a>

        </div>
    </section>


    {{-- Recent draft questions --}}
    <section class="relative overflow-hidden rounded-[28px] border border-white bg-white/90 shadow-[0_15px_40px_rgba(38,105,160,0.08)] backdrop-blur-xl">

        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 bg-gradient-to-r from-blue-50/80 via-cyan-50/60 to-emerald-50/70 p-6 md:p-7">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168bd1]">
                    Perlu Perhatian
                </p>
                <h2 class="mt-1 text-xl font-extrabold text-slate-800">
                    Soal Menunggu Pemeriksaan
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Berikut beberapa soal terbaru yang masih berstatus draft.
                </p>
            </div>

            <span class="inline-flex items-center gap-2 rounded-full border border-orange-100 bg-white px-4 py-2 text-xs font-bold text-orange-600 shadow-sm">
                <span class="h-2 w-2 rounded-full bg-orange-400"></span>
                {{ $draftQuestions }} menunggu review
            </span>
        </div>

        @forelse ($recentDraftQuestions as $question)
            <div class="flex flex-col gap-3 border-b border-slate-100 p-5 transition last:border-0 hover:bg-blue-50/40 sm:flex-row sm:items-center sm:justify-between md:px-7">

                <div class="min-w-0">
                    <h3 class="font-bold leading-6 text-slate-800">
                        {{ $question->question_text }}
                    </h3>

                    <p class="mt-2 text-sm text-slate-500">
                        {{ $question->topic?->title ?? 'Topik belum tersedia' }}
                        <span class="mx-1 text-slate-300">•</span>
                        {{ ucfirst($question->difficulty) }}
                    </p>
                </div>

                <span class="inline-flex w-fit shrink-0 items-center gap-2 rounded-full border border-orange-100 bg-orange-50 px-4 py-2 text-xs font-bold text-orange-600">
                    <span class="h-2 w-2 rounded-full bg-orange-400"></span>
                    Draft
                </span>

            </div>
        @empty
            <div class="p-10 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-emerald-50 text-3xl">✓</div>
                <h3 class="mt-4 font-bold text-slate-700">Semua sudah diperiksa!</h3>
                <p class="mt-2 text-sm text-slate-400">
                    Belum ada soal yang menunggu pemeriksaan.
                </p>
            </div>
        @endforelse

    </section>

</div>

@endsection
