<?php

namespace App\Http\Controllers;

use App\Models\NewmanFinding;
use App\Models\RemedialMaterial;
use App\Models\RemedialRecommendation;
use App\Support\TeacherScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherRemedialRecommendationController extends Controller
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
     * Menyimpan rekomendasi remediasi berdasarkan temuan Newman.
     */
    public function store(Request $request, NewmanFinding $finding)
    {
        $this->authorizeTeacher();

        $validated = $request->validate([
            'remedial_material_id' => [
                'required',
                'integer',
                'exists:remedial_materials,id',
            ],
            'reason' => [
                'required',
                'string',
                'min:10',
                'max:3000',
            ],
        ], [
            'remedial_material_id.required' => 'Pilih materi remediasi.',
            'remedial_material_id.exists' => 'Materi remediasi tidak ditemukan.',
            'reason.required' => 'Alasan rekomendasi wajib diisi.',
            'reason.min' => 'Alasan rekomendasi minimal 10 karakter.',
        ]);

        // Muat hubungan temuan dengan asesmen siswa.
        $finding->load([
            'answerAnalysis.studentAnswer.assessmentAttempt',
        ]);

        $analysis = $finding->answerAnalysis;
        $attempt = $analysis?->studentAnswer?->assessmentAttempt;
        if ($attempt) { abort_unless(TeacherScope::allowsStudent(auth()->user(), $attempt->student), 404); }

        // Asesmen harus benar-benar sudah selesai.
        abort_unless(
            $analysis &&
            $attempt &&
            $attempt->status === 'completed' &&
            $attempt->completed_at !== null,
            404,
            'Asesmen siswa belum selesai.'
        );

        // Semua jawaban harus selesai dianalisis dan guru mengonfirmasi diagnosis topik satu kali.
        $topicReview = $attempt->topicReview()->first();
        abort_unless(
            $analysis->analysis_status === 'completed' &&
            $analysis->reviewed_at !== null &&
            $analysis->review_decision === 'confirmed' &&
            $topicReview &&
            $topicReview->decision === 'confirmed' &&
            $topicReview->reviewed_at !== null,
            403,
            'Diagnosis Newman untuk topik ini harus dikonfirmasi guru terlebih dahulu.'
        );

        // Temuan harus menunjukkan indikasi kesalahan.
        abort_unless(
            $finding->finding_status === 'error_indicated',
            403,
            'Temuan ini belum memenuhi syarat rekomendasi remediasi.'
        );

        // Rekomendasi hanya boleh dibuat setelah temuan tahap Newman ini
        // diperiksa dan dikonfirmasi secara eksplisit oleh guru.
        abort_unless(
            $finding->reviewed_at !== null &&
            $finding->teacher_decision === 'confirmed',
            403,
            'Temuan pada tahap Newman ini harus dikonfirmasi guru terlebih dahulu.'
        );

        // Ambil materi beserta topik, domain, dan tahap Newman.
        $material = RemedialMaterial::with([
            'newmanStages',
            'topic.learningDomain',
        ])->findOrFail($validated['remedial_material_id']);

        // Materi yang telah dipublikasikan dapat digunakan oleh guru lain
        // selama topiknya berada dalam cakupan penugasan guru tersebut.
        // Hak mengedit/menghapus materi tetap diatur oleh controller materi.

        abort_unless(
            $material->topic &&
            TeacherScope::allowsTopic(auth()->user(), $material->topic),
            404
        );

        // Materi harus sudah dipublikasikan.
        abort_unless(
            $material->status === 'published',
            422,
            'Materi remediasi belum dipublikasikan.'
        );

        // Topik materi harus sesuai dengan topik asesmen.
        abort_unless(
            (int) $material->topic_id === (int) $attempt->topic_id,
            422,
            'Materi remediasi harus sesuai dengan topik asesmen siswa.'
        );

        // Topik dan domain pembelajaran harus aktif.
        abort_unless(
            $material->topic &&
            $material->topic->is_active &&
            $material->topic->learningDomain &&
            $material->topic->learningDomain->is_active,
            422,
            'Topik atau domain pembelajaran sudah tidak aktif.'
        );

        // Materi harus memiliki minimal satu latihan aktif.
        abort_unless(
            $material->exercises()
                ->where('is_active', true)
                ->exists(),
            422,
            'Materi belum memiliki latihan aktif.'
        );

        // Tahap Newman materi harus cocok dengan temuan.
        abort_unless(
            $material->newmanStages->contains(
                'stage',
                $finding->stage
            ),
            422,
            'Materi tidak sesuai dengan tahap Newman pada temuan ini.'
        );

        // Simpan rekomendasi dalam transaksi.
        $recommendation = DB::transaction(function () use (
            $finding,
            $material,
            $validated
        ) {
            return RemedialRecommendation::firstOrCreate(
                [
                    'newman_finding_id' => $finding->id,
                    'remedial_material_id' => $material->id,
                ],
                [
                    'recommended_by' => auth()->id(),
                    'reason' => $validated['reason'],
                    'status' => 'pending',
                    'recommended_at' => now(),
                ]
            );
        });

        if (!$recommendation->wasRecentlyCreated) {
            return back()->with(
                'error',
                'Materi tersebut sudah direkomendasikan untuk temuan ini.'
            );
        }

        return redirect()
            ->route('teacher.analyses.show', $attempt->id)
            ->with(
                'success',
                'Rekomendasi remediasi berhasil diberikan kepada siswa.'
            );
    }
}
