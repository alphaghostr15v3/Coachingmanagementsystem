<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $connection = 'tenant';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
    ];

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function attendances()
    {
        return $this->hasMany(TeacherAttendance::class);
    }

    public function salarySlips()
    {
        return $this->hasMany(SalarySlip::class);
    }
}
