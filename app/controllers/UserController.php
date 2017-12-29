<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;

class UserController extends ControllerBase
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();

    }

    public function indexAction()
    {
        $this->view->title .= "メニュー";
        $this->view->setVar("user", $this->session->get("user"));
    }

    public function completeAction()
    {
        $this->response->redirect("/note");
        $this->view->title .= "ユーザ情報変更完了";
    }

    

    public function resetAction()
    {
        $this->view->title .= "パスワード変更";
    }

    public function resetcompleteAction()
    {
        $this->view->title .= "パスワード変更完了";
    }
}