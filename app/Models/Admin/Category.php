<?php

namespace App\Models\Admin;

use App\Models\Admin\Post;
use App\Models\Admin\Property;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Cache;
use drh2so4\Thumbnail\Traits\Thumbnail;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    use LogsActivity, Thumbnail;

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

        Category::creating(function ($model) {
            $model->position = Category::max('position') + 1;
        });
    }

    // Cache Keys
    private static function cacheKey()
    {
        Cache::has('categories') ? Cache::forget('categories') : '';
    }

    // Logs
    protected static $logName = 'category';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    protected $parentColumn = 'parent_id';


    protected $casts = [
        'meta_keywords' => 'array'
    ];


    public function parent()
    {
        return $this->belongsTo(Category::class, $this->parentColumn);
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('categories');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    // Scopes

    public function scopePositionCategory($query, $limit = 4)
    {
        return $query->with('children')->orderBy('position', 'desc')->take($limit);
    }
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
