<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TeacherAssignment extends Model
{
    protected $fillable = ['teacher_id','school_id','grade_level','class_name'];
    public function teacher(){ return $this->belongsTo(User::class,'teacher_id'); }
    public function school(){ return $this->belongsTo(School::class); }
}
