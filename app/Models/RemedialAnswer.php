<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RemedialAnswer extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
            'answered_at' => 'datetime',
        ];
    }

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(
            RemedialAttempt::class,
            'remedial_attempt_id'
        );
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(
            RemedialExercise::class,
            'remedial_exercise_id'
        );
    }
}
