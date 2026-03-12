<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalarySlip extends Model
{
    protected $connection = 'tenant';

    protected $fillable = [
        'teacher_id',
        'month',
        'year',
        'basic_salary',
        'total_days',
        'per_day_pay',
        'earnings',
        'deductions',
        'net_salary',
        'payment_status',
        'payment_date',
        'remarks'
    ];

    protected $casts = [
        'earnings' => 'array',
        'deductions' => 'array',
        'payment_date' => 'date'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
