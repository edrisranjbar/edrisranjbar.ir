<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Tutorial extends Model

{
    protected $casts = [
        'duration' => 'integer',
    ];
    protected $fillable = [
        'title',
        'price',
        'tutor',
        'description',
        'short_description',
        'status',
        'thumbnail',
        'duration',
        'slug'
    ];

    public function tutor()
    {
        return $this->belongsTo(Admin::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'user_tutorial');
    }


    public function getStatusLabelAttribute()
    {
        $visibilityLabels = [
            'public' => 'عمومی',
            'private' => 'خصوصی',
            'draft' => 'پیش‌نویس',
        ];

        return $visibilityLabels[$this->status];
    }

    public function getLinkAttribute()
    {
        return url("/tutorials/{$this->slug}");
    }

    public function getExcerptAttribute($limit = 10)
    {
        return Str::limit($this->description, $limit);
    }
}
