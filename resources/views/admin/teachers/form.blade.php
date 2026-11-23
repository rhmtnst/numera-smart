
@extends('layouts.admin')

@section('title', isset($user) ? 'Edit Guru' : 'Tambah Guru')

@section('content')
<div class="mx-auto max-w-3xl space-y-7">

    {{-- BACK NAVIGATION --}}
    <a href="{{ route('admin.teachers.index') }}"
       class="inline-flex items-center gap-2 text-sm font-bold text-emerald-700 transition hover:text-emerald-900">
        <span class="text-lg">←</span>
        Kembali ke Data Guru
    </a>


    {{-- HERO --}}
    <section class="relative isolate overflow-hidden rounded-[28px] bg-gradient-to-br from-[#087f68] via-[#0da991] to-[#16b9c9] p-7 text-white shadow-xl shadow-emerald-900/10 sm:p-9">
        <div class="pointer-events-none absolute -right-12 -top-20 h-64 w-64 rounded-full border-[32px] border-white/[0.08]"></div>
        <div class="pointer-events-none absolute -bottom-24 right-1/3 h-48 w-48 rounded-full bg-cyan-200/10"></div>

        <div class="relative z-10 flex items-center justify-between gap-5">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3.5 py-2 text-[10px] font-black uppercase tracking-[.18em] text-emerald-50">
                    <span class="h-2 w-2 rounded-full bg-lime-300"></span>
                    Administrasi / Pengguna
                </div>

                <h1 class="mt-5 text-3xl font-black tracking-tight sm:text-4xl">
                    {{ isset($user) ? 'Perbarui Data Guru' : 'Tambah Guru Baru' }}
                </h1>

                <p class="mt-3 max-w-lg text-sm leading-7 text-emerald-50">
                    Lengkapi identitas akun dan informasi sekolah tempat guru bertugas.
                </p>
            </div>

            <div class="hidden h-24 w-24 shrink-0 items-center justify-center rounded-3xl border border-white/20 bg-white/10 text-5xl shadow-lg backdrop-blur-sm sm:flex">
                🧑‍🏫
            </div>
        </div>
    </section>


    {{-- NOTIFICATIONS --}}
    @if(session('success'))
        <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-bold text-emerald-700">
            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-emerald-100">✓</span>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 p-5 text-sm text-rose-700">
            <div class="mb-3 flex items-center gap-2 font-black">
                <span class="text-lg">⚠️</span>
                Periksa kembali data yang dimasukkan.
            </div>

            <ul class="list-inside list-disc space-y-1.5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- FORM --}}
    <form
        method="POST"
        action="{{ isset($user) ? route('admin.teachers.update', $user) : route('admin.teachers.store') }}"
        class="overflow-hidden rounded-[26px] border border-slate-100 bg-white shadow-sm"
    >
        @csrf

        @if(isset($user))
            @method('PUT')
        @endif

        <div class="space-y-7 p-6 sm:p-8">

            {{-- SECTION: PERSONAL INFORMATION --}}
            <div>
                <div class="mb-5 flex items-center gap-3">
                    <div class="grid h-11 w-11 place-items-center rounded-2xl bg-emerald-50 text-xl">
                        👤
                    </div>
                    <div>
                        <h2 class="font-black text-slate-800">Informasi Guru</h2>
                        <p class="mt-1 text-xs text-slate-400">Identitas dasar tenaga pengajar</p>
                    </div>
                </div>

                <div class="space-y-5">

                    {{-- NAME --}}
                    <div>
                        <label for="name" class="mb-2 block text-sm font-bold text-slate-700">
                            Nama Lengkap
                            <span class="text-rose-500">*</span>
                        </label>

                        <input
                            id="name"
                            required
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name ?? '') }}"
                            placeholder="Masukkan nama lengkap guru"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-medium text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                        >
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label for="email" class="mb-2 block text-sm font-bold text-slate-700">
                            Alamat Email
                            <span class="text-rose-500">*</span>
                        </label>

                        <input
                            id="email"
                            required
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email ?? '') }}"
                            placeholder="nama@email.com"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-medium text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                        >
                    </div>

                    {{-- SCHOOL --}}
                    <div>
                        <label for="school_id" class="mb-2 block text-sm font-bold text-slate-700">
                            Sekolah
                            <span class="text-rose-500">*</span>
                        </label>

                        <select
                            id="school_id"
                            required
                            name="school_id"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-medium text-slate-700 outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                        >
                            <option value="">Pilih sekolah</option>

                            @foreach($schools as $school)
                                <option
                                    value="{{ $school->id }}"
                                    @selected(old('school_id', $user->school_id ?? '') == $school->id)
                                >
                                    {{ $school->name }}
                                </option>
                            @endforeach
                        </select>

                        <p class="mt-2 text-xs text-slate-400">
                            Pilih institusi tempat guru menjalankan kegiatan pembelajaran.
                        </p>
                    </div>

                </div>
            </div>


            <div class="border-t border-slate-100"></div>


            {{-- SECTION: PASSWORD --}}
            <div>
                <div class="mb-5 flex items-center gap-3">
                    <div class="grid h-11 w-11 place-items-center rounded-2xl bg-sky-50 text-xl">
                        🔐
                    </div>
                    <div>
                        <h2 class="font-black text-slate-800">
                            {{ isset($user) ? 'Perubahan Password' : 'Keamanan Akun' }}
                        </h2>
                        <p class="mt-1 text-xs text-slate-400">
                            {{ isset($user) ? 'Kosongkan jika password tidak ingin diubah' : 'Buat password untuk akun guru baru' }}
                        </p>
                    </div>
                </div>

                @if(!isset($user))
                    <div class="grid gap-5 sm:grid-cols-2">

                        <div>
                            <label for="password" class="mb-2 block text-sm font-bold text-slate-700">
                                Password
                                <span class="text-rose-500">*</span>
                            </label>

                            <input
                                id="password"
                                required
                                type="password"
                                name="password"
                                placeholder="Masukkan password"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                            >
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-2 block text-sm font-bold text-slate-700">
                                Konfirmasi Password
                                <span class="text-rose-500">*</span>
                            </label>

                            <input
                                id="password_confirmation"
                                required
                                type="password"
                                name="password_confirmation"
                                placeholder="Ulangi password"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                            >
                        </div>

                    </div>
                @else
                    <div class="grid gap-5 sm:grid-cols-2">

                        <div>
                            <label for="password" class="mb-2 block text-sm font-bold text-slate-700">
                                Password Baru
                            </label>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="Kosongkan jika tidak diubah"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                            >
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-2 block text-sm font-bold text-slate-700">
                                Konfirmasi Password Baru
                            </label>

                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                placeholder="Ulangi password baru"
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm outline-none transition focus:border-emerald-400 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                            >
                        </div>

                    </div>
                @endif
            </div>


            {{-- SECTION: ACCOUNT STATUS (EDIT ONLY) --}}
            @if(isset($user))
                <div class="border-t border-slate-100 pt-6">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="grid h-11 w-11 place-items-center rounded-2xl bg-amber-50 text-xl">
                            ⚙️
                        </div>
                        <div>
                            <h2 class="font-black text-slate-800">Status Akun</h2>
                            <p class="mt-1 text-xs text-slate-400">Atur akses akun guru</p>
                        </div>
                    </div>

                    <input type="hidden" name="is_active" value="0">

                    <label class="flex cursor-pointer items-center gap-4 rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4 transition hover:bg-emerald-50">
                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            @checked(old('is_active', $user->is_active))
                            class="h-5 w-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                        >

                        <span class="flex-1">
                            <span class="block text-sm font-extrabold text-emerald-900">
                                Akun guru aktif
                            </span>
                            <span class="mt-1 block text-xs leading-5 text-emerald-700">
                                Guru dapat menggunakan akun untuk mengakses sistem sesuai hak aksesnya.
                            </span>
                        </span>
                    </label>
                </div>
            @endif

        </div>


        {{-- FORM FOOTER --}}
        <div class="flex flex-col-reverse justify-between gap-3 border-t border-slate-100 bg-slate-50/70 px-6 py-5 sm:flex-row sm:items-center sm:px-8">
            <a
                href="{{ route('admin.teachers.index') }}"
                class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-center text-sm font-bold text-slate-600 transition hover:bg-slate-100"
            >
                Batalkan
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 px-6 py-3.5 text-sm font-black text-white shadow-lg shadow-emerald-500/20 transition hover:-translate-y-0.5 hover:shadow-xl"
            >
                {{ isset($user) ? 'Simpan Perubahan' : 'Simpan Data Guru' }}
                <span>→</span>
            </button>
        </div>

    </form>
</div>
@endsection
