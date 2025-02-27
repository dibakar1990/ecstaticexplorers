<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HomeStay extends Model
{
    use HasFactory;

    public function homestay_images(): HasMany
    {
        return $this->hasMany(HomeStayImage::class);
    }

    public function homestay_facilities(): HasMany
    {
        return $this->hasMany(HomeStayFacility::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
