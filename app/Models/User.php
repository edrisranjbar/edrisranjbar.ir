<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function tutorials()
    {
        return $this->belongsToMany(Tutorial::class, 'user_tutorial');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function tutorialProgress()
    {
        return $this->hasMany(UserTutorialProgress::class);
    }

    public function getAverageTotalProgress(): int
    {
        $totalProgress = $this->tutorialProgress()->sum('progress');
        $totalTutorials = $this->tutorialProgress()->count();
        return $totalTutorials > 0 ? $totalProgress / $totalTutorials : 0;
    }

}
