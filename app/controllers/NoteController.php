<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;

class NoteController extends ControllerBase
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();
        if(!$this->session->has("m_user_id") or !VActiveuser::findId($this->session->get("m_user_id"))->m_user_id>0){
            $this->session->start();
            $this->session->set("url", $_SERVER["REQUEST_URI"]);
            $this->response->redirect("/signup/login");
        }
    }

    public function indexAction()
    {                  
        $this->view->title .= "ノート作成";

        $request = new Request();
        $this->session->start();
        if ($request->isPost() == true) {
            $holdingnotes = new VHoldingnotes();
            $holdingnotes->m_user_id = $this->session->get("m_user_id");
            $holdingnotes->m_note_name = $this->data['m_note_name'];
            if ($holdingnotes->save() === false)
            {
                $message = $this->getErrorMessages($holdingnotes);
                if(count($message)==0)$this->response->redirect("/help?c=000");
                $this->view->setVar("errormessage", $message);
            }else{
                $this->response->redirect("/menu");
            }
        }
    }
}