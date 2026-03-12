<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAttendance extends Model
{
    protected $connection = 'tenant';

    protected $table = 'teacher_attendance';

    protected $fillable = [
        'teacher_id',
        'date',
        'status',
        'remarks',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
