<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    protected $fillable = ['name', 'npsn', 'address', 'city', 'province', 'status'];

    public function registrationCodes(): HasMany { return $this->hasMany(SchoolRegistrationCode::class); }

    public function teacherAssignments(): HasMany { return $this->hasMany(TeacherAssignment::class); }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
