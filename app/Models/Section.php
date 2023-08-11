<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'tutorial_id'];

    public function tutorial()
    {
        return $this->belongsTo(Tutorial::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
