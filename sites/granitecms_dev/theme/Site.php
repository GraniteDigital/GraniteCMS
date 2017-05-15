<?php

namespace Sites\granitecms_dev\theme;

use App\Scopes\SiteScope;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $table = "granitecms_dev_sites";

    protected $fillable = [
        'name',
        'tags_id',
        'developers',
        'project_managers',
        'image',
        'url',
        'site',
        'created_at',
    ];

    protected $hidden = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SiteScope);
    }

    public function tags()
    {
        return $this->belongsTo('Sites\granitecms_dev\theme\Tag', 'tags_id');
    }

    public function site()
    {
        return $this->belongsTo('App\Site', 'site');
    }
}
