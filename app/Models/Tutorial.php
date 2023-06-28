<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    protected $fillable = [
        'title', 'price', 'tutor', 'description', 'status', 'thumbnail'
    ];

    public function tutor()
    {
        return $this->belongsTo(Admin::class, 'tutor');
    }
}
