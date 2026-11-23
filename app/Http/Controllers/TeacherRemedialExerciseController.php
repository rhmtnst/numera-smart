<?php

namespace App\Http\Controllers;

use App\Models\RemedialMaterial;
use App\Models\RemedialExercise;
use App\Support\TeacherScope;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeacherRemedialExerciseController extends Controller
{
    private function authorizeTeacher(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->role === 'teacher',
            403,
            'Halaman ini hanya dapat diakses guru.'
        );
    }

    /**
     * Memastikan soal termasuk dalam materi yang dipilih.
     */
    private function authorizeMaterial(RemedialMaterial $remedial): void
    {
        $remedial->loadMissing('topic');
        if ($remedial->created_by !== null) {
            abort_unless(
                (int) $remedial->created_by === (int) auth()->id(),
                403,
                'Hanya pembuat materi yang dapat mengelola latihannya.'
            );
        }
        abort_unless($remedial->topic && TeacherScope::allowsTopic(auth()->user(), $remedial->topic), 404);
    }

    private function findExercise(RemedialMaterial $remedial, int $exercise): RemedialExercise
    {
        $this->authorizeMaterial($remedial);
        return $remedial->exercises()->findOrFail($exercise);
    }

    /**
     * Menampilkan daftar soal latihan.
     */
    public function index(RemedialMaterial $remedial)
    {
        $this->authorizeTeacher();
        $this->authorizeMaterial($remedial);

        $exercises = $remedial->exercises()
            ->withCount('answers')
            ->paginate(10);

        return view('teacher.remedials.exercises.index', [
            'material' => $remedial,
            'exercises' => $exercises,
        ]);
    }

    /**
     * Menampilkan formulir tambah soal.
     */
    public function create(RemedialMaterial $remedial)
    {
        $this->authorizeTeacher();
        $this->authorizeMaterial($remedial);

        return view('teacher.remedials.exercises.create', [
            'material' => $remedial,
        ]);
    }

    /**
     * Menyimpan soal latihan baru.
     */
    public function store(Request $request, RemedialMaterial $remedial)
    {
        $this->authorizeTeacher();
        $this->authorizeMaterial($remedial);

        $validated = $this->validateExercise($request);

        $remedial->exercises()->create([
            'question_type' => $validated['question_type'],
            'question_text' => $validated['question_text'],
            'options' => $validated['question_type'] === 'multiple_choice'
                ? $validated['options']
                : null,
            'correct_answer' => $validated['correct_answer'],
            'explanation' => $validated['explanation'] ?? null,
            'points' => $validated['points'] ?? 1,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('teacher.remedials.exercises.index', $remedial)
            ->with('success', 'Soal latihan berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir edit soal.
     */
    public function edit(
        RemedialMaterial $remedial,
        int $exercise
    ) {
        $this->authorizeTeacher();

        $exercise = $this->findExercise($remedial, $exercise);

        return view('teacher.remedials.exercises.edit', [
            'material' => $remedial,
            'exercise' => $exercise,
        ]);
    }

    /**
     * Memperbarui soal latihan.
     */
    public function update(
        Request $request,
        RemedialMaterial $remedial,
        int $exercise
    ) {
        $this->authorizeTeacher();

        $exercise = $this->findExercise($remedial, $exercise);

        $validated = $this->validateExercise($request);

        if ($exercise->answers()->exists()) {
            // Soal yang sudah dikerjakan tidak boleh diubah
            // agar riwayat jawaban siswa tetap konsisten.
            return back()->with(
                'error',
                'Soal tidak dapat diubah karena sudah memiliki riwayat jawaban siswa.'
            );
        }

        $exercise->update([
            'question_type' => $validated['question_type'],
            'question_text' => $validated['question_text'],
            'options' => $validated['question_type'] === 'multiple_choice'
                ? $validated['options']
                : null,
            'correct_answer' => $validated['correct_answer'],
            'explanation' => $validated['explanation'] ?? null,
            'points' => $validated['points'] ?? 1,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('teacher.remedials.exercises.index', $remedial)
            ->with('success', 'Soal latihan berhasil diperbarui.');
    }

    /**
     * Mengaktifkan atau menonaktifkan soal.
     */
    public function toggleActive(
        RemedialMaterial $remedial,
        int $exercise
    ) {
        $this->authorizeTeacher();

        $exercise = $this->findExercise($remedial, $exercise);

        if ($exercise->answers()->exists()) {
            return back()->with(
                'error',
                'Status soal tidak dapat diubah karena sudah memiliki riwayat jawaban siswa.'
            );
        }

        $exercise->update([
            'is_active' => !$exercise->is_active,
        ]);

        return back()->with(
            'success',
            'Status soal latihan berhasil diperbarui.'
        );
    }

    /**
     * Menghapus soal latihan.
     */
    public function destroy(
        RemedialMaterial $remedial,
        int $exercise
    ) {
        $this->authorizeTeacher();

        $exercise = $this->findExercise($remedial, $exercise);

        if ($exercise->answers()->exists()) {
            return back()->with(
                'error',
                'Soal tidak dapat dihapus karena sudah memiliki riwayat jawaban siswa.'
            );
        }

        $exercise->delete();

        return redirect()
            ->route('teacher.remedials.exercises.index', $remedial)
            ->with('success', 'Soal latihan berhasil dihapus.');
    }

    /**
     * Validasi soal berdasarkan jenisnya.
     */
    private function validateExercise(Request $request): array
    {
        $rules = [
            'question_type' => [
                'required',
                Rule::in(['multiple_choice', 'short_answer']),
            ],
            'question_text' => ['required', 'string'],
            'explanation' => ['nullable', 'string'],
            'points' => ['required', 'integer', 'min:1', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];

        if ($request->input('question_type') === 'multiple_choice') {
            $rules['options'] = ['required', 'array'];
            $rules['options.A'] = ['required', 'string', 'max:255'];
            $rules['options.B'] = ['required', 'string', 'max:255'];
            $rules['options.C'] = ['required', 'string', 'max:255'];
            $rules['options.D'] = ['required', 'string', 'max:255'];

            $rules['correct_answer'] = [
                'required',
                Rule::in(['A', 'B', 'C', 'D']),
            ];
        } else {
            $rules['correct_answer'] = [
                'required',
                'string',
                'max:255',
            ];
        }

        return $request->validate($rules);
    }
}
