
@extends('layouts.teacher')

@section('title', 'Tambah Materi Remediasi')

@section('content')

<div class="space-y-6">

    {{-- HERO --}}
    <section class="relative overflow-hidden rounded-[28px] bg-gradient-to-r from-[#087cf0] via-[#12afe9] to-[#35d99a] p-6 text-white shadow-lg sm:p-8">
        <div class="relative z-10">
            <a href="{{ route('teacher.remedials.index') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-white/85 transition hover:text-white">
                <span>←</span> Kembali ke Materi Remediasi
            </a>

            <div class="mt-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/15 px-3 py-1.5 text-xs font-semibold backdrop-blur">
                <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                NUMERA SMART / RUANG GURU
            </div>

            <h1 class="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">
                Tambah Materi Remediasi
            </h1>

            <p class="mt-3 max-w-2xl text-sm leading-6 text-white/85 sm:text-base">
                Buat materi pembelajaran tambahan berdasarkan topik numerasi siswa untuk membantu mereka memahami konsep yang belum dikuasai.
            </p>
        </div>

        <div class="pointer-events-none absolute -right-12 -top-16 h-56 w-56 rounded-full bg-white/10 blur-2xl"></div>
        <div class="pointer-events-none absolute -bottom-20 right-1/3 h-48 w-48 rounded-full bg-emerald-300/20 blur-3xl"></div>

        <div class="pointer-events-none absolute bottom-4 right-8 hidden opacity-25 lg:block">
            <svg class="h-36 w-36 animate-[remedialFloat_4s_ease-in-out_infinite]"
                 viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="29" y="20" width="102" height="122" rx="13" fill="white"/>
                <rect x="45" y="42" width="70" height="9" rx="4.5" fill="#087CF0"/>
                <rect x="45" y="63" width="46" height="7" rx="3.5" fill="#35D99A"/>
                <rect x="45" y="80" width="61" height="7" rx="3.5" fill="#35D99A"/>
                <rect x="45" y="97" width="53" height="7" rx="3.5" fill="#35D99A"/>
                <circle cx="111" cy="117" r="17" fill="#087CF0"/>
                <path d="M103 117L109 123L120 110" stroke="white" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </section>

    {{-- VALIDASI ERROR --}}
    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-5 text-sm text-red-700">
            <div class="flex items-start gap-3">
                <span class="text-xl">⚠️</span>
                <div>
                    <p class="font-bold">Periksa kembali data berikut:</p>
                    <ul class="mt-2 list-inside list-disc space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('teacher.remedials.store') }}"
          method="POST"
          class="space-y-6">

        @csrf

        {{-- INFORMASI DASAR --}}
        <section class="overflow-hidden rounded-[24px] border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-gradient-to-r from-blue-50/80 to-cyan-50/50 px-6 py-5 sm:px-7">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-100 text-xl">
                        📚
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-800">Informasi Materi</h2>
                        <p class="mt-0.5 text-sm text-slate-500">Tentukan topik dan identitas materi remediasi.</p>
                    </div>
                </div>
            </div>

            <div class="space-y-6 p-6 sm:p-7">

                {{-- TOPIK --}}
                <div>
                    <label for="topic_id" class="mb-2 block text-sm font-bold text-slate-700">
                        Topik Numerasi <span class="text-red-500">*</span>
                    </label>

                    <select name="topic_id"
                            id="topic_id"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">

                        <option value="">Pilih topik numerasi</option>

                        @foreach($topics as $topic)
                            <option value="{{ $topic->id }}"
                                @selected(old('topic_id') == $topic->id)>
                                Kelas {{ $topic->grade_level }} — {{ $topic->title }}
                            </option>
                        @endforeach

                    </select>

                    <p class="mt-2 text-xs text-slate-400">
                        Pilih topik yang sesuai dengan materi pembelajaran.
                    </p>
                </div>

                {{-- JUDUL --}}
                <div>
                    <label for="title" class="mb-2 block text-sm font-bold text-slate-700">
                        Judul Materi <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           name="title"
                           id="title"
                           value="{{ old('title') }}"
                           required
                           maxlength="255"
                           placeholder="Contoh: Memahami Penjumlahan dan Pengurangan"
                           class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">

                    <p class="mt-2 text-xs text-slate-400">
                        Gunakan judul yang singkat dan mudah dipahami siswa.
                    </p>
                </div>

                {{-- DESKRIPSI --}}
                <div>
                    <label for="description" class="mb-2 block text-sm font-bold text-slate-700">
                        Deskripsi Materi
                    </label>

                    <textarea name="description"
                              id="description"
                              rows="3"
                              maxlength="1000"
                              placeholder="Jelaskan secara singkat apa yang akan dipelajari siswa..."
                              class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">{{ old('description') }}</textarea>

                    <p class="mt-2 text-xs text-slate-400">
                        Berikan gambaran singkat tentang tujuan pembelajaran remediasi.
                    </p>
                </div>

            </div>
        </section>

        {{-- KONTEN PEMBELAJARAN --}}
        <section class="overflow-hidden rounded-[24px] border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-gradient-to-r from-cyan-50/80 to-emerald-50/50 px-6 py-5 sm:px-7">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-cyan-100 text-xl">
                        ✏️
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-800">Konten Pembelajaran</h2>
                        <p class="mt-0.5 text-sm text-slate-500">Susun penjelasan dan contoh untuk membantu siswa belajar.</p>
                    </div>
                </div>
            </div>

            <div class="space-y-6 p-6 sm:p-7">

                {{-- ISI MATERI --}}
                <div>
                    <label for="content" class="mb-2 block text-sm font-bold text-slate-700">
                        Isi Materi <span class="text-red-500">*</span>
                    </label>

                    <textarea name="content"
                              id="content"
                              rows="10"
                              required
                              placeholder="Tuliskan penjelasan materi secara lengkap di sini..."
                              class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-7 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">{{ old('content') }}</textarea>

                    <p class="mt-2 text-xs text-slate-400">
                        Jelaskan konsep, langkah penyelesaian, dan hal penting yang perlu dipahami siswa.
                    </p>
                </div>

                {{-- CONTOH SOAL --}}
                <div>
                    <label for="example_content" class="mb-2 block text-sm font-bold text-slate-700">
                        Contoh Soal dan Pembahasan
                    </label>

                    <textarea name="example_content"
                              id="example_content"
                              rows="7"
                              placeholder="Contoh: 125 + 75 = 200. Pembahasan: ..."
                              class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-7 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">{{ old('example_content') }}</textarea>

                    <p class="mt-2 text-xs text-slate-400">
                        Berikan contoh soal beserta tahapan penyelesaiannya.
                    </p>
                </div>

            </div>
        </section>

        {{-- KLASIFIKASI NEWMAN --}}
        @php
            $newmanStages = [
                'reading' => 'Reading (Membaca)',
                'comprehension' => 'Comprehension (Memahami)',
                'transformation' => 'Transformation (Transformasi)',
                'process_skills' => 'Process Skills (Keterampilan Proses)',
                'encoding' => 'Encoding (Penulisan Jawaban)',
            ];
        @endphp

        <section class="overflow-hidden rounded-[24px] border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-gradient-to-r from-indigo-50/80 to-blue-50/50 px-6 py-5 sm:px-7">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-100 text-xl">
                        🎯
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-800">
                            Klasifikasi Tahapan Newman
                        </h2>
                        <p class="mt-0.5 text-sm text-slate-500">
                            Tentukan fokus kesulitan yang ingin ditangani melalui materi ini.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-7">

                <p class="mb-5 text-sm leading-6 text-slate-500">
                    Pilih satu atau beberapa tahapan Newman yang menjadi fokus materi remediasi ini.
                </p>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                    @foreach($newmanStages as $value => $label)

                        <label class="group flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50/70 p-4 transition duration-200 hover:border-indigo-300 hover:bg-indigo-50/60 has-[:checked]:border-indigo-400 has-[:checked]:bg-indigo-50">

                            <input type="checkbox"
                                   name="newman_stages[]"
                                   value="{{ $value }}"
                                   @checked(in_array($value, old('newman_stages', [])))
                                   class="h-5 w-5 shrink-0 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">

                            <span class="text-sm font-semibold text-slate-700 transition group-hover:text-indigo-700">
                                {{ $label }}
                            </span>

                        </label>

                    @endforeach

                </div>

                @error('newman_stages')
                    <p class="mt-3 text-sm font-medium text-red-600">{{ $message }}</p>
                @enderror

                @error('newman_stages.*')
                    <p class="mt-3 text-sm font-medium text-red-600">{{ $message }}</p>
                @enderror

            </div>
        </section>

        {{-- INFORMASI STATUS --}}
        <section class="overflow-hidden rounded-2xl border border-amber-200 bg-amber-50/80 p-5">
            <div class="flex items-start gap-4">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-xl">
                    📝
                </div>

                <div>
                    <p class="font-extrabold text-amber-900">
                        Materi akan disimpan sebagai Draft
                    </p>

                    <p class="mt-1 text-sm leading-6 text-amber-800">
                        Materi belum dapat dilihat siswa sampai guru menambahkan minimal satu soal latihan aktif dan memublikasikannya.
                    </p>

                    <span class="mt-3 inline-flex rounded-full border border-amber-200 bg-white px-3 py-1 text-xs font-bold text-amber-700">
                        STATUS: DRAFT
                    </span>
                </div>
            </div>
        </section>

        {{-- TOMBOL --}}
        <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:justify-end">

            <a href="{{ route('teacher.remedials.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-bold text-slate-600 transition hover:bg-slate-50">
                Batal
            </a>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#087cf0] to-[#12afe9] px-7 py-3 text-sm font-bold text-white shadow-lg shadow-blue-100 transition hover:-translate-y-0.5 hover:shadow-xl">
                <span>✓</span>
                Simpan Materi
            </button>

        </div>

    </form>

</div>

<style>
    @keyframes remedialFloat {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-8px);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .animate-\[remedialFloat_4s_ease-in-out_infinite\] {
            animation: none !important;
        }
    }
</style>

@endsection
