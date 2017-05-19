<?php

namespace Sites\granitecms_dev\theme\controllers;

use App\Http\Controllers\Controller;
use Sites\granitecms_dev\theme\Site;

class SiteController extends Controller
{
    /**
     * API: get site info from IDs
     * @param  string   $ids comma-separated list of IDs
     * @return JSON
     */
    public function batchGetSites($ids)
    {
        $ids = explode(',', $ids);
        $sites = Site::whereIn('id', $ids)->get();

        return apiResponse(SUCCESS, $sites);
    }
}
