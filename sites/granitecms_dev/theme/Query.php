<?php

namespace Sites\granitecms_dev\theme;

use App\Scopes\SiteScope;
use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $table = "granitecms_dev_queries";

    protected $fillable = [
        'query',
        'results',
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
