<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $connection = 'tenant';

    protected $fillable = ['title'];

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
}
