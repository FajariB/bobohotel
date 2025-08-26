<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelBooking extends Model
{
        use HasFactory, SoftDeletes;

        protected $fillable = [
            'user_id',
            'hotel_id',
            'room_id',
            'checkin_at',
            'checkout_at',
            'total_amount',
            'total_days',
            'is_paid',
            'proof'
        ];

        public function customer(){
            return $this->belongsTo(User::class);
        }

        public function hotel(){
            return $this->belongsTo(Hotel::class);
        }

        public function room(){
            return $this->belongsTo(HotelRoom::class, 'room_id');
        }
}
