<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function filePathUrl(): Attribute
    {
        return new Attribute(
            get: fn () => $this->file_path ? asset('storage/'.$this->file_path) : null
        );
    } 
    
    public function topDestinationFilePathUrl(): Attribute
    {
        return new Attribute(
            get: fn () => $this->top_destination_file_path ? asset('storage/'.$this->top_destination_file_path) : null
        );
    } 

    public function package()
    {
        return $this->hasMany(PakageCity::class, 'city_id', 'id'); 
    }   
} 
