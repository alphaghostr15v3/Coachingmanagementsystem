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
        'cgst_rate',
        'cgst_amount',
        'sgst_rate',
        'sgst_amount',
        'igst_rate',
        'igst_amount',
        'total_amount',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
