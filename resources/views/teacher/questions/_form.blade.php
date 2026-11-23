
@csrf

@if (isset($method) && $method === 'PUT')
    @method('PUT')
@endif

<style>
    .question-field {
        width: 100%;
        border: 1px solid #dbe5f0;
        border-radius: 14px;
        background: #f8fbff;
        padding: 13px 15px;
        color: #243449;
        outline: none;
        transition: border-color .2s, box-shadow .2s, background .2s;
    }

    .question-field:focus {
        border-color: #2798ed;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(39, 152, 237, .12);
    }

    .question-field::placeholder {
        color: #9aabc0;
    }

    .question-section {
        border: 1px solid #e8eef6;
        border-radius: 20px;
        background: #fff;
        padding: 22px;
    }

    .question-label {
        display: block;
        margin-bottom: 9px;
        color: #34465e;
        font-size: 14px;
        font-weight: 700;
    }

    .question-error {
        margin-top: 7px;
        color: #dc2626;
        font-size: 12px;
        font-weight: 500;
    }

    .question-option {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
        border: 1px solid #e8eef6;
        border-radius: 15px;
        background: #fbfdff;
        padding: 12px;
        transition: .2s ease;
    }

    .question-option:focus-within {
        border-color: #65b7f5;
        background: #f4faff;
    }

    .question-option:last-child {
        margin-bottom: 0;
    }

    .question-option-letter {
        display: flex;
        width: 38px;
        height: 38px;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #eaf4ff;
        color: #147bd1;
        font-weight: 800;
    }

    .question-option input {
        min-width: 0;
        flex: 1;
        border: 0;
        background: transparent;
        padding: 8px 2px;
        color: #243449;
        outline: none;
    }

    .question-option input::placeholder {
        color: #a0aec0;
    }

    @media (max-width: 640px) {
        .question-section {
            padding: 16px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .question-field,
        .question-option {
            transition: none;
        }
    }
</style>

<div class="space-y-6">

    {{-- INFORMASI DASAR --}}
    <section class="question-section space-y-5">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-xl">
                📚
            </div>
            <div>
                <h2 class="font-bold text-gray-800">Informasi Dasar Soal</h2>
                <p class="text-xs text-gray-500">Tentukan topik dan konteks soal.</p>
            </div>
        </div>

        <div>
            <label class="question-label">Topik Pembelajaran <span class="text-red-500">*</span></label>

            <select name="topic_id" required class="question-field">
                <option value="">Pilih topik pembelajaran</option>

                @foreach ($topics as $topic)
                    <option value="{{ $topic->id }}"
                        @selected(old('topic_id', $question->topic_id ?? '') == $topic->id)>
                        Kelas {{ $topic->grade_level }} · {{ $topic->title }}
                    </option>
                @endforeach
            </select>

            @error('topic_id')
                <p class="question-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="question-label">Stimulus Soal</label>

            <textarea name="stimulus" rows="4"
                class="question-field resize-y"
                placeholder="Tuliskan cerita, ilustrasi, atau konteks yang menjadi dasar pertanyaan...">{{ old('stimulus', $question->stimulus ?? '') }}</textarea>

            @error('stimulus')
                <p class="question-error">{{ $message }}</p>
            @enderror

            <p class="mt-2 text-xs text-gray-400">
                💡 Gunakan stimulus yang dekat dengan kehidupan sehari-hari siswa.
            </p>
        </div>
    </section>

    {{-- PERTANYAAN --}}
    <section class="question-section space-y-4">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-cyan-50 text-xl">
                ✏️
            </div>
            <div>
                <h2 class="font-bold text-gray-800">Pertanyaan</h2>
                <p class="text-xs text-gray-500">Tuliskan pertanyaan numerasi yang akan dijawab siswa.</p>
            </div>
        </div>

        <div>
            <label class="question-label">Isi Pertanyaan <span class="text-red-500">*</span></label>

            <textarea name="question_text" rows="4" required
                class="question-field resize-y"
                placeholder="Tuliskan pertanyaan numerasi di sini...">{{ old('question_text', $question->question_text ?? '') }}</textarea>

            @error('question_text')
                <p class="question-error">{{ $message }}</p>
            @enderror
        </div>
    </section>

    {{-- PILIHAN JAWABAN --}}
    <section class="question-section space-y-5">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-violet-50 text-xl">
                📝
            </div>
            <div>
                <h2 class="font-bold text-gray-800">Pilihan Jawaban</h2>
                <p class="text-xs text-gray-500">Masukkan empat alternatif jawaban.</p>
            </div>
        </div>

        <div class="space-y-3">
            @foreach (['A', 'B', 'C', 'D'] as $label)
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-600">
                        Pilihan {{ $label }}
                    </label>

                    <div class="question-option">
                        <div class="question-option-letter">{{ $label }}</div>

                        <input type="text"
                            name="options[{{ $label }}]"
                            required
                            value="{{ old('options.'.$label, isset($question) ? $question->options->firstWhere('option_label', $label)?->option_text : '') }}"
                            placeholder="Tuliskan jawaban {{ $label }}...">
                    </div>

                    @error('options.'.$label)
                        <p class="question-error">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach
        </div>
    </section>

    {{-- KUNCI JAWABAN DAN PEMBAHASAN --}}
    <section class="question-section space-y-5">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-50 text-xl">
                🎯
            </div>
            <div>
                <h2 class="font-bold text-gray-800">Kunci Jawaban & Pembahasan</h2>
                <p class="text-xs text-gray-500">Tentukan jawaban yang benar dan cara penyelesaiannya.</p>
            </div>
        </div>

        <div>
            <label class="question-label">Kunci Jawaban <span class="text-red-500">*</span></label>

            <select name="correct_answer" required class="question-field">
                <option value="">Pilih jawaban yang benar</option>

                @foreach (['A', 'B', 'C', 'D'] as $label)
                    <option value="{{ $label }}"
                        @selected(old('correct_answer', $question->correct_answer ?? '') === $label)>
                        Jawaban {{ $label }}
                    </option>
                @endforeach
            </select>

            @error('correct_answer')
                <p class="question-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="question-label">Pembahasan <span class="text-red-500">*</span></label>

            <textarea name="explanation" rows="5" required
                class="question-field resize-y"
                placeholder="Jelaskan langkah penyelesaian, perhitungan, dan alasan jawaban tersebut benar...">{{ old('explanation', $question->explanation ?? '') }}</textarea>

            @error('explanation')
                <p class="question-error">{{ $message }}</p>
            @enderror
        </div>
    </section>

    {{-- PENGATURAN SOAL --}}
    <section class="question-section space-y-5">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-50 text-xl">
                ⚙️
            </div>
            <div>
                <h2 class="font-bold text-gray-800">Pengaturan Soal</h2>
                <p class="text-xs text-gray-500">Atur tingkat kesulitan dan bobot penilaian.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label class="question-label">Tingkat Kesulitan <span class="text-red-500">*</span></label>

                <select name="difficulty" required class="question-field">
                    @foreach (['easy' => 'Mudah', 'medium' => 'Sedang', 'hard' => 'Sulit'] as $value => $label)
                        <option value="{{ $value }}"
                            @selected(old('difficulty', $question->difficulty ?? 'easy') === $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                @error('difficulty')
                    <p class="question-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="question-label">Poin <span class="text-red-500">*</span></label>

                <input type="number"
                    name="points"
                    min="1"
                    max="100"
                    required
                    value="{{ old('points', $question->points ?? 10) }}"
                    class="question-field">

                @error('points')
                    <p class="question-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </section>

    {{-- TOMBOL AKSI --}}
    <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
        <a href="{{ route('teacher.questions.index') }}"
            class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-6 py-3 text-sm font-bold text-gray-600 transition hover:border-gray-300 hover:bg-gray-50">
            Batal
        </a>

        <button type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 via-sky-500 to-emerald-500 px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-500/20 transition hover:-translate-y-0.5 hover:shadow-xl">
            <span>💾</span>
            Simpan Soal
        </button>
    </div>

</div>
