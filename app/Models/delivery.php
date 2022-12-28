<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class delivery extends Model
{
    use HasFactory;
    protected $table = 'delivery_order';
    protected $fillable = [
        'no_delivery_order',
        'no_invoice',
        'user_id',
        'driver_id',
        'car_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function driver()
    {
        return $this->belongsTo(driver::class);
    }

    public function car()
    {
        return $this->belongsTo(car::class);
    }
}
