<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerificationResponse extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'asked_at' => 'datetime',
            'answered_at' => 'datetime',
        ];
    }

    public function answerAnalysis(): BelongsTo
    {
        return $this->belongsTo(AnswerAnalysis::class);
    }

    public function verificationQuestion(): BelongsTo
    {
        return $this->belongsTo(VerificationQuestion::class);
    }
}