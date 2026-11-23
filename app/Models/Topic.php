<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'grade_level' => 'integer',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function learningDomain(): BelongsTo
    {
        return $this->belongsTo(LearningDomain::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function verificationQuestions(): HasMany
    {
        return $this->hasMany(VerificationQuestion::class);
    }

    public function remedialMaterials(): HasMany
    {
        return $this->hasMany(RemedialMaterial::class);
    }

    public function learningMaterial(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(LearningMaterial::class);
    }
}