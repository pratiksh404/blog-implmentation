<?php

namespace App\Models\Admin;

use App\Traits\PostTrait;
use Spatie\Activitylog\LogOptions;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Cache;
use drh2so4\Thumbnail\Traits\Thumbnail;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Post extends Model
{
    use LogsActivity, PostTrait, Thumbnail;

    protected $guarded = [];

    // Forget cache on updating or saving and deleting
    public static function boot()
    {
        parent::boot();

        static::saving(function () {
            self::cacheKey();
        });

        static::deleting(function () {
            self::cacheKey();
        });
    }

    // Cache Keys
    private static function cacheKey()
    {
        Cache::has('posts') ? Cache::forget('posts') : '';
    }

    // Logs
    protected static $logName = 'post';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    // Casts
    protected $casts = [
        'meta_keywords' => 'array',
    ];

    // Appends
    protected $appends = ['video_html', 'network_image'];

    // Accessors
    public function getStatusAttribute($attribute)
    {
        return $attribute <= 3 ? [
            1 => 'Draft',
            2 => 'Pending',
            3 => 'Published',
        ][$attribute] : 'N/A';
    }

    public function getVideoHtmlAttribute()
    {
        if (isset($this->video)) {
            return preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", '<iframe width="420" height="315" src="//www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>', $this->video);
        }
    }
    public function getNetworkImageAttribute()
    {
        return isset($this->image) ? url('storage/' . $this->image) : null;
    }


    public function getImageAttribute($attribute)
    {
        if (isset($attribute)) {
            if (file_exists(public_path('storage/' . $attribute))) {
                return asset('storage/' . $attribute);
            } elseif (file_exists(public_path($attribute))) {
                return asset($attribute);
            } else {
                return getImagePlaceholder();
            }
        }
    }

    // Relation
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // Helper Function
    public function statusColor()
    {
        return $this->getRawOriginal('status') == 1 ? 'danger' : ($this->getRawOriginal('status') == 2 ? 'warning' : 'success');
    }
}
