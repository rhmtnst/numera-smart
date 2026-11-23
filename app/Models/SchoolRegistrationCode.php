<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SchoolRegistrationCode extends Model
{
    protected $fillable = ['school_id','code','max_uses','uses','expires_at','is_active','created_by'];
    protected function casts(): array { return ['expires_at'=>'datetime','is_active'=>'boolean']; }
    public function school(){ return $this->belongsTo(School::class); }
    public function isUsable(): bool { return $this->is_active && (!$this->expires_at || $this->expires_at->isFuture()) && ($this->max_uses === null || $this->uses < $this->max_uses); }
}
