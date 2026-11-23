<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class RemedialAttempt extends Model
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

    public function material(): BelongsTo
    {
        return $this->belongsTo(
            RemedialMaterial::class,
            'remedial_material_id'
        );
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(
            RemedialAnswer::class,
            'remedial_attempt_id'
        );
    }

    /**
 * Rekomendasi guru yang menjadi dasar pengerjaan.
 */
public function recommendation(): BelongsTo
{
    return $this->belongsTo(
        RemedialRecommendation::class,
        'remedial_recommendation_id'
    );
}
}
