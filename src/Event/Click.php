<?php
/**
 * Phire ClickTrack Module
 *
 * @link       https://github.com/phirecms/phire-clicktrack
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.phirecms.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Phire\ClickTrack\Event;

use Phire\ClickTrack\Model;
use Pop\Application;

/**
 * Click Event class
 *
 * @category   Phire\ClickTrack
 * @package    Phire\ClickTrack
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.phirecms.org/license     New BSD License
 * @version    1.0.0
 */
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
