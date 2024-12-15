<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryTracking extends Model
{
    protected $fillable = [
        'order_id',
        'status',
        'status_time',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
