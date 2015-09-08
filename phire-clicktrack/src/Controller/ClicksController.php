<?php

namespace Phire\ClickTrack\Controller;

use Phire\ClickTrack\Model;
use Phire\Controller\AbstractController;
use Pop\Paginator\Paginator;

class SearchesController extends AbstractController
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
            $this->redirect(BASE_PATH . APP_URI . '/clicks?removed=' . time());
        } else {
            if ($click->hasPages($this->config->pagination)) {
                $limit = $this->config->pagination;
                $pages = new Paginator($click->getCount(), $limit);
                $pages->useInput(true);
            } else {
                $limit = null;
                $pages = null;
            }

            $this->prepareView('index.phtml');
            $this->view->title  = 'ClickTrack';
            $this->view->pages  = $pages;
            $this->view->clicks = $click->getAll(
                $limit, $this->request->getQuery('page'), $this->request->getQuery('sort')
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
