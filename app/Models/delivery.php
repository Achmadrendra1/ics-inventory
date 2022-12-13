<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class delivery extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_delivery_order',
        'no_invoice',
        'user_id',
        'driver_id',
        'car_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
