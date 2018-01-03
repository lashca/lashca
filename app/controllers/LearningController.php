<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;

class LearningController extends ControllerBase
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
        $this->view->title .= "学習";

        $request = new Request();
        if ($request->isAjax() == true) {
            $prevlearninglist = VLearninglist::findPageNo($this->session->get("m_user_id"),$this->data['m_page_id']);
            $learninglist = new TLearninglist();
            $learninglist->m_page_id = $prevlearninglist->m_page_id;
            $learninglist->m_user_id = $prevlearninglist->m_user_id;
            $learninglist->t_learninglist_memorystrength = $prevlearninglist->t_learninglist_memorystrength;
            $learninglist->t_learninglist_learned = 1;
            $learninglist->t_learninglist_corrected = $this->data['t_learninglist_corrected'];
            $learninglist->t_learninglist_answer_time = $this->data['t_learninglist_answer_time'];
            $learninglist->t_learninglist_next_learned_datetime = date("Y-m-d H:i:s",time());

            if($this->data['t_learninglist_corrected'] == 0){
                if($prevlearninglist->m_learned_masterylevel == 0){
                    $learninglist->t_learninglist_next_masterylevel = 0;
                }else{
                    $learninglist->t_learninglist_next_masterylevel = $prevlearninglist->m_learned_masterylevel-1;
                }
                $learninglist->t_learninglist_next_correted_count = 0;
            }elseif($prevlearninglist->m_learned_correctedcount == 0){
                $learninglist->t_learninglist_next_masterylevel = $prevlearninglist->m_learned_masterylevel;
                $learninglist->t_learninglist_next_correted_count = 1;
            }else{
                if($prevlearninglist->m_learned_masterylevel == 3){
                    $learninglist->t_learninglist_next_masterylevel = 3;
                }else{
                    $learninglist->t_learninglist_next_masterylevel = $prevlearninglist->m_learned_masterylevel+1;
                }
                $learninglist->t_learninglist_next_correted_count = 0;
            }

            $learninglist->save();
            $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
        }else{
            $prevlearninglist = VLearninglist::findPageNo($this->session->get("m_user_id"),1);
            $learninglist = VLearninglist::findUser($this->session->get("m_user_id"));
            
            $this->view->setVar("page_num", count($this->session->get("pages")));
            $this->view->setVar("learninglist", $learninglist);
            $this->view->setVar("m_note_name", $this->session->get("m_note_name"));
            $this->view->setVar("m_holdingnote_no", $this->session->get("m_holdingnote_no"));
        }
    }

}