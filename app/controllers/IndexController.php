<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

class IndexController extends ControllerBase
{
    
    public function indexAction()
    {
        $this->view->setRenderLevel(View::LEVEL_LAYOUT);
        $this->view->title .= "";
    }
}