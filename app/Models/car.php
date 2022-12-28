<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class car extends Model
{
    use HasFactory;
    protected $fillable = [
        'brand',
        'license_plate',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
