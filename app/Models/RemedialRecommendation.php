<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RemedialRecommendation extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'recommended_at' => 'datetime',
        ];
    }

    public function newmanFinding(): BelongsTo
    {
        return $this->belongsTo(NewmanFinding::class);
    }

    public function remedialMaterial(): BelongsTo
    {
        return $this->belongsTo(RemedialMaterial::class);
    }

    public function recommender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recommended_by');
    }

  /**
 * Riwayat pengerjaan berdasarkan rekomendasi ini.
 */
public function remedialAttempts(): HasMany
{
    return $this->hasMany(
        RemedialAttempt::class,
        'remedial_recommendation_id'
    );
}
}
