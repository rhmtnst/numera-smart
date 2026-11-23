<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class Question extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
{
    return [
        'is_active' => 'boolean',
        'points' => 'integer',
        'sort_order' => 'integer',
        'reviewed_at' => 'datetime',
        'analysis_config' => 'array',
    ];
}

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function studentAnswers(): HasMany
    {
        return $this->hasMany(StudentAnswer::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function creator(): BelongsTo
    {
    return $this->belongsTo(User::class, 'created_by');
    }
}