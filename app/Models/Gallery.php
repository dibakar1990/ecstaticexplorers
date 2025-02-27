<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gallery extends Model
{
    use HasFactory;

    public function gallery_images(): HasMany
    {
        return $this->hasMany(GalleryImage::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
