<?php

namespace App\Http\Controllers;

use App\Models\RemedialMaterial;
use App\Models\Topic;
use App\Support\TeacherScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TeacherRemedialMaterialController extends Controller
{
    /**
     * Daftar tahapan Newman.
     */
    private const NEWMAN_STAGES = [
        'reading',
        'comprehension',
        'transformation',
        'process_skills',
        'encoding',
    ];

    private function authorizeTeacher(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->role === 'teacher',
            403,
            'Halaman ini hanya dapat diakses guru.'
        );
    }

    private function authorizeMaterial(RemedialMaterial $remedial): void
    {
        $remedial->loadMissing('topic');
        if ($remedial->created_by !== null) {
            abort_unless(
                (int) $remedial->created_by === (int) auth()->id(),
                403,
                'Hanya pembuat materi yang dapat mengubahnya.'
            );
        }
        abort_unless($remedial->topic && TeacherScope::allowsTopic(auth()->user(), $remedial->topic), 404);
    }

    /**
     * Materi yang sudah dipakai dalam rekomendasi atau pengerjaan siswa
     * diperlakukan sebagai arsip agar riwayat tidak berubah makna.
     */
    private function hasLearningHistory(RemedialMaterial $remedial): bool
    {
        return $remedial->recommendations()->exists()
            || $remedial->attempts()->exists();
    }

    /**
     * Menampilkan daftar materi remediasi.
     */
    public function index()
    {
        $this->authorizeTeacher();

        $grades = TeacherScope::gradeLevels(auth()->user());
        $materials = RemedialMaterial::whereHas('topic', fn ($query) => $query->whereIn('grade_level', $grades))->with([
            'topic',
            'creator',
            'newmanStages',
        ])
            ->withCount('exercises')
            ->latest()
            ->paginate(10);

        return view('teacher.remedials.index', compact('materials'));
    }

    /**
     * Menampilkan formulir pembuatan materi.
     */
    public function create()
    {
        $this->authorizeTeacher();

        $topics = TeacherScope::topicQuery(auth()->user())
            ->orderBy('grade_level')
            ->orderBy('sort_order')
            ->get();

        return view('teacher.remedials.create', compact('topics'));
    }

    /**
     * Menyimpan materi baru.
     */
    public function store(Request $request)
    {
        $this->authorizeTeacher();

        $validated = $request->validate([
            'topic_id' => ['required', 'exists:topics,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'example_content' => ['nullable', 'string'],

            'newman_stages' => ['required', 'array', 'min:1'],
            'newman_stages.*' => [
                'required',
                'string',
                'distinct',
                Rule::in(self::NEWMAN_STAGES),
            ],
        ], [
            'topic_id.required' => 'Topik numerasi wajib dipilih.',
            'topic_id.exists' => 'Topik yang dipilih tidak tersedia.',
            'title.required' => 'Judul materi wajib diisi.',
            'content.required' => 'Isi materi wajib diisi.',
            'newman_stages.required' => 'Pilih minimal satu tahapan Newman.',
            'newman_stages.min' => 'Pilih minimal satu tahapan Newman.',
            'newman_stages.*.distinct' => 'Tahapan Newman tidak boleh dipilih dua kali.',
            'newman_stages.*.in' => 'Tahapan Newman yang dipilih tidak valid.',
        ]);

        $topic = TeacherScope::topicQuery(auth()->user())->findOrFail($validated['topic_id']);

        DB::transaction(function () use ($validated, $topic) {

            $material = RemedialMaterial::create([
                'topic_id' => $topic->id,
                'created_by' => auth()->id(),
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'content' => $validated['content'],
                'example_content' => $validated['example_content'] ?? null,
                'status' => 'draft',
            ]);

            $material->newmanStages()->createMany(
                collect($validated['newman_stages'])
                    ->map(fn ($stage) => ['stage' => $stage])
                    ->all()
            );
        });

        return redirect()
            ->route('teacher.remedials.index')
            ->with('success', 'Materi remediasi berhasil dibuat sebagai draft.');
    }

    /**
     * Menampilkan formulir edit materi.
     */
    public function edit(RemedialMaterial $remedial)
    {
        $this->authorizeTeacher();
        $this->authorizeMaterial($remedial);

        if ($this->hasLearningHistory($remedial)) {
            return redirect()->route('teacher.remedials.index')->with(
                'error',
                'Materi tidak dapat diubah karena sudah memiliki riwayat rekomendasi atau pengerjaan siswa. Buat materi baru untuk revisi.'
            );
        }

        $topics = TeacherScope::topicQuery(auth()->user())
            ->orderBy('grade_level')
            ->orderBy('sort_order')
            ->get();

        $remedial->load('newmanStages');

        return view('teacher.remedials.edit', [
            'material' => $remedial,
            'topics' => $topics,
        ]);
    }

    /**
     * Memperbarui materi.
     */
    public function update(Request $request, RemedialMaterial $remedial)
    {
        $this->authorizeTeacher();
        $this->authorizeMaterial($remedial);

        if ($this->hasLearningHistory($remedial)) {
            return back()->with(
                'error',
                'Materi tidak dapat diubah karena sudah memiliki riwayat rekomendasi atau pengerjaan siswa. Buat materi baru untuk revisi.'
            );
        }

        $validated = $request->validate([
            'topic_id' => ['required', 'exists:topics,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'content' => ['required', 'string'],
            'example_content' => ['nullable', 'string'],

            'newman_stages' => ['required', 'array', 'min:1'],
            'newman_stages.*' => [
                'required',
                'string',
                'distinct',
                Rule::in(self::NEWMAN_STAGES),
            ],
        ], [
            'newman_stages.required' => 'Pilih minimal satu tahapan Newman.',
            'newman_stages.min' => 'Pilih minimal satu tahapan Newman.',
            'newman_stages.*.distinct' => 'Tahapan Newman tidak boleh dipilih dua kali.',
            'newman_stages.*.in' => 'Tahapan Newman yang dipilih tidak valid.',
        ]);

        $topic = TeacherScope::topicQuery(auth()->user())->findOrFail($validated['topic_id']);

        DB::transaction(function () use ($validated, $topic, $remedial) {

            $remedial->update([
                'topic_id' => $topic->id,
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'content' => $validated['content'],
                'example_content' => $validated['example_content'] ?? null,
            ]);

            $remedial->newmanStages()->delete();

            $remedial->newmanStages()->createMany(
                collect($validated['newman_stages'])
                    ->map(fn ($stage) => ['stage' => $stage])
                    ->all()
            );
        });

        return redirect()
            ->route('teacher.remedials.index')
            ->with('success', 'Materi remediasi berhasil diperbarui.');
    }

    /**
     * Mengubah status publikasi materi.
     */
    public function togglePublish(RemedialMaterial $remedial)
    {
        $this->authorizeTeacher();
        $this->authorizeMaterial($remedial);

        if ($remedial->status === 'published') {
            $hasActiveRecommendation = $remedial->recommendations()
                ->whereIn('status', ['pending', 'in_progress'])
                ->exists();
            $hasActiveAttempt = $remedial->attempts()
                ->where('status', 'in_progress')
                ->exists();

            if ($hasActiveRecommendation || $hasActiveAttempt) {
                return back()->with(
                    'error',
                    'Materi tidak dapat ditarik dari publikasi karena masih digunakan dalam rekomendasi atau latihan siswa yang belum selesai.'
                );
            }

            $remedial->update([
                'status' => 'draft',
                'published_at' => null,
            ]);

            $message = 'Materi berhasil ditarik dari publikasi.';
        } else {
            if ($remedial->exercises()->where('is_active', true)->count() === 0) {
                return back()->with(
                    'error',
                    'Tambahkan minimal satu soal latihan aktif sebelum memublikasikan materi.'
                );
            }

            if (!$remedial->newmanStages()->exists()) {
                return back()->with(
                    'error',
                    'Pilih minimal satu tahapan Newman sebelum memublikasikan materi.'
                );
            }

            $remedial->update([
                'status' => 'published',
                'published_at' => now(),
            ]);

            $message = 'Materi berhasil dipublikasikan.';
        }

        return back()->with('success', $message);
    }

    /**
     * Menghapus materi.
     */
    public function destroy(RemedialMaterial $remedial)
    {
        $this->authorizeTeacher();
        $this->authorizeMaterial($remedial);

        if ($this->hasLearningHistory($remedial)) {
            return back()->with(
                'error',
                'Materi tidak dapat dihapus karena sudah memiliki riwayat rekomendasi atau pengerjaan siswa.'
            );
        }

        $remedial->delete();

        return redirect()
            ->route('teacher.remedials.index')
            ->with('success', 'Materi remediasi berhasil dihapus.');
    }
}
