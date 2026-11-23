
@extends('layouts.admin')

@section('title', 'Penugasan Guru')

@section('content')
<div class="space-y-7">

    {{-- HERO --}}
    <section class="relative isolate overflow-hidden rounded-[28px] bg-gradient-to-br from-violet-700 via-indigo-600 to-blue-600 p-7 text-white shadow-xl shadow-indigo-900/10 sm:p-9">
        <div class="pointer-events-none absolute -right-12 -top-20 h-72 w-72 rounded-full border-[35px] border-white/[0.08]"></div>
        <div class="pointer-events-none absolute -bottom-28 right-1/3 h-64 w-64 rounded-full bg-cyan-300/10 blur-2xl"></div>

        <div class="relative z-10 flex flex-col justify-between gap-6 sm:flex-row sm:items-center">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3.5 py-2 text-[10px] font-black uppercase tracking-[.18em] text-violet-100">
                    <span class="h-2 w-2 rounded-full bg-cyan-300"></span>
                    Administrasi / Akademik
                </div>

                <h1 class="mt-5 text-3xl font-black tracking-tight sm:text-4xl">
                    Penugasan Guru
                    <span class="ml-1">🧭</span>
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-7 text-violet-100">
                    Atur hubungan guru, sekolah, dan tingkat kelas agar ruang lingkup pengajaran NUMERA SMART terkelola dengan baik.
                </p>
            </div>

            <div class="hidden h-24 w-24 shrink-0 items-center justify-center rounded-[28px] border border-white/20 bg-white/10 text-5xl shadow-lg backdrop-blur-sm sm:flex">
                📋
            </div>
        </div>
    </section>


    {{-- SUCCESS NOTIFICATION --}}
    @if(session('success'))
        <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-bold text-emerald-700">
            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-emerald-100 text-lg">✓</span>
            {{ session('success') }}
        </div>
    @endif


    {{-- CREATE ASSIGNMENT --}}
    <section class="overflow-hidden rounded-[26px] border border-slate-100 bg-white shadow-sm">

        <div class="border-b border-slate-100 bg-gradient-to-r from-violet-50/80 to-indigo-50/50 px-6 py-5 sm:px-8">
            <div class="flex items-center gap-4">
                <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-violet-100 text-2xl">
                    ➕
                </div>

                <div>
                    <h2 class="text-lg font-black text-slate-800">
                        Buat Penugasan Baru
                    </h2>
                    <p class="mt-1 text-xs text-slate-500">
                        Tentukan guru, sekolah, dan kelas yang akan ditangani.
                    </p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.assignments.store') }}" class="p-6 sm:p-8">
            @csrf

            <div class="grid gap-5 md:grid-cols-2">

                {{-- TEACHER --}}
                <div>
                    <label for="teacher_id" class="mb-2 block text-sm font-bold text-slate-700">
                        Guru
                        <span class="text-rose-500">*</span>
                    </label>

                    <select
                        id="teacher_id"
                        name="teacher_id"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-medium text-slate-700 outline-none transition focus:border-violet-400 focus:bg-white focus:ring-4 focus:ring-violet-500/10"
                    >
                        <option value="">Pilih guru</option>

                        @foreach($teachers as $t)
                            <option value="{{ $t->id }}" @selected(old('teacher_id') == $t->id)>
                                {{ $t->name }} — {{ $t->email }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- SCHOOL --}}
                <div>
                    <label for="school_id" class="mb-2 block text-sm font-bold text-slate-700">
                        Sekolah
                        <span class="text-rose-500">*</span>
                    </label>

                    <select
                        id="school_id"
                        name="school_id"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-medium text-slate-700 outline-none transition focus:border-violet-400 focus:bg-white focus:ring-4 focus:ring-violet-500/10"
                    >
                        <option value="">Pilih sekolah</option>

                        @foreach($schools as $s)
                            <option value="{{ $s->id }}" @selected(old('school_id') == $s->id)>
                                {{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- GRADE --}}
                <div>
                    <label for="grade_level" class="mb-2 block text-sm font-bold text-slate-700">
                        Tingkat Kelas
                        <span class="text-rose-500">*</span>
                    </label>

                    <select
                        id="grade_level"
                        name="grade_level"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-medium text-slate-700 outline-none transition focus:border-violet-400 focus:bg-white focus:ring-4 focus:ring-violet-500/10"
                    >
                        <option value="">Pilih kelas</option>

                        @foreach([4, 5, 6] as $g)
                            <option value="{{ $g }}" @selected(old('grade_level') == $g)>
                                Kelas {{ $g }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- SUBMIT --}}
                <div class="flex items-end">
                    <button
                        type="submit"
                        class="group inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-violet-600 to-indigo-600 px-5 py-3.5 text-sm font-black text-white shadow-lg shadow-indigo-500/20 transition duration-300 hover:-translate-y-0.5 hover:shadow-xl"
                    >
                        <span class="text-lg">＋</span>
                        Simpan Penugasan
                        <span class="transition-transform group-hover:translate-x-1">→</span>
                    </button>
                </div>

            </div>
        </form>
    </section>


    {{-- ASSIGNMENT LIST --}}
    <section class="overflow-hidden rounded-[26px] border border-slate-100 bg-white shadow-sm">

        {{-- TABLE HEADER --}}
        <div class="flex flex-col gap-3 border-b border-slate-100 p-6 sm:flex-row sm:items-center sm:justify-between sm:px-8">
            <div class="flex items-center gap-4">
                <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-indigo-50 text-2xl">
                    📚
                </div>

                <div>
                    <h2 class="text-lg font-black text-slate-800">
                        Daftar Penugasan
                    </h2>
                    <p class="mt-1 text-xs text-slate-400">
                        Guru dan kelas yang telah ditetapkan.
                    </p>
                </div>
            </div>

            <div class="inline-flex w-fit items-center gap-2 rounded-full border border-indigo-100 bg-indigo-50 px-3.5 py-2 text-xs font-bold text-indigo-700">
                <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                Data Penugasan
            </div>
        </div>


        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[650px] text-left text-sm">

                <thead>
                    <tr class="bg-slate-50/80 text-[10px] font-black uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-4 sm:px-8">Guru</th>
                        <th class="px-6 py-4">Sekolah</th>
                        <th class="px-6 py-4">Tingkat Kelas</th>
                        <th class="px-6 py-4 text-right sm:pr-8">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($assignments as $a)
                        <tr class="transition duration-200 hover:bg-violet-50/30">

                            {{-- TEACHER --}}
                            <td class="px-6 py-5 sm:px-8">
                                <div class="flex items-center gap-3">
                                    <div class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-violet-100 to-indigo-100 font-black text-violet-700">
                                        {{ strtoupper(substr($a->teacher->name, 0, 1)) }}
                                    </div>

                                    <div>
                                        <p class="font-extrabold text-slate-800">
                                            {{ $a->teacher->name }}
                                        </p>
                                        <p class="mt-1 text-[10px] font-medium text-slate-400">
                                            Tenaga Pengajar
                                        </p>
                                    </div>
                                </div>
                            </td>


                            {{-- SCHOOL --}}
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2.5">
                                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-sky-50 text-base">
                                        🏫
                                    </span>

                                    <span class="font-semibold text-slate-600">
                                        {{ $a->school->name }}
                                    </span>
                                </div>
                            </td>


                            {{-- GRADE --}}
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center gap-2 rounded-full border border-violet-100 bg-violet-50 px-3.5 py-2 text-xs font-black text-violet-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span>
                                    Kelas {{ $a->grade_level }}
                                </span>
                            </td>


                            {{-- ACTION --}}
                            <td class="px-6 py-5 text-right sm:pr-8">
                                <form
                                    method="POST"
                                    action="{{ route('admin.assignments.destroy', $a) }}"
                                    onsubmit="return confirm('Hapus penugasan ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-2 rounded-xl border border-rose-100 bg-rose-50 px-3.5 py-2.5 text-xs font-black text-rose-600 transition hover:border-rose-200 hover:bg-rose-100"
                                    >
                                        <span>🗑️</span>
                                        Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="mx-auto grid h-16 w-16 place-items-center rounded-3xl bg-slate-100 text-3xl">
                                    🧭
                                </div>

                                <h3 class="mt-4 font-black text-slate-700">
                                    Belum Ada Penugasan
                                </h3>

                                <p class="mt-2 text-sm text-slate-400">
                                    Penugasan guru yang dibuat akan muncul di bagian ini.
                                </p>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>


        {{-- PAGINATION --}}
        <div class="border-t border-slate-100 bg-slate-50/50 p-5 sm:px-8">
            {{ $assignments->links() }}
        </div>

    </section>

</div>
@endsection
