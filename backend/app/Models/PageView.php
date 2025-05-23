<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class PageView extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_type',
        'page_id',
        'ip_address',
        'user_agent',
        'session_id',
        'country',
        'city',
        'browser',
        'os',
        'device',
        'referrer',
        'viewed_at'
    ];

    protected $casts = [
        'viewed_at' => 'datetime'
    ];

    public function viewable()
    {
        return $this->morphTo('viewable', 'page_type', 'page_id');
    }

    public static function createView($model, $request)
    {
        $pageView = new self();
        $pageView->page_type = get_class($model);
        $pageView->page_id = $model->id;
        $pageView->ip_address = $request->ip();
        $pageView->user_agent = $request->userAgent();
        $pageView->session_id = md5($request->ip() . $request->userAgent());
        $pageView->referrer = $request->header('referer');
        $pageView->viewed_at = now();
        
        // Browser, OS, and device detection could be added here
        // with additional packages if needed
        
        $pageView->save();
        
        return $pageView;
    }

    public function scopeUniqueVisitors($query)
    {
        // This works with SQLite by using the count with a subquery
        return $query->select(DB::raw('COUNT(DISTINCT ip_address) as count'));
    }

    public function scopeUniqueVisitorsCount($query)
    {
        // Get unique visitors count for SQLite
        $result = $query->select(DB::raw('COUNT(DISTINCT ip_address) as count'))->first();
        return $result ? $result->count : 0;
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('viewed_at', $date);
    }

    public function scopeForPeriod($query, $startDate, $endDate)
    {
        return $query->whereBetween('viewed_at', [$startDate, $endDate]);
    }
}
