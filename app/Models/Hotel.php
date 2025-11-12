<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory, SoftDeletes;
    //fungsi fillable biar bisa diisi pake mass assignment pada model eloquent
    protected $fillable = [ 
        'name', //ini diisi user ketika create city
        'slug', //ini diisi otomatis pake observer
        'address',
        'thumbnail',
        'link_gmaps',
        'city_id',
        'country_id',
        'star_rating', //1-5
    ];

    public function country(){
        return $this->belongsTo(Country::class); //1 hotel hanya punya 1 country
    }

    public function city(){
        return $this->belongsTo(City::class); //1 hotel hanya punya 1 city
    }

    public function photos(){
        return $this->hasMany(HotelPhoto::class); //1 hotel bisa punya banyak photo
    }

    public function rooms(){
        return $this->hasMany(HotelRoom::class); //1 hotel bisa punya banyak room
    }

    public function getLowesRoomPrice(){
        //fungsi ini buat nampilin harga room termurah di hotel
        //jadi misal di blade mau nampilin harga termurah, tinggal panggil aja $hotel->lowes_room_price
        $minPrice = $this->rooms()->min('price'); //ambil harga minimum dari kolom price di tabel hotel_rooms
        return $minPrice ?? 0; //kalo gaada room, return 0
    }  
}
