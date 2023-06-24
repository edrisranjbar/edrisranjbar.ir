<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    protected $fillable = [
        'name', 'price', 'tutor', 'description', 'status', 'thumbnail'
    ];
}
