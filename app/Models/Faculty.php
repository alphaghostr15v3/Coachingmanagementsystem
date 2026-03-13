<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $connection = 'tenant';
    
    protected $table = 'faculties';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'department_id',
        'designation_id',
        'qualification',
        'experience',
        'joining_date',
        'status',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function attendances()
    {
        return $this->hasMany(FacultyAttendance::class);
    }
}
