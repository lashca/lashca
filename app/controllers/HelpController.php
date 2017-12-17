<?php

use Phalcon\Http\Request;

class HelpController extends ControllerBase
{      
    public function indexAction()
    {
        $this->view->title .= "ヘルプ";
        $request = new Request();
        $m_error_id = $request->getQuery("c");
        $m_error = MError::findFirst($m_error_id);
        if($m_error->m_error_id>0){
            $this->view->setVar("message", $m_error->m_error_message);
            $this->view->setVar("action", $m_error->m_error_action);
        }else{
            $this->view->setVar("message", "エラー");
        }
    }
    
}