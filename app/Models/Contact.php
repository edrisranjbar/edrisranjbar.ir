<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'phone', 'subject', 'message'];

    public function getUpdatedAgoAttribute()
    {
        return Carbon::parse($this->updated_at)->locale('fa')->diffForHumans();
    }
}
