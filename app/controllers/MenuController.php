<?php

use Phalcon\Mvc\Controller;

class MenuController extends ControllerBase
{
    public function indexAction()
    {                  
        $this->view->title .= "メニュー";
    }

}