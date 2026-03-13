<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyAttendance extends Model
{
    protected $connection = 'tenant';

    protected $fillable = [
        'faculty_id',
        'date',
        'status',
        'remarks',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
