<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public function filePathUrl(): Attribute
    {
        return new Attribute(
            get: fn () => $this->file_path ? asset('storage/'.$this->file_path) : null
        );
    }

    public function filePathFavUrl(): Attribute
    {
        return new Attribute(
            get: fn () => $this->file_path_fav_icon ? asset('storage/'.$this->file_path_fav_icon) : null
        );
    }
}
