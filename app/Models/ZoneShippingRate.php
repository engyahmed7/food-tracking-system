<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneShippingRate extends Model
{
    use HasFactory;

    protected $fillable = ['zone_id', 'rate'];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
