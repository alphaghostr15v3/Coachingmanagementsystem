<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $connection = 'tenant';

    protected $fillable = [
        'course_id',
        'name',
        'timing',
        'teacher_id',
        'start_date',
        'end_date',
        'class_time',
        'start_time',
        'end_time',
        'capacity',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_batch');
    }
}
