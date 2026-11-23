
@extends('layouts.admin')

@section('title', 'Tambah Sekolah')

@section('content')
<div class="space-y-7">

    {{-- HERO --}}
    <section class="relative isolate overflow-hidden rounded-[28px] bg-gradient-to-br from-sky-600 via-blue-600 to-indigo-600 p-7 text-white shadow-xl shadow-blue-900/10 sm:p-9">
        <div class="pointer-events-none absolute -right-16 -top-20 h-72 w-72 rounded-full border-[36px] border-white/[0.10]"></div>
        <div class="pointer-events-none absolute -bottom-32 right-1/4 h-64 w-64 rounded-full bg-cyan-300/10"></div>

        <div class="relative z-10 flex flex-col justify-between gap-6 sm:flex-row sm:items-center">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3.5 py-2 text-[10px] font-black uppercase tracking-[.18em] text-blue-50 backdrop-blur-sm">
                    <span class="h-2 w-2 rounded-full bg-cyan-300"></span>
                    Administrasi / Sekolah
                </div>

                <h1 class="mt-5 text-3xl font-black tracking-tight sm:text-4xl">
                    Tambah Sekolah
                    <span class="ml-1 inline-block">🏫</span>
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-7 text-blue-50">
                    Daftarkan institusi pendidikan baru untuk bergabung dan menggunakan platform pembelajaran NUMERA SMART.
                </p>
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

    {{-- FORM CONTAINER --}}
    <section class="overflow-hidden rounded-[26px] border border-slate-100 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-5 sm:px-8">
            <div class="flex items-center gap-4">
                <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-blue-50 text-blue-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-black text-slate-800">Informasi Sekolah</h2>
                    <p class="mt-1 text-xs text-slate-500">Lengkapi informasi sekolah pada formulir berikut.</p>
                </div>
            </div>
        </div>

        <div class="p-6 sm:p-8">
            @include('admin.schools.form')
        </div>
    </section>

</div>
@endsection
