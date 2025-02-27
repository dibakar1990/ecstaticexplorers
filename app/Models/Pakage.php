<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pakage extends Model
{
    use HasFactory;

    public function pakage_tags(): HasMany
    {
        return $this->hasMany(PakageTag::class)->with('tag');
    }

    public function pakage_itineraries(): HasMany
    {
        return $this->hasMany(PakageItinerary::class)->with('type');
    }

    public function pakage_prices(): HasMany
    {
        return $this->hasMany(PakagePrice::class)->with('type');
    }


    public function pakage_images(): HasMany
    {
        return $this->hasMany(PakageImage::class);
    }

    public function pakage_cities(): HasMany
    {
        return $this->hasMany(PakageCity::class)->with('city');
    }

    public function pakage_features(): HasMany
    {
        return $this->hasMany(PakageFeature::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function pakage_do(): HasMany
    {
        return $this->hasMany(PakageDo::class);
    }

    public function pakage_dont(): HasMany
    {
        return $this->hasMany(PakageDont::class);
    }

    public function pakage_tour_itineraries(): HasMany
    {
        return $this->hasMany(TourItinerary::class,'package_id','id');
    }

    public function pakage_itinerary_descriptions(): HasMany
    {
        return $this->hasMany(PakageItineraryDescription::class);
    }

    public function pakage_itinerary_hotels(): HasMany
    {
        return $this->hasMany(HotelImage::class,'pakage_id','id');
    }
}
