<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Topic;
use App\Support\TeacherScope;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuestionReviewController extends Controller
{
    private function pendingStatuses(): array
    {
        return ['draft', 'revision_requested'];
    }

    private function authorizeReview(Question $question): void
    {
        $question->loadMissing('topic');

        abort_unless(
            $question->topic &&
            TeacherScope::allowsTopic(
                auth()->user(),
                $question->topic
            ),
            404
        );
    }

    /**
     * Halaman utama: daftar topik berdasarkan kelas.
     */
    public function index(): View
    {
        $grades = TeacherScope::gradeLevels(auth()->user());
        $statuses = $this->pendingStatuses();

        $base = Question::query()->whereHas(
            'topic',
            fn ($query) => $query->whereIn('grade_level', $grades)
        );

        $topics = TeacherScope::topicQuery(auth()->user())
            ->withCount([
                'questions as pending_questions_count' =>
                    fn ($query) => $query->whereIn(
                        'review_status',
                        $statuses
                    )
            ])
            ->orderBy('grade_level')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        $groupedTopics = $topics->groupBy('grade_level');

        $totalDraft = (clone $base)
            ->whereIn('review_status', $statuses)
            ->count();

        $totalApproved = (clone $base)
            ->where('review_status', 'approved')
            ->count();

        $totalRevision = (clone $base)
            ->where('review_status', 'revision_requested')
            ->count();

        return view('teacher.review.index', compact(
            'groupedTopics',
            'totalDraft',
            'totalApproved',
            'totalRevision'
        ));
    }

    /**
     * Halaman khusus seluruh soal dalam satu topik.
     */
    public function topic(Topic $topic): View
    {
        $teacher = auth()->user();

        $authorizedTopic = TeacherScope::topicQuery($teacher)
            ->whereKey($topic->id)
            ->firstOrFail();

        $questions = $authorizedTopic->questions()
            ->whereIn(
                'review_status',
                $this->pendingStatuses()
            )
            ->with('options')
            ->orderBy('created_at')
            ->orderBy('id')
            ->get();

        return view('teacher.review.topic', [
            'topic' => $authorizedTopic,
            'questions' => $questions,
        ]);
    }

    /**
     * Detail pemeriksaan satu soal.
     */
    public function show(Question $question): View
    {
        $this->authorizeReview($question);

        $question->load([
            'topic',
            'options'
        ]);

        return view(
            'teacher.review.show',
            compact('question')
        );
    }

    /**
     * Menyetujui soal.
     */
    public function approve(Question $question): RedirectResponse
    {
        $this->authorizeReview($question);

        abort_unless(
            in_array(
                $question->review_status,
                $this->pendingStatuses(),
                true
            ),
            403,
            'Status soal tidak dapat ditinjau.'
        );

        $topicId = $question->topic_id;

        $question->update([
            'review_status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'review_notes' => null,
        ]);

        return redirect()
            ->route('teacher.review.topic', $topicId)
            ->with(
                'success',
                'Soal berhasil disetujui dan tersedia untuk asesmen siswa.'
            );
    }

    /**
     * Meminta revisi soal.
     */
    public function requestRevision(
        Request $request,
        Question $question
    ): RedirectResponse {
        $this->authorizeReview($question);

        abort_unless(
            in_array(
                $question->review_status,
                $this->pendingStatuses(),
                true
            ),
            403,
            'Status soal tidak dapat ditinjau.'
        );

        $validated = $request->validate([
            'review_notes' => [
                'required',
                'string',
                'min:10',
                'max:2000'
            ]
        ]);

        $topicId = $question->topic_id;

        $question->update([
            'review_status' => 'revision_requested',
            'review_notes' => $validated['review_notes'],
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()
            ->route('teacher.review.topic', $topicId)
            ->with(
                'success',
                'Permintaan revisi berhasil disimpan.'
            );
    }
}
