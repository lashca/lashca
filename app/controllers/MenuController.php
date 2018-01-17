<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;

class MenuController extends ControllerBase
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();
        if(!$this->session->has("m_user_id") or !VActiveuser::findId($this->session->get("m_user_id"))->m_user_id>0){
            $this->session->start();
            $this->session->set("url", $_SERVER["REQUEST_URI"]);
            $this->dispatcher->forward(array('controller' => 'signup','action' => 'login'));
        }
    }

    public function indexAction()
    {                  
        $this->view->title .= "メニュー";

        $holdingnotes = VHoldingnotes::findHoldingnotes($this->session->get("m_user_id"));
        $this->view->setVar("holdingnotes", $holdingnotes);
    }

    public function userAction(){
        $this->view->title .= "ユーザ情報";

        $request = new Request();
        if ($request->isPost() == true) {
            $activeuser = VActiveuser::findId($this->session->get("m_user_id"));
            $activeuser->m_user_mail = $this->data['m_user_mail'];
            $activeuser->m_user_lastname = $this->data['m_user_lastname'];
            $activeuser->m_user_firstname = $this->data['m_user_firstname'];
            $activeuser->m_user_name = $this->data['m_user_lastname'].$this->data['m_user_firstname'];
            $activeuser->m_user_sex = $this->data['m_user_sex'];
            $activeuser->m_user_birthday = $this->data['m_user_birthday_year']."-".$this->data['m_user_birthday_month']."-".$this->data['m_user_birthday_day'];
            $activeuser->pass = "dummypassword";
            if ($activeuser->save() === false)
            {
                $message = $this->getErrorMessages($activeuser);
                if(count($message)==0)$this->response->redirect("/help?c=002");
                $this->view->setVar("errormessage", $message);
                $this->view->setVar("data", $this->data);
            }else{
                $this->session->set("m_user_id", $activeuser->m_user_id);
                $this->session->set("m_user_lastname", $activeuser->m_user_lastname);
                $this->session->set("m_user_firstname", $activeuser->m_user_firstname);
                $this->session->set("m_user_mail", $activeuser->m_user_mail);
                $this->response->redirect("/menu");
            }
        }else{
            $activeuser = VActiveuser::findId($this->session->get("m_user_id"));
            $this->data["m_user_mail"] = $activeuser->m_user_mail;
            $this->data["m_user_lastname"] = $activeuser->m_user_lastname;
            $this->data["m_user_firstname"] = $activeuser->m_user_firstname;
            $this->data["m_user_sex"] = $activeuser->m_user_sex;
            list($this->data["m_user_birthday_year"], $this->data["m_user_birthday_month"], $this->data["m_user_birthday_day"]) = explode("-", explode(" ",$activeuser->m_user_birthday)[0]);
            $this->view->setVar("data", $this->data);
        }
    }
    
    public function passwordAction(){
        $this->view->title .= "パスワード変更";

        $request = new Request();
        if ($request->isPost() == true) {
            $activeuser = new VActiveuser();
            $activeuser->m_user_mail = $this->session->get("m_user_mail");
            $activeuser->pass = $this->data['pass'];
            if ($activeuser->updatePass() === false)
            {
                $message = $this->getErrorMessages($activeuser);
                if(count($message)==0)$this->response->redirect("/help?c=002");
                $this->view->setVar("errormessage", $message);
                $this->view->setVar("data", $this->data);
            }else{
                $this->response->redirect("/menu");
            }
        }
    }

    public function cancelAction(){
        $this->view->title .= "解約";

        $request = new Request();
        if ($request->isPost() == true) {
            $activeuser = new VActiveuser();
            $activeuser->m_user_mail = $this->session->get("m_user_mail");
            $activeuser->pass = $this->data['pass'];
            if ($activeuser->updatePass() === false)
            {
                $message = $this->getErrorMessages($activeuser);
                if(count($message)==0)$this->response->redirect("/help?c=002");
                $this->view->setVar("errormessage", $message);
                $this->view->setVar("data", $this->data);
            }else{
                $this->response->redirect("/menu");
            }
        }
    }
    
    public function logoutAction(){
        $this->session->destroy();
        $this->response->redirect("/signup/login");
    }

}