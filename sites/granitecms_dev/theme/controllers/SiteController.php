<?php

namespace Sites\granitecms_dev\theme\controllers;

use App\Http\Controllers\Controller;
use App\Setting;
use Sites\granitecms_dev\theme\Site;

class SiteController extends Controller
{

    public function __construct()
    {
        $hooks = config('hooks');
        $hooks->addHook('init_core', 10, [$this, 'initFeatures']);
    }

    public function batchGetSites($ids)
    {
        $sites = Site::whereIn('id', $ids)->get();

        return apiResponse(SUCCESS, $sites);
    }

    public function initFeatures()
    {
        $setting = Setting::where('setting_name', 'granitecms_theme_installed')->first();

        if ($setting == null) {
            Setting::create(['setting_name' => 'granitecms_theme_installed', 'setting_value' => false]);
        }

        if (setting('granitecms_theme_installed')) {

        }
    }
}
