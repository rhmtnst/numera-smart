<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Topic;
use App\Support\TeacherScope;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TeacherQuestionController extends Controller
{
    private function authorizeTeacher(): void
    {
        abort_unless(
            auth()->user()->role === 'teacher',
            403,
            'Anda tidak memiliki akses ke halaman ini.'
        );
    }

    private function ownedQuestion(Question $question): Question
    {
        // Soal hasil generator (created_by null) dapat diedit guru yang
        // memang ditugaskan pada kelas/topik tersebut. Soal buatan guru lain
        // tetap dilindungi kepemilikan.
        if ($question->created_by !== null) {
            abort_unless(
                (int) $question->created_by === (int) auth()->id(),
                403,
                'Anda tidak memiliki akses ke soal ini.'
            );
        }

        return $question;
    }

    private function validateQuestion(Request $request): array
    {
        return $request->validate([
            'topic_id' => ['required', 'exists:topics,id'],
            'stimulus' => ['nullable', 'string', 'max:5000'],
            'question_text' => ['required', 'string', 'max:5000'],
            'options' => ['required', 'array', 'size:4'],
            'options.A' => ['required', 'string', 'max:1000'],
            'options.B' => ['required', 'string', 'max:1000'],
            'options.C' => ['required', 'string', 'max:1000'],
            'options.D' => ['required', 'string', 'max:1000'],
            'correct_answer' => ['required', 'in:A,B,C,D'],
            'explanation' => ['required', 'string', 'max:5000'],
            'difficulty' => ['required', 'in:easy,medium,hard'],
            'points' => ['required', 'integer', 'min:1', 'max:100'],
        ]);
    }

   public function index(): View
{
    $this->authorizeTeacher();

    // Soal bersama + soal milik guru yang sedang login
    $grades = TeacherScope::gradeLevels(auth()->user());
    $baseQuery = Question::whereHas('topic', fn ($query) => $query->whereIn('grade_level', $grades))
        ->where(fn ($query) => $query->where('created_by', auth()->id())->orWhereNull('created_by'));

    $questions = (clone $baseQuery)
        ->with('topic')
        ->latest()
        ->paginate(10);

    $totalQuestions = (clone $baseQuery)->count();

    $totalDraft = (clone $baseQuery)
        ->where('review_status', 'draft')
        ->count();

    $totalApproved = (clone $baseQuery)
        ->where('review_status', 'approved')
        ->count();

    $totalRevision = (clone $baseQuery)
        ->where('review_status', 'revision_requested')
        ->count();

    return view('teacher.questions.index', compact(
        'questions',
        'totalQuestions',
        'totalDraft',
        'totalApproved',
        'totalRevision'
    ));
}

    public function create(): View
    {
        $this->authorizeTeacher();

        $topics = TeacherScope::topicQuery(auth()->user())
            ->orderBy('grade_level')
            ->orderBy('title')
            ->get();

        return view('teacher.questions.create', compact('topics'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeTeacher();

        $data = $this->validateQuestion($request);

        $topic = TeacherScope::topicQuery(auth()->user())->findOrFail($data['topic_id']);

        DB::transaction(function () use ($data, $topic) {
            $question = Question::create([
                'topic_id' => $topic->id,
                'created_by' => auth()->id(),
                'question_text' => $data['question_text'],
                'stimulus' => $data['stimulus'] ?? null,
                'question_type' => 'multiple_choice',
                'correct_answer' => $data['correct_answer'],
                'explanation' => $data['explanation'],
                'difficulty' => $data['difficulty'],
                'points' => $data['points'],
                'sort_order' => 1,
                'is_active' => true,
                'review_status' => 'draft',
                'source' => 'manual',
            ]);

            foreach ($data['options'] as $label => $text) {
                $question->options()->create([
                    'option_label' => $label,
                    'option_text' => $text,
                    'is_correct' => $label === $data['correct_answer'],
                    'sort_order' => ord($label) - ord('A') + 1,
                ]);
            }
        });

        return redirect()
            ->route('teacher.questions.index')
            ->with('success', 'Soal berhasil dibuat sebagai draft.');
    }

    public function edit(Question $question): View
    {
        $this->authorizeTeacher();
        $this->ownedQuestion($question);
        $question->loadMissing('topic');
        abort_unless(TeacherScope::allowsTopic(auth()->user(), $question->topic), 404);

        abort_unless(
            in_array($question->review_status, ['draft', 'revision_requested']),
            403,
            'Soal yang sudah disetujui tidak dapat diedit.'
        );

        $question->load('options');

        $topics = TeacherScope::topicQuery(auth()->user())
            ->orderBy('grade_level')
            ->orderBy('title')
            ->get();

        return view('teacher.questions.edit', compact('question', 'topics'));
    }

    public function update(Request $request, Question $question): RedirectResponse
    {
        $this->authorizeTeacher();
        $this->ownedQuestion($question);
        $question->loadMissing('topic');
        abort_unless(TeacherScope::allowsTopic(auth()->user(), $question->topic), 404);

        abort_unless(
            in_array($question->review_status, ['draft', 'revision_requested']),
            403,
            'Soal yang sudah disetujui tidak dapat diedit.'
        );

        $data = $this->validateQuestion($request);

        $topic = TeacherScope::topicQuery(auth()->user())->findOrFail($data['topic_id']);

        DB::transaction(function () use ($question, $data, $topic) {
            $question->update([
                'topic_id' => $topic->id,
                'question_text' => $data['question_text'],
                'stimulus' => $data['stimulus'] ?? null,
                'correct_answer' => $data['correct_answer'],
                'explanation' => $data['explanation'],
                'difficulty' => $data['difficulty'],
                'points' => $data['points'],
                'review_status' => 'draft',
                'review_notes' => null,
                'reviewed_by' => null,
                'reviewed_at' => null,
            ]);

            foreach ($data['options'] as $label => $text) {
                $question->options()->updateOrCreate(
                    ['option_label' => $label],
                    [
                        'option_text' => $text,
                        'is_correct' => $label === $data['correct_answer'],
                        'sort_order' => ord($label) - ord('A') + 1,
                    ]
                );
            }
        });

        return redirect()
            ->route('teacher.questions.index')
            ->with('success', 'Soal berhasil diperbarui dan kembali menjadi draft.');
    }

    public function submitForReview(Question $question): RedirectResponse
    {
        $this->authorizeTeacher();
        $this->ownedQuestion($question);
        $question->loadMissing('topic');
        abort_unless(TeacherScope::allowsTopic(auth()->user(), $question->topic), 404);

        abort_unless(
            in_array($question->review_status, ['draft', 'revision_requested']),
            403,
            'Status soal tidak dapat dikirim untuk review.'
        );

        $question->update([
            'review_status' => 'draft',
            'review_notes' => null,
            'reviewed_by' => null,
            'reviewed_at' => null,
        ]);

        return redirect()
            ->route('teacher.questions.index')
            ->with('success', 'Soal berhasil dikirim ke daftar pemeriksaan guru.');
    }
}
