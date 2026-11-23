<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RemedialExercise extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'options' => 'array',
            'is_active' => 'boolean',
            'points' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(
            RemedialMaterial::class,
            'remedial_material_id'
        );
    }

    public function answers(): HasMany
    {
        return $this->hasMany(
            RemedialAnswer::class,
            'remedial_exercise_id'
        );
    }
}
