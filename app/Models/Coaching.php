<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coaching extends Model
{
    protected $connection = 'mysql';

    protected $fillable = [
        'coaching_name',
        'address',
        'owner_name',
        'email',
        'mobile',
        'state',
        'gst_number',
        'database_name',
        'status',
        'subscription_plan',
        'authorized_signatory',
        'signatory_image',
        'profile_image',
    ];
}
