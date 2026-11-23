
@extends('layouts.teacher')

@section('title', 'Hasil Remediasi')

@section('content')

<section class="space-y-6">

    {{-- HERO --}}
    <div class="relative overflow-hidden rounded-[28px] bg-gradient-to-r from-[#087cf0] via-[#12afe9] to-[#35d99a] p-6 text-white shadow-lg sm:p-8">
        <div class="relative z-10">
            <a href="{{ route('teacher.remedials.index') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-white/85 transition hover:text-white">
                <span>← Kembali ke Materi Remediasi</span>
            </a>
<br>
            <div class="mt-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/15 px-3 py-1.5 text-xs font-semibold backdrop-blur">
                <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                PEMANTAUAN PEMBELAJARAN
            </div>

            <h1 class="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">
                Hasil Remediasi Siswa
            </h1>

            <p class="mt-3 max-w-2xl text-sm leading-6 text-white/85 sm:text-base">
                Pantau perkembangan pemahaman siswa setelah mengikuti pembelajaran remediasi. Tinjau hasil pengerjaan dan identifikasi siswa yang masih membutuhkan pendampingan.
            </p>
        </div>

        <div class="pointer-events-none absolute -right-10 -top-16 h-56 w-56 rounded-full bg-white/10 blur-2xl"></div>
        <div class="pointer-events-none absolute -bottom-20 right-1/3 h-48 w-48 rounded-full bg-emerald-300/20 blur-3xl"></div>

        <div class="pointer-events-none absolute bottom-5 right-8 hidden opacity-25 lg:block">
            <svg class="h-36 w-36 animate-[resultFloat_4s_ease-in-out_infinite]"
                 viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="27" y="22" width="106" height="120" rx="14" fill="white"/>
                <rect x="42" y="43" width="76" height="9" rx="4.5" fill="#087CF0"/>
                <rect x="42" y="63" width="45" height="7" rx="3.5" fill="#35D99A"/>
                <rect x="42" y="80" width="64" height="7" rx="3.5" fill="#35D99A"/>
                <rect x="42" y="97" width="54" height="7" rx="3.5" fill="#35D99A"/>
                <circle cx="112" cy="112" r="20" fill="#087CF0"/>
                <path d="M103 112L109 118L121 105" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </div>

    {{-- INFORMASI MATERI --}}
    <div class="overflow-hidden rounded-[24px] border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 p-6 sm:flex-row sm:items-center sm:justify-between sm:p-7">
            <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-2xl">
                    📚
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Materi Pembelajaran
                    </p>

                    <h2 class="mt-1 text-xl font-extrabold text-slate-800">
                        {{ $remedial->title }}
                    </h2>

                    <p class="mt-2 inline-flex items-center gap-2 text-sm font-semibold text-blue-600">
                        <span>📖</span>
                        {{ $remedial->topic->title }}
                    </p>
                </div>
            </div>

            <div class="shrink-0 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                <span class="mr-1">✓</span> Rekap Remediasi
            </div>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

        <div class="group relative overflow-hidden rounded-[22px] border border-emerald-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500">
                        Total Siswa Selesai
                    </p>

                    <h3 class="mt-3 text-4xl font-extrabold tabular-nums text-emerald-600">
                        {{ $totalAttempts }}
                    </h3>

                    <p class="mt-2 text-xs text-slate-400">
                        Siswa yang telah mengumpulkan latihan
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-2xl transition group-hover:scale-110">
                    👨‍🎓
                </div>
            </div>

            <div class="absolute -bottom-8 -right-8 h-24 w-24 rounded-full bg-emerald-50/80"></div>
        </div>

        <div class="group relative overflow-hidden rounded-[22px] border border-blue-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500">
                        Rata-rata Nilai
                    </p>

                    <h3 class="mt-3 text-4xl font-extrabold tabular-nums text-blue-600">
                        {{ $averageScore !== null ? number_format((float) $averageScore, 2) : '0' }}
                    </h3>

                    <p class="mt-2 text-xs text-slate-400">
                        Rata-rata hasil pengerjaan siswa
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-2xl transition group-hover:scale-110">
                    📊
                </div>
            </div>

            <div class="absolute -bottom-8 -right-8 h-24 w-24 rounded-full bg-blue-50/80"></div>
        </div>

    </div>

    {{-- DAFTAR HASIL --}}
    <div class="overflow-hidden rounded-[24px] border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-slate-100 p-6 sm:flex-row sm:items-center sm:justify-between sm:p-7">
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-xl">
                        📋
                    </div>

                    <h2 class="text-lg font-extrabold text-slate-800">
                        Daftar Hasil Pengerjaan
                    </h2>
                </div>

                <p class="mt-2 text-sm text-slate-500">
                    Hanya menampilkan latihan yang sudah dikumpulkan siswa.
                </p>
            </div>

            <div class="inline-flex w-fit items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-500">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                Data pengerjaan
            </div>
        </div>

        @forelse($attempts as $attempt)

            <div class="group flex flex-col gap-5 border-b border-slate-100 p-6 transition duration-200 last:border-0 hover:bg-slate-50/70 md:flex-row md:items-center md:justify-between">

                {{-- IDENTITAS SISWA --}}
                <div class="flex min-w-0 items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-100 to-cyan-100 text-lg font-extrabold text-blue-700">
                        {{ strtoupper(substr($attempt->student->name, 0, 1)) }}
                    </div>

                    <div class="min-w-0">
                        <h3 class="truncate font-extrabold text-slate-800">
                            {{ $attempt->student->name }}
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Kelas:
                            <span class="font-semibold text-slate-700">
                                {{ $attempt->student->studentProfile->grade_level ?? '-' }}
                            </span>
                        </p>

                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">
                                <span>✓</span>
                                {{ $attempt->correct_answers_count }} Benar
                            </span>

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-600">
                                <span>✕</span>
                                {{ $attempt->wrong_answers_count }} Salah
                            </span>
                        </div>

                        <p class="mt-3 flex items-center gap-2 text-xs text-slate-400">
                            <span>🕒</span>
                            Selesai: {{ $attempt->completed_at?->format('d M Y, H:i') ?? '-' }}
                        </p>
                    </div>
                </div>

                {{-- NILAI DAN AKSI --}}
                <div class="flex items-center justify-between gap-5 border-t border-slate-100 pt-4 md:justify-end md:border-0 md:pt-0">

                    <div class="text-left md:text-right">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Nilai
                        </p>

                        <p class="mt-1 text-3xl font-extrabold tabular-nums {{ $attempt->score >= 75 ? 'text-emerald-600' : 'text-orange-500' }}">
                            {{ number_format((float) $attempt->score, 0) }}
                        </p>

                        <span class="mt-1 inline-block rounded-full px-2.5 py-1 text-[11px] font-bold {{ $attempt->score >= 75 ? 'bg-emerald-50 text-emerald-700' : 'bg-orange-50 text-orange-600' }}">
                            {{ $attempt->score >= 75 ? 'Tuntas' : 'Perlu Pendampingan' }}
                        </span>
                    </div>

                    <a href="{{ route('teacher.remedials.results.show', [$remedial, $attempt]) }}"
                       class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#087cf0] to-[#12afe9] px-5 py-3 text-sm font-bold text-white shadow-md shadow-blue-100 transition hover:-translate-y-0.5 hover:shadow-lg">
                        Detail
                        <span>→</span>
                    </a>
                </div>

            </div>

        @empty

            {{-- EMPTY STATE --}}
            <div class="px-6 py-16 text-center">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-blue-50 text-4xl">
                    📊
                </div>

                <h3 class="mt-5 text-lg font-extrabold text-slate-800">
                    Belum Ada Hasil Remediasi
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                    Hasil pengerjaan siswa akan muncul di sini setelah latihan dikumpulkan.
                    Silakan periksa kembali setelah siswa menyelesaikan latihan remediasi.
                </p>

                <a href="{{ route('teacher.remedials.index') }}"
                   class="mt-6 inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-600 transition hover:bg-slate-50">
                    ← Kembali ke Materi Remediasi
                </a>
            </div>

        @endforelse

        {{-- PAGINATION --}}
        @if($attempts->hasPages())
            <div class="border-t border-slate-100 bg-slate-50/50 p-6">
                {{ $attempts->links() }}
            </div>
        @endif

    </div>

</section>

<style>
    @keyframes resultFloat {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-8px);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .animate-\[resultFloat_4s_ease-in-out_infinite\] {
            animation: none !important;
        }
    }
</style>

@endsection
