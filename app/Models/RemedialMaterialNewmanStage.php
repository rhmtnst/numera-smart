<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RemedialMaterialNewmanStage extends Model
{
    protected $table = 'remedial_material_newman_stages';

    protected $guarded = ['id'];

    public function remedialMaterial(): BelongsTo
    {
        return $this->belongsTo(RemedialMaterial::class);
    }
}
