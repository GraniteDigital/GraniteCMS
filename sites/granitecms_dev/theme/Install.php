<?php

namespace Sites\granitecms_dev\theme;

use App\Core\Capabilities;
use App\Http\Controllers\SiteController;
use App\MenuItem;

/**
 * /------------------------------------------------------
 * |
 * |    The Install class is loaded when the site is
 * |    first requested and performs any action
 * |    written in the install() method
 * |
 */

class Install
{
    /**
     * Installation steps to activate theme functionality
     */
    public function install()
    {
        $siteID = SiteController::getSiteID(SiteController::getSite());

        $cmsMenu = getMenuByName("CMS Menu");
        Capabilities::addNewCapability('websites', 4, 4, 4, 2);

        $sites = MenuItem::create(['name' => 'Homepage Banners',
            'link' => '#!',
            'parent' => $cmsMenu->id,
            'site' => $siteID,
            'page' => "websites",
        ]);

<<<<<<< HEAD
        MenuItem::create(['name' => 'All Sites',
            'link' => '/cms/websites',
=======
        MenuItem::create(['name' => 'All Homepage Banners',
            'link' => '/cms/homepage_banners',
>>>>>>> TheJokersThief/master
            'parent' => $sites->id,
            'site' => $siteID,
            'page' => "websites",
        ]);

<<<<<<< HEAD
        MenuItem::create(['name' => 'Add Site',
            'link' => '/cms/websites/create',
=======
        MenuItem::create(['name' => 'Add Homepage Banner',
            'link' => '/cms/homepage_banners/create',
>>>>>>> TheJokersThief/master
            'parent' => $sites->id,
            'site' => $siteID,
            'page' => "websites",
        ]);

    }
}
