<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnswerAnalysis extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    public function studentAnswer(): BelongsTo
    {
        return $this->belongsTo(StudentAnswer::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function newmanFindings(): HasMany
    {
        return $this->hasMany(NewmanFinding::class);
    }

    public function verificationResponses(): HasMany
    {
        return $this->hasMany(VerificationResponse::class);
    }
}
