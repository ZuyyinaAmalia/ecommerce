<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'qty',
        'subtotal',
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

}
