
@extends('layouts.admin')

@section('title', 'Manajemen Sekolah')

@section('content')
<div class="space-y-8">

    {{-- HERO --}}
    <section class="relative isolate overflow-hidden rounded-[28px] bg-gradient-to-br from-[#087f68] via-[#0da991] to-[#16b9c9] p-7 text-white shadow-xl shadow-emerald-900/10 sm:p-9">
        <div class="pointer-events-none absolute -right-16 -top-20 h-72 w-72 rounded-full border-[36px] border-white/[0.08]"></div>
        <div class="pointer-events-none absolute -bottom-32 right-1/4 h-64 w-64 rounded-full bg-cyan-200/10"></div>

        <div class="relative z-10 flex flex-col justify-between gap-6 sm:flex-row sm:items-center">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3.5 py-2 text-[10px] font-black uppercase tracking-[.18em] text-white/90 backdrop-blur-sm">
                    <span class="h-2 w-2 rounded-full bg-lime-300"></span>
                    Administrasi / Institusi
                </div>

                <h1 class="mt-5 text-3xl font-black tracking-tight sm:text-4xl">
                    Manajemen Sekolah
                    <span class="ml-1 inline-block">🏫</span>
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-7 text-emerald-50">
                    Kelola institusi pendidikan yang bergabung dengan NUMERA SMART. Pantau informasi, status, dan aktivitas setiap sekolah.
                </p>

                <a href="{{ route('admin.schools.create') }}"
                   class="mt-7 inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-3.5 text-sm font-extrabold text-emerald-800 shadow-lg transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Tambah Sekolah
                </a>
            </div>

            <div class="hidden h-32 w-32 shrink-0 items-center justify-center rounded-[28px] border border-white/20 bg-white/10 shadow-xl backdrop-blur-md sm:flex">
                <svg class="h-20 w-20 text-white" viewBox="0 0 100 100" fill="none">
                    <path d="M12 42L50 17L88 42" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M20 40V84H80V40" stroke="currentColor" stroke-width="4" stroke-linejoin="round"/>
                    <path d="M39 84V61C39 55 44 50 50 50C56 50 61 55 61 61V84" stroke="currentColor" stroke-width="3"/>
                    <path d="M29 52H34M66 52H71M29 65H34M66 65H71" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                    <path d="M50 9V17" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                </svg>
            </div>
        </div>
    </section>


    {{-- NOTIFICATIONS --}}
    @if(session('success'))
        <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-700">
            <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-emerald-100">✓</span>
            <div class="pt-1">{{ session('success') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm font-semibold text-rose-700">
            <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-rose-100">!</span>
            <div class="pt-1">{{ $errors->first() }}</div>
        </div>
    @endif


    {{-- STATISTICS --}}
    <section>
        <div class="mb-5">
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                <p class="text-[10px] font-black uppercase tracking-[.2em] text-emerald-700">Ringkasan Institusi</p>
            </div>
            <h2 class="mt-2 text-xl font-black tracking-tight text-slate-800">Gambaran data sekolah</h2>
            <p class="mt-1 text-sm text-slate-500">Ringkasan sekolah yang ditampilkan pada halaman ini.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">

            {{-- TOTAL SHOWN --}}
            <article class="group relative overflow-hidden rounded-[24px] border border-sky-100 bg-gradient-to-br from-sky-50 to-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold text-slate-500">Sekolah Ditampilkan</p>
                    <div class="grid h-12 w-12 place-items-center rounded-2xl bg-white text-2xl shadow-sm transition group-hover:scale-110">🏫</div>
                </div>
                <p class="mt-5 text-3xl font-black tracking-tight text-sky-600">{{ $schools->count() }}</p>
                <p class="mt-2 text-[10px] font-medium text-slate-400">Jumlah sekolah pada halaman saat ini</p>
            </article>

            {{-- ACTIVE --}}
            <article class="group relative overflow-hidden rounded-[24px] border border-emerald-100 bg-gradient-to-br from-emerald-50 to-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold text-slate-500">Sekolah Aktif</p>
                    <div class="grid h-12 w-12 place-items-center rounded-2xl bg-white text-2xl shadow-sm transition group-hover:scale-110">🟢</div>
                </div>
                <p class="mt-5 text-3xl font-black tracking-tight text-emerald-600">{{ $schools->getCollection()->where('status', 'active')->count() }}</p>
                <p class="mt-2 text-[10px] font-medium text-slate-400">Jumlah pada halaman saat ini</p>
            </article>

            {{-- INACTIVE --}}
            <article class="group relative overflow-hidden rounded-[24px] border border-amber-100 bg-gradient-to-br from-amber-50 to-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-bold text-slate-500">Sekolah Nonaktif</p>
                    <div class="grid h-12 w-12 place-items-center rounded-2xl bg-white text-2xl shadow-sm transition group-hover:scale-110">⏸️</div>
                </div>
                <p class="mt-5 text-3xl font-black tracking-tight text-amber-600">{{ $schools->getCollection()->where('status', 'inactive')->count() }}</p>
                <p class="mt-2 text-[10px] font-medium text-slate-400">Jumlah pada halaman saat ini</p>
            </article>

        </div>
    </section>


    {{-- SCHOOL TABLE --}}
    <section class="overflow-hidden rounded-[26px] border border-slate-100 bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-8">
            <div class="flex items-center gap-4">
                <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-emerald-50 text-emerald-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 21h18M5 21V7l8-4 8 4v14M9 21v-6h6v6"/>
                        <path d="M9 9h.01M15 9h.01M9 12h.01M15 12h.01" stroke-width="3" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-black text-slate-800">Daftar Institusi</h2>
                    <p class="mt-1 text-xs text-slate-500">{{ $schools->total() }} sekolah terdaftar</p>
                </div>
            </div>

            <span class="inline-flex w-fit items-center gap-2 rounded-full bg-emerald-50 px-3 py-2 text-[10px] font-black text-emerald-700">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                Data sekolah
            </span>
        </div>


        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px] text-left text-sm">

                <thead>
                    <tr class="bg-slate-50/80 text-[10px] font-black uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-4 sm:px-8">Nama Sekolah</th>
                        <th class="px-6 py-4">NPSN</th>
                        <th class="px-6 py-4">Lokasi</th>
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right sm:px-8">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($schools as $school)
                        <tr class="transition hover:bg-slate-50/80">

                            {{-- SCHOOL NAME --}}
                            <td class="px-6 py-4 sm:px-8">
                                <div class="flex items-center gap-3">
                                    <div class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-sky-50 text-xl">🏫</div>
                                    <div>
                                        <p class="font-extrabold text-slate-800">{{ $school->name }}</p>
                                        <p class="mt-1 text-[10px] font-medium text-slate-400">ID #{{ $school->id }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- NPSN --}}
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs font-semibold text-slate-600">
                                    {{ $school->npsn ?: '—' }}
                                </span>
                            </td>

                            {{-- LOCATION --}}
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-2 text-xs font-medium text-slate-600">
                                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/>
                                        <circle cx="12" cy="10" r="2.5"/>
                                    </svg>
                                    <span>{{ collect([$school->city, $school->province])->filter()->join(', ') ?: '—' }}</span>
                                </div>
                            </td>

                            {{-- USERS --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 rounded-xl bg-sky-50 px-3 py-2 text-xs font-extrabold text-sky-700">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M20 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                    {{ $school->users_count }} pengguna
                                </span>
                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 rounded-full px-3 py-2 text-[10px] font-black {{ $school->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $school->status === 'active' ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    {{ $school->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>

                            {{-- ACTIONS --}}
                            <td class="px-6 py-4 sm:px-8">
                                <div class="flex items-center justify-end gap-2">

                                    <a
                                        href="{{ route('admin.schools.edit', $school) }}"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-sky-100 bg-sky-50 px-3.5 py-2.5 text-xs font-extrabold text-sky-700 transition hover:border-sky-200 hover:bg-sky-100"
                                    >
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M12 20h9"/>
                                            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                                        </svg>
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.schools.destroy', $school) }}"
                                        onsubmit="return confirm('Hapus sekolah ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-rose-100 bg-rose-50 px-3.5 py-2.5 text-xs font-extrabold text-rose-600 transition hover:border-rose-200 hover:bg-rose-100"
                                        >
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M3 6h18M8 6V4h8v2m3 0-1 14H6L5 6m4 4v6m6-6v6"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-sky-50 text-3xl">🏫</div>
                                <p class="mt-4 font-extrabold text-slate-700">Belum ada data sekolah</p>
                                <p class="mt-1 text-xs text-slate-400">Sekolah yang didaftarkan akan muncul di daftar ini.</p>

                                <a href="{{ route('admin.schools.create') }}"
                                   class="mt-5 inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-4 py-2.5 text-xs font-extrabold text-white transition hover:bg-emerald-600">
                                    <span>＋</span> Tambah Sekolah
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="border-t border-slate-100 px-6 py-5 sm:px-8">
            {{ $schools->links() }}
        </div>

    </section>

</div>
@endsection
