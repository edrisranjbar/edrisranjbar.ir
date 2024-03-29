<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lesson extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo(CourseSection::class);
    }

    public function getDurationHumanReadable(): string
    {
        return CarbonInterval::seconds($this->duration)->cascade()->locale('fa')->forHumans();
    }

    public function getLinkAttribute()
    {
        return url('/tutorials/' . $this->section?->tutorial?->slug . '/lessons/' . $this->id);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')->singleFile();
    }

    public function previousLesson()
    {
        return $this->section->tutorial->lessons()
            ->where('order_id', '<', $this->order_id)
            ->orderBy('order_id', 'desc')
            ->first();
    }

    public function nextLesson()
    {
        return $this->section->tutorial->lessons()
            ->where('order_id', '>', $this->order_id)
            ->orderBy('order_id', 'asc')
            ->first();
    }

    public function getOrder()
    {
        return $this->order_id;
    }
}
