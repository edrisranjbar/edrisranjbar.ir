<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'title',
        'content',
        'status',
        'thumbnail',
        'author',
    ];

    public function author()
    {
        return $this->belongsTo(Admin::class, 'author');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getLinkAttribute()
    {
        return url("/blog/{$this->slug}");
    }

    public function getExcerptAttribute($length = 100)
    {
        // Check if the content length is less than the specified length
        if (mb_strlen($this->content, 'UTF-8') <= $length) {
            return $this->content;
        }

        // If the content is longer, return a limited excerpt
        return mb_substr($this->content, 0, $length, 'UTF-8') . '...';
    }
}
