<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    use HasFactory;
    protected $table = 'invoices';

    protected $fillable = ['no_invoice', 'tanggal_invoice', 'supplier_id', 'customer_id', 'status'];

    protected $hidden = ['created_at', 'updated_at'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
