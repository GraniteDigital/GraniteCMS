<?php

namespace Sites\granitecms_dev\theme;

use App\Scopes\SiteScope;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = "granitecms_dev_tags";

    protected $fillable = [
        'tag',
        'postings',
    ];

    protected $hidden = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SiteScope);
    }

    public function scopeGetFromTags($query, $tags)
    {
        if (!is_array($tags)) {
            $tags = explode(',', $tags);
        }

        foreach ($tags as $tag) {
            $query->orWhere('tag', $tag);
        }

        return $query;
    }

    public function site()
    {
        return $this->belongsTo('App\Site', 'site');
    }
}
