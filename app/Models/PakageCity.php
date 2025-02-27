<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PakageCity extends Model
{
    use HasFactory;

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class,'city_id','id');
    }
    
    public function package(): BelongsTo
    {
        return $this->belongsTo(Pakage::class, 'pakage_id', 'id');
    }  
}
