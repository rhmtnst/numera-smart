<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentAttempt extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'score' => 'decimal:2',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(StudentAnswer::class);
    }
    public function topicReview(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(AssessmentTopicReview::class);
    }

    public function topic(): BelongsTo
    {
    return $this->belongsTo(Topic::class);
    }
}
