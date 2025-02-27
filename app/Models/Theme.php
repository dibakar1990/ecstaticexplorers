<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Theme extends Model
{
    use HasFactory;

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Theme::class,'theme_id','id');
    }
    
    public function package()
    {
        return $this->hasMany(PakageTag::class, 'theme_id', 'id'); 
    }   
}
