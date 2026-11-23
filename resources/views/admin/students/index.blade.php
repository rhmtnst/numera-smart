
@extends('layouts.admin')

@section('title', 'Manajemen Siswa')

@section('content')
<div class="space-y-8">

    {{-- HERO --}}
    <section class="relative isolate overflow-hidden rounded-[28px] bg-gradient-to-br from-[#0878d1] via-[#0b9fd1] to-[#16c6d1] p-7 text-white shadow-xl shadow-sky-900/10 sm:p-9">
        <div class="pointer-events-none absolute -right-16 -top-20 h-72 w-72 rounded-full border-[36px] border-white/[0.10]"></div>
        <div class="pointer-events-none absolute -bottom-32 right-1/4 h-64 w-64 rounded-full bg-cyan-200/15"></div>

        <div class="relative z-10 flex flex-col justify-between gap-6 sm:flex-row sm:items-center">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3.5 py-2 text-[10px] font-black uppercase tracking-[.18em] text-sky-50 backdrop-blur-sm">
                    <span class="h-2 w-2 rounded-full bg-cyan-200"></span>
                    Administrasi / Peserta Didik
                </div>

                <h1 class="mt-5 text-3xl font-black tracking-tight sm:text-4xl">
                    Manajemen Siswa
                    <span class="ml-1 inline-block">🎓</span>
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-7 text-sky-50">
                    Pantau akun, informasi sekolah, tingkat kelas, dan status keaktifan peserta didik dalam ekosistem NUMERA SMART.
                </p>
            </div>

            <div class="hidden h-32 w-32 shrink-0 items-center justify-center rounded-[28px] border border-white/20 bg-white/10 shadow-xl backdrop-blur-md sm:flex">
                <svg class="h-20 w-20 text-white" viewBox="0 0 100 100" fill="none">
                    <circle cx="50" cy="30" r="15" stroke="currentColor" stroke-width="3"/>
                    <path d="M20 84C20 66 33 54 50 54C67 54 80 66 80 84" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                    <path d="M15 25L50 11L85 25L50 40L15 25Z" fill="white" fill-opacity=".15" stroke="currentColor" stroke-width="3" stroke-linejoin="round"/>
                    <path d="M80 29V51" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                    <path d="M73 55H87" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                </svg>
            </div>
        </div>
    </section>


    {{-- SUCCESS NOTIFICATION --}}
    @if(session('success'))
        <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-700">
            <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-emerald-100">✓</span>
            <div class="pt-1">{{ session('success') }}</div>
        </div>
    @endif


    {{-- STUDENT LIST --}}
    <section class="overflow-hidden rounded-[26px] border border-slate-100 bg-white shadow-sm">

        {{-- SECTION HEADER --}}
        <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-8">
            <div class="flex items-center gap-4">
                <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-sky-50 text-sky-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M20 8v6M23 11h-6"/>
                    </svg>
                </div>

                <div>
                    <h2 class="text-lg font-black text-slate-800">Daftar Peserta Didik</h2>
                    <p class="mt-1 text-xs text-slate-500">
                        {{ $users->total() }} akun siswa terdaftar
                    </p>
                </div>
            </div>

            <div class="inline-flex w-fit items-center gap-2 rounded-full bg-sky-50 px-3 py-2 text-[10px] font-black text-sky-700">
                <span class="h-1.5 w-1.5 rounded-full bg-sky-500"></span>
                Data peserta didik
            </div>
        </div>


        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">

                <thead>
                    <tr class="bg-slate-50/80 text-[10px] font-black uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-4 sm:px-8">Nama Siswa</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Sekolah</th>
                        <th class="px-6 py-4">Tingkat Kelas</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right sm:px-8">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $u)
                        <tr class="transition hover:bg-slate-50/80">

                            {{-- STUDENT NAME --}}
                            <td class="px-6 py-4 sm:px-8">
                                <div class="flex items-center gap-3">
                                    <div class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-sky-50 text-xl">
                                        🧒
                                    </div>

                                    <div>
                                        <p class="font-extrabold text-slate-800">{{ $u->name }}</p>
                                        <p class="mt-1 text-[10px] font-medium text-slate-400">Peserta didik</p>
                                    </div>
                                </div>
                            </td>

                            {{-- EMAIL --}}
                            <td class="px-6 py-4">
                                <span class="font-medium text-slate-500">{{ $u->email }}</span>
                            </td>

                            {{-- SCHOOL --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2.5">
                                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-indigo-50 text-base">🏫</span>
                                    <span class="font-semibold text-slate-600">{{ $u->school?->name ?? '—' }}</span>
                                </div>
                            </td>

                            {{-- GRADE --}}
                            <td class="px-6 py-4">
                                @if($u->studentProfile?->grade_level)
                                    <span class="inline-flex items-center gap-2 rounded-full border border-violet-100 bg-violet-50 px-3 py-2 text-xs font-extrabold text-violet-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span>
                                        Kelas {{ $u->studentProfile->grade_level }}
                                    </span>
                                @else
                                    <span class="text-xs font-medium text-slate-400">—</span>
                                @endif
                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 rounded-full px-3 py-2 text-[10px] font-black {{ $u->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $u->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    {{ $u->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>

                            {{-- ACTION --}}
                            <td class="px-6 py-4 sm:px-8">
                                <div class="flex justify-end">
                                    <form method="POST" action="{{ route('admin.students.update', $u) }}">
                                        @csrf
                                        @method('PATCH')

                                        <input type="hidden" name="school_id" value="{{ $u->school_id }}">
                                        <input type="hidden" name="is_active" value="{{ $u->is_active ? 0 : 1 }}">

                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-2 rounded-xl border px-3.5 py-2.5 text-xs font-extrabold transition
                                            {{ $u->is_active
                                                ? 'border-rose-100 bg-rose-50 text-rose-600 hover:border-rose-200 hover:bg-rose-100'
                                                : 'border-emerald-100 bg-emerald-50 text-emerald-700 hover:border-emerald-200 hover:bg-emerald-100' }}"
                                        >
                                            @if($u->is_active)
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <circle cx="12" cy="12" r="9"/>
                                                    <path d="M9 9l6 6m0-6-6 6"/>
                                                </svg>
                                                Nonaktifkan
                                            @else
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M5 12l4 4L19 6"/>
                                                </svg>
                                                Aktifkan
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-sky-50 text-3xl">
                                    🎓
                                </div>
                                <p class="mt-4 font-extrabold text-slate-700">Belum ada siswa</p>
                                <p class="mt-1 text-xs text-slate-400">
                                    Akun peserta didik yang terdaftar akan muncul di sini.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>


        {{-- PAGINATION --}}
        <div class="border-t border-slate-100 px-6 py-5 sm:px-8">
            {{ $users->links() }}
        </div>

    </section>

</div>
@endsection
