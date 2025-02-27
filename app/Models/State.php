<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    public function filePathUrl(): Attribute
    {
        return new Attribute(
            get: fn () => $this->file_path ? asset('storage/'.$this->file_path) : null
        );
    }

    public function trendingFilePathUrl(): Attribute
    {
        return new Attribute(
            get: fn () => $this->trending_image ? asset('storage/'.$this->trending_image) : null
        );
    }
}
