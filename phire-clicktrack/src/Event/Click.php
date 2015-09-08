<?php

namespace Phire\ClickTrack\Event;

use Phire\ClickTrack\Model;
use Pop\Application;

class Click
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
            $uri   = $application->router()->getController()->request()->getRequestUri();
            if ($uri != '/favicon.ico') {
                $click = new Model\Click();
                if ($application->router()->getController()->response()->getCode() == 200) {
                    $click->saveContent($uri, 'content');
                } else if ($application->router()->getController()->response()->getCode() == 404) {
                    $click->saveContent($uri, 'error');
                }
            }
        }
    }

}
