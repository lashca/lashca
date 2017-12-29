<?php

use Phalcon\Mvc\Controller;

class MenuController extends ControllerBase
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();
        if(!$this->session->has("m_user_id")) {
            $this->session->start();
            $this->session->set("url", $_SERVER["REQUEST_URI"]);
            $this->response->redirect("/signup/login");
        }
    }

    public function indexAction()
    {                  
        $this->view->title .= "メニュー";

        $this->view->setVar("m_user_mail", $this->session->get("m_user_mail"));
        $this->view->setVar("url", $_SERVER["REQUEST_URI"]);
    }

}