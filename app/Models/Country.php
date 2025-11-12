<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use illuminate\Validation\Rules\Unique;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', //ini diisi user ketika create country
        'slug', //ini diisi otomatis pake observer
    ];

    public function hotels(){
        return $this->hasMany(Hotel::class);    //1 country bisa punya banyak hotel
    }

}
