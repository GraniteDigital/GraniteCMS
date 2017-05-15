<?php

namespace Sites\granitecms_dev\theme\controllers;

use App\Http\Controllers\Controller;
use Sites\granitecms_dev\theme\Site;

class SiteController extends Controller
{
    public function batchGetSites($ids)
    {
        $sites = Site::whereIn('id', $ids)->get();

        return apiResponse(SUCCESS, $sites);
    }
}
