<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model

{
    protected $casts = [
        'duration' => 'integer',
    ];
    protected $fillable = [
        'title', 'price', 'tutor', 'description', 'status', 'thumbnail', 'duration', 'slug'
    ];

    public function tutor()
    {
        return $this->belongsTo(Admin::class, 'tutor');
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
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
}
