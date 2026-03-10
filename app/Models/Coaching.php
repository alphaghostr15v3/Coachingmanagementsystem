<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coaching extends Model
{
    protected $fillable = [
        'coaching_name',
        'owner_name',
        'email',
        'mobile',
        'database_name',
        'status',
        'subscription_plan',
    ];
}
