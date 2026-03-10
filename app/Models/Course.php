<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $connection = 'tenant';

    protected $fillable = [
        'name',
        'description',
        'amount',
    ];

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
}
