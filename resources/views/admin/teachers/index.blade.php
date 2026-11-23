
@extends('layouts.admin')

@section('title', 'Manajemen Guru')

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
                    Administrasi / Tenaga Pengajar
                </div>

                <h1 class="mt-5 text-3xl font-black tracking-tight sm:text-4xl">
                    Manajemen Guru
                    <span class="ml-1 inline-block">🧑‍🏫</span>
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-7 text-emerald-50">
                    Kelola akun tenaga pengajar, informasi institusi, dan status keaktifan guru yang menggunakan NUMERA SMART.
                </p>

                <a href="{{ route('admin.teachers.create') }}"
                   class="mt-7 inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-3.5 text-sm font-extrabold text-emerald-800 shadow-lg transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Tambah Guru
                </a>
            </div>

            <div class="hidden h-32 w-32 shrink-0 items-center justify-center rounded-[28px] border border-white/20 bg-white/10 shadow-xl backdrop-blur-md sm:flex">
                <svg class="h-20 w-20 text-white" viewBox="0 0 100 100" fill="none">
                    <circle cx="50" cy="29" r="15" stroke="currentColor" stroke-width="3"/>
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


    {{-- TEACHER LIST --}}
    <section class="overflow-hidden rounded-[26px] border border-slate-100 bg-white shadow-sm">

        {{-- HEADER --}}
        <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-8">
            <div class="flex items-center gap-4">
                <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-emerald-50 text-emerald-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M20 8v6M23 11h-6"/>
                    </svg>
                </div>

                <div>
                    <h2 class="text-lg font-black text-slate-800">Daftar Tenaga Pengajar</h2>
                    <p class="mt-1 text-xs text-slate-500">{{ $users->total() }} akun guru terdaftar</p>
                </div>
            </div>

            <div class="inline-flex w-fit items-center gap-2 rounded-full bg-emerald-50 px-3 py-2 text-[10px] font-black text-emerald-700">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                Data tenaga pengajar
            </div>
        </div>


        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left text-sm">

                <thead>
                    <tr class="bg-slate-50/80 text-[10px] font-black uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-4 sm:px-8">Nama Guru</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Sekolah</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right sm:px-8">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $u)
                        <tr class="transition hover:bg-slate-50/80">

                            {{-- TEACHER NAME --}}
                            <td class="px-6 py-4 sm:px-8">
                                <div class="flex items-center gap-3">
                                    <div class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-emerald-50 text-xl">
                                        🧑‍🏫
                                    </div>

                                    <div>
                                        <p class="font-extrabold text-slate-800">{{ $u->name }}</p>
                                        <p class="mt-1 text-[10px] font-medium text-slate-400">Tenaga pengajar</p>
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
                                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-sky-50 text-base">🏫</span>
                                    <span class="font-semibold text-slate-600">{{ $u->school?->name ?? '—' }}</span>
                                </div>
                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 rounded-full px-3 py-2 text-[10px] font-black {{ $u->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $u->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    {{ $u->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>

                            {{-- ACTION --}}
                            <td class="px-6 py-4 text-right sm:px-8">
                                <a
                                    href="{{ route('admin.teachers.edit', $u) }}"
                                    class="inline-flex items-center gap-2 rounded-xl border border-sky-100 bg-sky-50 px-4 py-2.5 text-xs font-extrabold text-sky-700 transition hover:border-sky-200 hover:bg-sky-100"
                                >
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 20h9"/>
                                        <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                                    </svg>
                                    Edit Guru
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-emerald-50 text-3xl">
                                    🧑‍🏫
                                </div>
                                <p class="mt-4 font-extrabold text-slate-700">Belum ada data guru</p>
                                <p class="mt-1 text-xs text-slate-400">
                                    Akun guru yang didaftarkan akan muncul di sini.
                                </p>

                                <a href="{{ route('admin.teachers.create') }}"
                                   class="mt-5 inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-4 py-2.5 text-xs font-extrabold text-white transition hover:bg-emerald-600">
                                    <span>＋</span> Tambah Guru
                                </a>
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
