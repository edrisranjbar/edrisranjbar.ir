<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'author',
    ];

    public function author()
    {
        return $this->belongsTo(Admin::class, 'author');
    }
}
