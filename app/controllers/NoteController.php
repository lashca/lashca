<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;

class NoteController extends ControllerBase
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();
        if(!$this->session->has("m_user_id") or !VActiveuser::findId($this->session->get("m_user_id"))->m_user_id>0){
            $this->session->remove("url");
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

    public function detailAction($m_holdingnote_no)
    {                  
        $this->view->title .= "ノート";
        $note = VNote::findHoldingNo($this->session->get("m_user_id"),$m_holdingnote_no);
        if($note->pagecount == null)$note->pagecount=0;
        if($note->masterylevel == null)$note->masterylevel=0;
        if($note->learneddate == null)$note->learneddate="-";
        $this->session->set("m_note_id", $note->m_note_id);
        $this->view->setVar("note", $note);
    }

    public function editAction(){
        $this->view->title .= "ノート編集";

        $pages = VPage::findPages($this->session->get("m_user_id"),$this->session->get("m_note_id"));
        $this->view->setVar("pages", $pages);
    }

    public function pageAction($m_page_no){
        $this->view->title .= "ページ編集";

        if($m_page_no > 0){
            $this->session->set("m_page_no", $m_page_no);
            $page = VPage::findPageNo($this->session->get("m_user_id"),$this->session->get("m_note_id"),$m_page_no);
            $this->data['m_basic_word'] = $page[0]->m_basic_word;
            $this->data['m_basic_description'] = $page[0]->m_basic_description;
        }elseif($this->session->has("m_page_no")){
            $this->session->remove("m_page_no");
        }
    
        $request = new Request();
        if ($request->isPost() == true) {
            if($this->data['m_page_type'] == 1){
                $basic = new VBasic();
                if($this->session->has("m_page_no")){
                    $basic->m_page_id = VBasic::findNoteNo($this->session->get("m_note_id"),$this->session->get("m_page_no"));
                    $basic->m_page_no = $this->session->get("m_page_no");
                }else $basic->m_page_no = VBasic::findNextPageNo($this->session->get("m_note_id"));
                $basic->m_note_id = $this->session->get("m_note_id");
                $basic->m_user_id = $this->session->get("m_user_id");
                $basic->m_page_type = 1;
                $basic->m_basic_word = $this->data['m_basic_word'];
                $basic->m_basic_description = $this->data['m_basic_description'];
                $basic->m_basic_reverse_flag = $this->data['m_basic_reverse_flag'];
                if ($basic->save() === false)
                {
                    $message = $this->getErrorMessages($basic);
                    if(count($message)==0)$this->response->redirect("/help?c=000");
                    $this->view->setVar("errormessage", $message);
                }else{
                    $this->response->redirect("/note/edit");
                }
            }elseif($this->data['m_page_type'] == 2){
                $choosable = new VChoosable();
                if($this->session->has("m_page_no")){
                    $choosable->m_page_id = VBasic::findNoteNo($this->session->get("m_note_id"),$this->session->get("m_page_no"));
                    $choosable->m_page_no = $this->session->get("m_page_no");
                }else $choosable->m_page_no = VBasic::findNextPageNo($this->session->get("m_note_id"));
                $choosable->m_note_id = $this->session->get("m_note_id");
                $choosable->m_user_id = $this->session->get("m_user_id");
                $choosable->m_page_type = 2;
                $choosable->m_choosable_sentence = $this->data['m_choosable_sentence'];
                $choosable->m_choosable_answer = $this->data['m_choosable_answer'];
                $choosable->m_choosable_selection_count = $this->data['m_choosable_selection_count'];
                for($i=1;$i<=$this->data['m_choosable_selection_count'];$i++){
                    $choosable->m_selection_text[$i] = $this->data['m_selection_text'.$i]; 
                }
                if ($choosable->save() === false)
                {
                    $message = $this->getErrorMessages($choosable);
                    if(count($message)==0)$this->response->redirect("/help?c=000");
                    $this->view->setVar("errormessage", $message);
                }else{
                    $this->response->redirect("/note/edit");
                }
            }
        }
        if($this->data["startpos"]==null)$this->data["startpos"]=0;
        if($this->data["m_choosable_selection_count"]==null)$this->data["m_choosable_selection_count"]=4;
        if($this->data["m_choosable_answer"]==null)$this->data["m_choosable_answer"]=1;
        $this->view->setVar("data", $this->data);
    }
}