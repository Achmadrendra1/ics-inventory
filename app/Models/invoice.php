<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    use HasFactory;
    protected $table = 'invoices';

    protected $fillable = [
        'no_invoice', 
        'user_id',
        'supplier_id', 
        'customer_id', 
        'status',
        'date',
        'type'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
