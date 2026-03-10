<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $connection = 'tenant';

    protected $fillable = [
        'title',
        'description',
    ];
}
