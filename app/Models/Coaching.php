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
        'state',
        'gst_number',
        'database_name',
        'status',
        'subscription_plan',
    ];
}
