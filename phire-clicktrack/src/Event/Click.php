<?php

namespace Phire\ClickTrack\Event;

use Phire\ClickTrack\Model;
use Pop\Application;

class Cache
{

    /**
     * Save click
     *
     * @param  Application $application
     * @return void
     */
    public static function save(Application $application)
    {
        if ((!$_POST) && ($application->router()->getController() instanceof \Phire\Content\Controller\IndexController)) {
            if ($application->router()->getController()->response()->getCode() == 200) {

            } else if ($application->router()->getController()->response()->getCode() == 404) {

            }
        }
    }

}
