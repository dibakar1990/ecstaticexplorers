<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourItinerary extends Model
{
    use HasFactory;
    
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id'); 
    } 
    
    public function hotel()
    {
        return $this->hasMany(HotelImage::class, 'tour_itinerary_id', 'id'); 
    } 
}
