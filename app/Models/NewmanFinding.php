<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewmanFinding extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    public function answerAnalysis(): BelongsTo
    {
        return $this->belongsTo(AnswerAnalysis::class);
    }

    public function remedialRecommendations(): HasMany
    {
        return $this->hasMany(RemedialRecommendation::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
