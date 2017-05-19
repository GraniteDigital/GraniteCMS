<?php

namespace Sites\granitecms_dev\theme;

use App\Scopes\SiteScope;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $table = "granitecms_dev_sites";

    protected $fillable = [
        'name',
        'developers',
        'project_managers',
        'image',
        'url',
        'site',
    ];

    protected $hidden = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SiteScope);
    }

    public function site()
    {
        return $this->belongsTo('App\Site', 'site');
    }
}
