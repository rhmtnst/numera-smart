
@extends('layouts.admin')

@section('title', 'Kode Sekolah')

@section('content')
<div class="space-y-8">

    {{-- HERO --}}
    <section class="relative isolate overflow-hidden rounded-[28px] bg-gradient-to-br from-[#d97706] via-[#f59e0b] to-[#f97316] p-7 text-white shadow-xl shadow-orange-900/10 sm:p-9">
        <div class="pointer-events-none absolute -right-16 -top-20 h-72 w-72 rounded-full border-[36px] border-white/[0.10]"></div>
        <div class="pointer-events-none absolute -bottom-32 right-1/4 h-64 w-64 rounded-full bg-yellow-200/20"></div>

        <div class="relative z-10 flex flex-col justify-between gap-6 sm:flex-row sm:items-center">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-3.5 py-2 text-[10px] font-black uppercase tracking-[.18em] text-orange-50 backdrop-blur-sm">
                    <span class="h-2 w-2 rounded-full bg-yellow-200"></span>
                    Administrasi / Registrasi
                </div>

                <h1 class="mt-5 text-3xl font-black tracking-tight sm:text-4xl">
                    Kode Pendaftaran Sekolah
                    <span class="ml-1 inline-block">🔐</span>
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-7 text-orange-50">
                    Buat dan pantau kode pendaftaran yang digunakan pengguna untuk bergabung dengan sekolah di NUMERA SMART.
                </p>
            </div>

            <div class="hidden h-32 w-32 shrink-0 items-center justify-center rounded-[28px] border border-white/20 bg-white/10 shadow-xl backdrop-blur-md sm:flex">
                <svg class="h-20 w-20 text-white" viewBox="0 0 100 100" fill="none">
                    <rect x="19" y="40" width="62" height="48" rx="11" stroke="currentColor" stroke-width="3"/>
                    <path d="M32 40V29C32 19 40 11 50 11C60 11 68 19 68 29V40" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                    <circle cx="50" cy="60" r="6" fill="currentColor"/>
                    <path d="M50 66V75" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                    <path d="M11 25L17 31M89 25L83 31" stroke="currentColor" stroke-width="3" stroke-linecap="round" opacity=".6"/>
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


    {{-- ERROR NOTIFICATION --}}
    @if($errors->any())
        <div class="flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm font-semibold text-rose-700">
            <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-rose-100">!</span>
            <div class="pt-1">{{ $errors->first() }}</div>
        </div>
    @endif


    {{-- CREATE NEW CODE --}}
    <section class="overflow-hidden rounded-[26px] border border-slate-100 bg-white shadow-sm">

        <div class="border-b border-slate-100 px-6 py-5 sm:px-8">
            <div class="flex items-center gap-4">
                <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-amber-50 text-amber-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-black text-slate-800">Buat Kode Baru</h2>
                    <p class="mt-1 text-xs text-slate-500">Tentukan sekolah dan batas penggunaan kode pendaftaran.</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.codes.store') }}" class="p-6 sm:p-8">
            @csrf

            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">

                {{-- SCHOOL --}}
                <div>
                    <label for="school_id" class="mb-2 block text-xs font-extrabold uppercase tracking-wider text-slate-600">
                        Sekolah <span class="text-rose-500">*</span>
                    </label>

                    <select
                        id="school_id"
                        name="school_id"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-medium text-slate-700 outline-none transition focus:border-amber-400 focus:bg-white focus:ring-4 focus:ring-amber-50"
                    >
                        <option value="">Pilih sekolah</option>
                        @foreach($schools as $s)
                            <option value="{{ $s->id }}" {{ old('school_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- MAX USES --}}
                <div>
                    <label for="max_uses" class="mb-2 block text-xs font-extrabold uppercase tracking-wider text-slate-600">
                        Batas Penggunaan
                    </label>

                    <input
                        id="max_uses"
                        name="max_uses"
                        type="number"
                        min="1"
                        value="{{ old('max_uses') }}"
                        placeholder="Opsional"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-medium text-slate-700 outline-none transition placeholder:font-normal placeholder:text-slate-400 focus:border-amber-400 focus:bg-white focus:ring-4 focus:ring-amber-50"
                    >

                    <p class="mt-2 text-[10px] text-slate-400">Kosongkan jika tidak ingin menetapkan batas.</p>
                </div>

                {{-- EXPIRATION --}}
                <div>
                    <label for="expires_at" class="mb-2 block text-xs font-extrabold uppercase tracking-wider text-slate-600">
                        Kedaluwarsa
                    </label>

                    <input
                        id="expires_at"
                        name="expires_at"
                        type="datetime-local"
                        value="{{ old('expires_at') }}"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3.5 text-sm font-medium text-slate-700 outline-none transition focus:border-amber-400 focus:bg-white focus:ring-4 focus:ring-amber-50"
                    >

                    <p class="mt-2 text-[10px] text-slate-400">Opsional, tentukan batas waktu penggunaan.</p>
                </div>

            </div>

            <div class="mt-6 flex flex-col gap-4 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-2 text-xs text-slate-400">
                    <svg class="h-4 w-4 shrink-0 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 11v5M12 8h.01" stroke-linecap="round"/>
                    </svg>
                    Kode akan dibuat melalui sistem setelah formulir disimpan.
                </div>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-amber-100 transition duration-300 hover:-translate-y-0.5 hover:shadow-xl"
                >
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Buat Kode Sekolah
                </button>
            </div>
        </form>
    </section>


    {{-- REGISTERED CODES --}}
    <section class="overflow-hidden rounded-[26px] border border-slate-100 bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-8">
            <div class="flex items-center gap-4">
                <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-orange-50 text-orange-600">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <path d="M7 10h4M7 14h10"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-black text-slate-800">Kode Terdaftar</h2>
                    <p class="mt-1 text-xs text-slate-500">Kelola status dan penggunaan kode pendaftaran sekolah.</p>
                </div>
            </div>

            <div class="inline-flex w-fit items-center gap-2 rounded-full bg-amber-50 px-3 py-2 text-[10px] font-bold text-amber-700">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                Manajemen kode
            </div>
        </div>


        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">

                <thead>
                    <tr class="bg-slate-50/80 text-[10px] font-black uppercase tracking-wider text-slate-500">
                        <th class="px-6 py-4 sm:px-8">Kode Pendaftaran</th>
                        <th class="px-6 py-4">Sekolah</th>
                        <th class="px-6 py-4">Penggunaan</th>
                        <th class="px-6 py-4">Kedaluwarsa</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right sm:px-8">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($codes as $c)
                        <tr class="transition hover:bg-slate-50/80">

                            {{-- CODE --}}
                            <td class="px-6 py-4 sm:px-8">
                                <div class="inline-flex items-center gap-2 rounded-xl border border-amber-100 bg-amber-50 px-3.5 py-2.5">
                                    <svg class="h-4 w-4 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M7 14a5 5 0 1 1 3.5 4.77L8 21H5v-3l2.5-2.5A5 5 0 0 1 7 14Z"/>
                                        <circle cx="14" cy="9" r="1"/>
                                    </svg>
                                    <span class="font-mono text-xs font-black tracking-wider text-amber-800">
                                        {{ $c->code }}
                                    </span>
                                </div>
                            </td>

                            {{-- SCHOOL --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2.5">
                                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-sky-50 text-base">🏫</span>
                                    <span class="font-semibold text-slate-700">{{ $c->school->name }}</span>
                                </div>
                            </td>

                            {{-- USAGE --}}
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-700">
                                    {{ $c->uses }}
                                    <span class="font-medium text-slate-400">/</span>
                                    {{ $c->max_uses ?? '∞' }}
                                </div>
                                @if($c->max_uses)
                                    <div class="mt-2 h-1.5 w-20 overflow-hidden rounded-full bg-slate-100">
                                        <div
                                            class="h-full rounded-full bg-amber-400"
                                            style="width: {{ min(100, ($c->uses / max(1, $c->max_uses)) * 100) }}%"
                                        ></div>
                                    </div>
                                @endif
                            </td>

                            {{-- EXPIRATION --}}
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold text-slate-600">
                                    {{ $c->expires_at?->format('d-m-Y H:i') ?? 'Tidak ada' }}
                                </span>
                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 rounded-full px-3 py-2 text-[10px] font-black {{ $c->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $c->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    {{ $c->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>

                            {{-- ACTIONS --}}
                            <td class="px-6 py-4 sm:px-8">
                                <div class="flex items-center justify-end gap-2">

                                    {{-- TOGGLE STATUS --}}
                                    <form method="POST" action="{{ route('admin.codes.toggle', $c) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-sky-100 bg-sky-50 px-3 py-2.5 text-[11px] font-extrabold text-sky-700 transition hover:border-sky-200 hover:bg-sky-100"
                                        >
                                            @if($c->is_active)
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect x="3" y="3" width="18" height="18" rx="4"/>
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

                                    {{-- DELETE --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.codes.destroy', $c) }}"
                                        onsubmit="return confirm('Hapus kode ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-rose-100 bg-rose-50 px-3 py-2.5 text-[11px] font-extrabold text-rose-600 transition hover:border-rose-200 hover:bg-rose-100"
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
                                <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-amber-50 text-3xl">🔐</div>
                                <p class="mt-4 font-extrabold text-slate-700">Belum ada kode pendaftaran</p>
                                <p class="mt-1 text-xs text-slate-400">Kode sekolah yang dibuat akan muncul di daftar ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="border-t border-slate-100 px-6 py-5 sm:px-8">
            {{ $codes->links() }}
        </div>

    </section>

</div>
@endsection
