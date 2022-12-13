<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'name',
        'address',
        'email',
        'phone',
        'driving_license',
        'photo'
    ];

    protected $hidden = ['created_at','updated_at'];
}
