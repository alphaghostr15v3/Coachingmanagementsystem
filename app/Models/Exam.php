<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $connection = 'tenant';

    protected $fillable = [
        'course_id',
        'batch_id',
        'name',
        'date',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
