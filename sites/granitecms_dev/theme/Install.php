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

        $sites = MenuItem::create(['name' => 'Sites',
            'link' => '#!',
            'parent' => $cmsMenu->id,
            'site' => $siteID,
            'page' => "websites",
        ]);

        MenuItem::create(['name' => 'All Sites',
            'link' => '/cms/websites',
            'parent' => $sites->id,
            'site' => $siteID,
            'page' => "websites",
        ]);

        MenuItem::create(['name' => 'Add Site',
            'link' => '/cms/websites/create',
            'parent' => $sites->id,
            'site' => $siteID,
            'page' => "websites",
        ]);

    }
}
