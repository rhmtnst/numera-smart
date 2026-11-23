
@extends('layouts.teacher')

@section('title', 'Data Siswa')

@section('content')

<div class="relative space-y-8 overflow-hidden">

    {{-- Decorative background --}}
    <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-cyan-300/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-24 top-96 h-72 w-72 rounded-full bg-blue-300/20 blur-3xl"></div>

    {{-- Page heading --}}
    <section class="relative overflow-hidden rounded-[28px] border border-white/70 bg-gradient-to-br from-[#087cf0] via-[#12b5ed] to-[#36d99a] p-7 text-white shadow-[0_18px_45px_rgba(13,126,222,0.16)] md:p-8">

        <div class="absolute -right-12 -top-20 h-64 w-64 rounded-full bg-white/15"></div>
        <div class="absolute -bottom-28 right-1/3 h-56 w-56 rounded-full bg-blue-700/15"></div>

        <div class="relative z-10">
            <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/15 px-4 py-2 text-xs font-bold backdrop-blur-md">
                <span class="h-2 w-2 rounded-full bg-[#a7ffda]"></span>
                NUMERA SMART · RUANG GURU
            </div>

            <h1 class="text-3xl font-extrabold tracking-tight md:text-4xl">
                Data Siswa
            </h1>

            <p class="mt-3 max-w-2xl text-sm leading-7 text-white/85 md:text-base">
                Kenali siswa yang berada dalam tanggung jawab Anda dan pantau informasi kelas mereka melalui satu halaman.
            </p>

            <div class="mt-6 inline-flex items-center gap-3 rounded-2xl border border-white/25 bg-white/15 px-4 py-3 backdrop-blur-md">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-xl text-[#087bc9] shadow-sm">♟</span>
                <div>
                    <p class="text-xs text-white/75">Total siswa terdaftar</p>
                    <p class="text-xl font-extrabold">{{ $students->total() }} siswa</p>
                </div>
            </div>
        </div>

        <div class="absolute bottom-5 right-8 hidden text-8xl font-black text-white/15 lg:block">
            S
        </div>
    </section>


    {{-- Teacher assignments --}}
    <section class="relative overflow-hidden rounded-[26px] border border-white bg-white/90 p-6 shadow-[0_12px_35px_rgba(38,105,160,0.07)] backdrop-blur-xl md:p-7">

        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 text-xl text-white shadow-lg shadow-blue-100">
                    ▦
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-800">
                        Penugasan Anda
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Sekolah dan kelas yang menjadi tanggung jawab Anda.
                    </p>
                </div>
            </div>

            <span class="rounded-full border border-blue-100 bg-blue-50 px-4 py-2 text-xs font-bold text-blue-600">
                {{ $assignments->count() }} penugasan
            </span>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            @forelse($assignments as $assignment)
                <div class="inline-flex items-center gap-3 rounded-2xl border border-blue-100 bg-gradient-to-r from-blue-50 to-cyan-50 px-4 py-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-lg text-blue-600 shadow-sm">
                        🏫
                    </span>
                    <div>
                        <p class="text-sm font-bold text-slate-700">
                            {{ $assignment->school?->name ?? 'Sekolah' }}
                        </p>
                        <p class="mt-0.5 text-xs font-semibold text-blue-600">
                            Kelas {{ $assignment->grade_level }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="flex w-full items-center gap-3 rounded-2xl border border-amber-100 bg-amber-50 p-4">
                    <span class="text-2xl">⚠️</span>
                    <p class="text-sm font-medium text-amber-700">
                        Belum ada kelas yang ditugaskan administrator.
                    </p>
                </div>
            @endforelse
        </div>
    </section>


    {{-- Student list --}}
    <section class="relative overflow-hidden rounded-[28px] border border-white bg-white/95 shadow-[0_15px_40px_rgba(38,105,160,0.08)] backdrop-blur-xl">

        {{-- Table heading --}}
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 bg-gradient-to-r from-blue-50/90 via-cyan-50/70 to-emerald-50/70 p-6 md:p-7">

            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-500 text-xl text-white shadow-lg shadow-cyan-100">
                    👨‍🎓
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168bd1]">
                        Manajemen Siswa
                    </p>
                    <h2 class="mt-1 text-xl font-extrabold text-slate-800">
                        Daftar Siswa
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Informasi siswa sesuai penugasan kelas Anda.
                    </p>
                </div>
            </div>

            <div class="rounded-2xl border border-white bg-white/90 px-5 py-3 shadow-sm">
                <p class="text-xs text-slate-400">Total data</p>
                <p class="mt-0.5 text-2xl font-extrabold text-[#087bc9]">
                    {{ $students->total() }}
                </p>
            </div>
        </div>


        {{-- Responsive table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">

                <thead>
                    <tr class="bg-slate-50/80 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <th class="whitespace-nowrap px-6 py-5">Nama Siswa</th>
                        <th class="whitespace-nowrap px-6 py-5">Email</th>
                        <th class="whitespace-nowrap px-6 py-5">Sekolah</th>
                        <th class="whitespace-nowrap px-6 py-5">Kelas</th>
                        <th class="whitespace-nowrap px-6 py-5">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($students as $student)
                        <tr class="transition duration-200 hover:bg-blue-50/50">

                            {{-- Student name --}}
                            <td class="whitespace-nowrap px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-blue-100 to-cyan-100 font-extrabold text-blue-600">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                    <span class="font-bold text-slate-800">
                                        {{ $student->name }}
                                    </span>
                                </div>
                            </td>

                            {{-- Email --}}
                            <td class="whitespace-nowrap px-6 py-5 text-slate-500">
                                {{ $student->email }}
                            </td>

                            {{-- School --}}
                            <td class="whitespace-nowrap px-6 py-5 text-slate-600">
                                {{ $student->school?->name ?? '-' }}
                            </td>

                            {{-- Grade --}}
                            <td class="whitespace-nowrap px-6 py-5">
                                <span class="inline-flex items-center rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-600">
                                    Kelas {{ $student->studentProfile?->grade_level ?? '-' }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="whitespace-nowrap px-6 py-5">
                                @if($student->is_active)
                                    <span class="inline-flex items-center gap-2 rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-600">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 rounded-full border border-red-100 bg-red-50 px-3 py-1.5 text-xs font-bold text-red-600">
                                        <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-blue-50 text-3xl">
                                    👨‍🎓
                                </div>
                                <h3 class="mt-4 font-bold text-slate-700">
                                    Belum Ada Data Siswa
                                </h3>
                                <p class="mt-2 text-sm text-slate-400">
                                    Belum ada siswa pada kelas yang ditugaskan.
                                </p>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>


        {{-- Pagination --}}
        @if($students->hasPages())
            <div class="border-t border-slate-100 bg-slate-50/50 p-5 md:px-7">
                {{ $students->links() }}
            </div>
        @endif

    </section>

</div>

@endsection
