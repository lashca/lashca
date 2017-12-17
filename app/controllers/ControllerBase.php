<?php

use Phalcon\Mvc\Controller;
use Phalcon\Session\Adapter\Files as Session;

class ControllerBase extends Controller
{
    protected $lashcamail = "support@lashca.com";

    public function beforeExecuteRoute()
    {
        $debug = new \Phalcon\Debug();
        $debug->listen();
        
        $this->view->setTemplateAfter('common');
        $this->assets->addCss('css/landio.css');
        $this->assets->addJs('js/landio.min.js');     
        $this->view->title = "Lashca ";

        $this->data =  $this->request->getPost();
    }

    public function getErrorMessages($modelInstance)
    {
        $messages = "";
        foreach (array_reverse($modelInstance->getMessages()) as $message) {
            $messages[$message->getField()] = $message->getMessage();
        }
        return $messages;
    }

    public function trimSpace($array){
        $array = array_map(function($val){return preg_replace('/^[ 　]+/u', '', $val);}, $array);
        $array = array_map(function($val){return preg_replace('/[ 　]+$/u', '', $val);}, $array);
        return array_map('trim',$array);
    }
}
