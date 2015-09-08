<?php

namespace Phire\ClickTrack\Controller;

use Phire\ClickTrack\Model;
use Phire\Controller\AbstractController;
use Pop\Paginator\Paginator;

class ClicksController extends AbstractController
{

    /**
     * Index action method
     *
     * @return void
     */
    public function index()
    {
        $click = new Model\Click();

        if ($this->request->isPost()) {
            $click->remove($this->request->getPost());
            $this->sess->setRequestValue('removed', true, 1);
            $this->redirect(BASE_PATH . APP_URI . '/clicks');
        } else {
            if ($click->hasPages($this->config->pagination, $this->request->getQuery('filter'))) {
                $limit = $this->config->pagination;
                $pages = new Paginator($click->getCount($this->request->getQuery('filter')), $limit);
                $pages->useInput(true);
            } else {
                $limit = null;
                $pages = null;
            }

            $this->prepareView('index.phtml');
            $this->view->title  = 'ClickTrack';
            $this->view->pages  = $pages;
            $this->view->filter = $this->request->getQuery('filter');
            $this->view->clicks = $click->getAll(
                $this->request->getQuery('filter'), $limit, $this->request->getQuery('page'), $this->request->getQuery('sort')
            );

            $this->send();
        }
    }

    /**
     * Prepare view
     *
     * @param  string $click
     * @return void
     */
    protected function prepareView($click)
    {
        $this->viewPath = __DIR__ . '/../../view';
        parent::prepareView($click);
    }

}
