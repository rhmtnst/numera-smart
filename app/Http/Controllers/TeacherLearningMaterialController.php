<?php

namespace App\Http\Controllers;

use App\Models\LearningMaterial;
use App\Models\Topic;
use App\Support\TeacherScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherLearningMaterialController extends Controller
{
    public function index()
    {
        $materials = LearningMaterial::query()
            ->whereHas('topic', fn ($query) => $query->whereIn('grade_level', TeacherScope::gradeLevels(auth()->user())))
            ->with('topic.learningDomain')->latest()->paginate(15);
        return view('teacher.learning-materials.index', compact('materials'));
    }

    public function create()
    {
        $topics = TeacherScope::topicQuery(auth()->user())->with('learningDomain')->orderBy('grade_level')->orderBy('sort_order')->get();
        return view('teacher.learning-materials.form', ['material' => new LearningMaterial(), 'topics' => $topics, 'editing' => false]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $topic = TeacherScope::topicQuery(auth()->user())->findOrFail($data['topic_id']);
        $material = DB::transaction(function () use ($data, $topic) {
            return LearningMaterial::updateOrCreate(['topic_id' => $topic->id], [
                'created_by' => auth()->id(), 'title' => $data['title'], 'competency' => $data['competency'] ?? null, 'objectives' => $data['objectives'] ?? [],
                'content' => $data['content'], 'example_content' => $data['example_content'] ?? null,
                'practice_prompt' => $data['practice_prompt'] ?? null, 'estimated_minutes' => $data['estimated_minutes'] ?? 15,
                'status' => 'draft', 'published_at' => null,
            ]);
        });
        return redirect()->route('teacher.learning-materials.edit', $material)->with('success', 'Materi tersimpan sebagai draft. Tinjau lalu publikasikan.');
    }

    public function edit(LearningMaterial $material)
    {
        $this->authorizeMaterial($material);
        $topics = TeacherScope::topicQuery(auth()->user())->with('learningDomain')->orderBy('grade_level')->orderBy('sort_order')->get();
        return view('teacher.learning-materials.form', ['material' => $material, 'topics' => $topics, 'editing' => true]);
    }

    public function update(Request $request, LearningMaterial $material)
    {
        $this->authorizeMaterial($material);
        $data = $this->validated($request, true);
        $material->update([
            'title' => $data['title'], 'competency' => $data['competency'] ?? null, 'objectives' => $data['objectives'] ?? [], 'content' => $data['content'],
            'example_content' => $data['example_content'] ?? null, 'practice_prompt' => $data['practice_prompt'] ?? null,
            'estimated_minutes' => $data['estimated_minutes'] ?? 15, 'created_by' => auth()->id(),
            'status' => 'draft', 'published_at' => null,
        ]);
        return back()->with('success', 'Perubahan tersimpan sebagai draft. Publikasikan setelah ditinjau.');
    }

    public function publish(LearningMaterial $material)
    {
        $this->authorizeMaterial($material);
        abort_if(trim($material->content) === '', 422, 'Isi materi tidak boleh kosong.');
        abort_if(empty($material->objectives), 422, 'Tambahkan minimal satu tujuan pembelajaran.');
        $material->update(['status' => 'published', 'published_at' => now()]);
        return back()->with('success', 'Materi berhasil dipublikasikan kepada siswa.');
    }

    private function authorizeMaterial(LearningMaterial $material): void
    {
        $material->loadMissing('topic');
        abort_unless($material->topic && TeacherScope::allowsTopic(auth()->user(), $material->topic), 404);
    }

    private function validated(Request $request, bool $updating = false): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'competency' => ['required', 'string', 'min:20', 'max:2000'],
            'objectives' => ['required', 'array', 'min:1', 'max:8'],
            'objectives.*' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string', 'min:50', 'max:30000'],
            'example_content' => ['nullable', 'string', 'max:12000'],
            'practice_prompt' => ['nullable', 'string', 'max:5000'],
            'estimated_minutes' => ['required', 'integer', 'min:5', 'max:90'],
        ];
        if (!$updating) $rules['topic_id'] = ['required', 'integer', 'exists:topics,id'];
        return $request->validate($rules);
    }
}
