<?php

namespace App\Models;

use AndreasElia\Analytics\Models\PageView;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Tutorial extends Model

{
    public const tutorialsLink = '/tutorials';
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
        'poster',
        'duration',
        'slug',
        'good_for_items',
        'bad_for_items',
    ];

    public function tutor()
    {
        return $this->belongsTo(Admin::class);
    }

    public function sections()
    {
        return $this->hasMany(CourseSection::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'user_tutorial');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function lessonsCount()
    {
        return $this->lessons()->count();
    }

    public function getStatusLabelAttribute()
    {
        $visibilityLabels = [
            'published' => 'عمومی',
            'private' => 'خصوصی',
            'draft' => 'پیش‌نویس',
        ];

        return $visibilityLabels[$this->status];
    }

    public function getLinkAttribute()
    {
        return url(self::tutorialsLink . "/{$this->slug}");
    }

    public function getViewsAttribute()
    {
        return PageView::query()->where(['uri' => self::tutorialsLink . "/{$this->slug}"])->count();
    }

    public function getViewersAttribute()
    {
        return PageView::query()
            ->where(['uri' => self::tutorialsLink . "/{$this->slug}"])
            ->groupBy('session')
            ->pluck('session')
            ->count();
    }

    public function getGoodForItems(): array
    {
        return explode(',', $this->good_for_items ?? "");
    }

    public function getBadForItems(): array
    {
        return explode(',', $this->bad_for_items ?? "");
    }

    public function getExcerptAttribute($length = 100)
    {
        if (!isset($length)) $length = 100;
        $contentWithoutEntities = strip_tags($this->description);
        // Check if the content length is less than the specified length
        if (mb_strlen($contentWithoutEntities, 'UTF-8') <= $length) {
            return $contentWithoutEntities;
        }
        // If the content is longer, return a limited excerpt
        return mb_substr($contentWithoutEntities, 0, $length, 'UTF-8') . '...';
    }

    public function getTotalDurationAttribute()
    {
        return $this->lessons->sum('duration') ?? 0;
    }

    public function getTotalDurationHumanReadable()
    {
        return CarbonInterval::seconds($this->lessons->sum('duration'))->cascade()->locale('fa')->forHumans();
    }

    public function getPriceLabelAttribute()
    {
        if ($this->price === 0) {
            return "رایگان";
        } else {
            return $this->price . " تومان";
        }
    }

    public function isInWishlist()
    {
        // Get the currently authenticated user
        $user = Auth::guard('user')?->user();

        // Check if the tutorial is in the user's wishlist
        return $user?->wishlist()->where('tutorial_id', $this->id)->exists() || false;
    }

    public function enrolledUsers()
    {
        return $this->belongsToMany(User::class, 'user_tutorial_progress')
            ->withPivot('progress')
            ->withTimestamps();
    }

    public function userProgress()
    {
        return $this->hasMany(UserTutorialProgress::class);
    }

}
