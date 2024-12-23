<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'countries', 'cities'];

    protected $casts = [
        'countries' => 'array',
        'cities' => 'array'
    ];

    public function rates()
    {
        return $this->hasMany(ZoneShippingRate::class);
    }
}
