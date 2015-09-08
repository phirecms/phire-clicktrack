<?php

namespace Phire\ClickTrack\Controller;

use Phire\ClickTrack\Model;
use Phire\Controller\AbstractController;
use Pop\Paginator\Paginator;

class IndexController extends AbstractController
{

    /**
     * Download action method
     *
     * @return void
     */
    public function download($id)
    {
        $click = new Model\Click();
        echo $id
    }
}
