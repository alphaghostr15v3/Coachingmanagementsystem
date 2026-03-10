<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $connection = 'tenant';

    protected $fillable = [
        'student_id',
        'amount',
        'status',
        'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
