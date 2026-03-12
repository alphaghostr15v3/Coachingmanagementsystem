<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $connection = 'tenant';

    protected $fillable = ['name', 'description'];

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
}
