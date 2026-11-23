<?php

namespace App\Support;

use App\Models\AssessmentAttempt;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class TeacherScope
{
    public static function assignments(User $teacher)
    {
        return $teacher->teacherAssignments()->get();
    }

    public static function gradeLevels(User $teacher): array
    {
        return self::assignments($teacher)->pluck('grade_level')->unique()->map(fn ($v) => (int) $v)->values()->all();
    }

    public static function studentQuery(User $teacher): Builder
    {
        $assignments = self::assignments($teacher);
        if ($assignments->isEmpty()) {
            return User::query()->whereRaw('1 = 0');
        }

        return User::query()->where('role', 'student')->where(function (Builder $query) use ($assignments) {
            foreach ($assignments as $assignment) {
                $query->orWhere(function (Builder $part) use ($assignment) {
                    $part->where('school_id', $assignment->school_id)
                        ->whereHas('studentProfile', fn (Builder $profile) => $profile->where('grade_level', $assignment->grade_level));
                });
            }
        });
    }

    public static function attemptQuery(User $teacher): Builder
    {
        $studentIds = self::studentQuery($teacher)->select('id');
        return AssessmentAttempt::query()->whereIn('student_id', $studentIds);
    }

    public static function allowsStudent(User $teacher, User $student): bool
    {
        return self::studentQuery($teacher)->whereKey($student->id)->exists();
    }

    public static function allowsTopic(User $teacher, Topic $topic): bool
    {
        return in_array((int) $topic->grade_level, self::gradeLevels($teacher), true);
    }

    public static function topicQuery(User $teacher): Builder
    {
        $grades = self::gradeLevels($teacher);
        return Topic::query()->whereIn('grade_level', $grades)->where('is_active', true);
    }
}
