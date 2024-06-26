<?php

namespace App\Models;

use AndreasElia\Analytics\Models\PageView;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Leshkens\LaravelReadTime\Facades\ReadTime;

class Post extends Model
{
    use HasFactory;
    use HasSEO;

    public const blogLink = "/blog";

    protected $guarded = [];

    public function getTimeToReadAttribute(): string
    {
        $timeToRead = ReadTime::parse($this->content);
        $result = $timeToRead->number . " ";
        if ($timeToRead->unit === 'second') {
            $result .= 'ثانیه ای';
        } else {
            $result .= 'دقیقه ای';
        }
        return $result;
    }

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->title,
            description: $this->getExcerptAttribute(),
            tags: $this->tags->pluck('name')->toArray(),
            section: $this->categories?->first?->title,
            image: $this->thumbnail,
        );
    }

    public function author()
    {
        return $this->belongsTo(Admin::class, 'author_id');
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
        return $this->hasMany(Comment::class)
            ->where(['parent_id' => null])
            ->orderBy('created_at', 'desc');
    }

    public function confirmedComments()
    {
        return $this->hasMany(Comment::class)
            ->where(['parent_id' => null])
            ->where(['confirmed' => 1])
            ->orderBy('created_at', 'desc');
    }

    public function getLinkAttribute()
    {
        return url(self::blogLink . "/{$this->slug}");
    }

    public function getViewsAttribute()
    {
        return PageView::query()->where(['uri' => self::blogLink . "/{$this->slug}"])->count();
    }

    public function getViewersAttribute()
    {
        return PageView::query()
            ->where(['uri' => self::blogLink . "/{$this->slug}"])
            ->groupBy('session')
            ->pluck('session')
            ->count();
    }

    public function getTagNamesAsArrayAttribute()
    {
        return implode(',', $this->tags->pluck('name')->toArray());
    }

    public function getExcerptAttribute($length = 100)
    {
        if (!isset($length)) $length = 100;
        $contentWithoutEntities = strip_tags($this->content);
        // Check if the content length is less than the specified length
        if (mb_strlen($contentWithoutEntities, 'UTF-8') <= $length) {
            return $contentWithoutEntities;
        }
        // If the content is longer, return a limited excerpt
        return mb_substr($contentWithoutEntities, 0, $length, 'UTF-8') . '...';
    }

    public function getStatusStringAttribute()
    {
        return match ($this->status) {
            'published' => 'منتشر شده',
            'draft' => 'پیش نویس',
            'private' => 'خصوصی',
            default => 'وضعیت نامعلوم',
        };
    }
}
