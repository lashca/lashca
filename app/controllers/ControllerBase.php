<?php

use Phalcon\Mvc\Controller;
use Phalcon\Session\Adapter\Files as Session;

class ControllerBase extends Controller
{
    protected $lashcamail = "support@lashca.com";

    protected $working_dir = "";
    protected $learnedinput_dir = "";
    protected $learnedoutput_dir = "";
    protected $masteryExe = "";

    public function beforeExecuteRoute()
    {
        $this->working_dir = dirname(__FILE__)."/../../C#/MasteryLevelCalculator/MasteryLevelCalculator/";
        $this->learnedinput_dir = dirname(__FILE__)."/../../C#/MasteryLevelCalculator/MasteryLevelCalculator/data/input/";
        $this->learnedoutput_dir = dirname(__FILE__)."/../../C#/MasteryLevelCalculator/MasteryLevelCalculator/data/output/";
        $this->masteryExe = dirname(__FILE__)."/../../C#/MasteryLevelCalculator/MasteryLevelCalculator/MasteryLevel.exe";
        
        $this->view->setTemplateAfter('base');
        $this->assets->addCss('css/landio.css');
        $this->assets->addJs('js/landio.min.js');     
        $this->view->title = "Lashca ";

        $this->data =  $this->request->getPost();
        $this->data = $this->trimSpace($this->data);
    }

    public function afterExecuteRoute(){
        $this->view->title .= $this->view->action_name;
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
        $array = array_map(function($val){return htmlspecialchars($val, ENT_QUOTES, 'UTF-8', false);},$array);
        return array_map('trim',$array);
    }
}
