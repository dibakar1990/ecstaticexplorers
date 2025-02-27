<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Blog extends Model
{
    use HasFactory;

    public function filePathUrl(): Attribute
    {
        return new Attribute(
            get: fn () => $this->file_path ? asset('storage/'.$this->file_path) : null
        );
    }

    public function publishedAt(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->created_at)->format('F j, Y')
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function blog_category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class,'blog_category_id','id');
    }

    public function blog_tags(): HasMany
    {
        return $this->hasMany(BlogTag::class)->with('tag');
    }
}
