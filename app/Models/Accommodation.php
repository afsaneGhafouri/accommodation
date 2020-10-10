<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'type','room_count','bed_count','price','address','description',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }


}
