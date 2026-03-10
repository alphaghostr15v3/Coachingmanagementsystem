<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $connection = 'tenant';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'student_batch');
    }
}
