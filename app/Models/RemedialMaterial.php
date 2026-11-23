<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RemedialMaterial extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(RemedialExercise::class)
            ->orderBy('sort_order');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(RemedialAttempt::class);
    }

    public function recommendations(): HasMany
{
    return $this->hasMany(RemedialRecommendation::class);
}

public function newmanStages(): HasMany
{
    return $this->hasMany(
        RemedialMaterialNewmanStage::class,
        'remedial_material_id'
    );
}
}

