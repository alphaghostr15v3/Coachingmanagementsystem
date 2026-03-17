<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $connection = 'tenant';

    protected $fillable = [
        'course_id',
        'name',
        'email',
        'phone',
        'address',
        'state',
    ];

    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'student_batch');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
