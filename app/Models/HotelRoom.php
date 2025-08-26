<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hotel_id',
        'name',
        'price',
        'photo',
        'total_people',
    ];

    public function hotel(){
        return $this->belongsTo(Hotel::class);
    }
    
}
