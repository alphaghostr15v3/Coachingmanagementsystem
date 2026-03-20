<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $connection = 'tenant';

    protected $fillable = [
        'exam_id',
        'student_id',
        'marks_obtained',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getGradeAttribute()
    {
        $marks = $this->marks_obtained;
        if ($marks >= 90) return 'A+';
        if ($marks >= 80) return 'A';
        if ($marks >= 70) return 'B';
        if ($marks >= 60) return 'C';
        if ($marks >= 33) return 'D';
        return 'F';
    }

    public function getGradeColorAttribute()
    {
        $marks = $this->marks_obtained;
        if ($marks >= 90) return 'success';
        if ($marks >= 80) return 'primary';
        if ($marks >= 70) return 'info';
        if ($marks >= 60) return 'warning';
        if ($marks >= 33) return 'secondary';
        return 'danger';
    }
}
