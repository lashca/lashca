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

        $tlearninglists = TLearninglist::findUser($this->session->get("m_user_id"));
        foreach($tlearninglists as $tlearninglist){
            if($tlearninglist->t_learninglist_learned==1){
                $learned = new MLearned();
                $learned->m_page_id = $tlearninglist->m_page_id;
                $learned->m_user_id = $tlearninglist->m_user_id;
                $learned->m_learned_datetime = $tlearninglist->t_learninglist_next_learned_datetime;
                $learned->m_learned_correctedcount = $tlearninglist->t_learninglist_next_correted_count;
                $learned->m_learned_masterylevel = $tlearninglist->t_learninglist_next_masterylevel;
                $learned->save();
            }
        }

        $note = VNote::findHoldingNo($this->session->get("m_user_id"),$m_holdingnote_no);
        if($note->pagecount == null)$note->pagecount=0;
        if($note->learneddate == null or $note->learneddate == '0000-01-01 00:00:00')$note->learneddate="-";
        $this->session->set("m_note_id", $note->m_note_id);
        $this->session->set("m_note_name", $note->m_note_name);
        $this->session->set("m_holdingnote_no", $m_holdingnote_no);

        

        $pages = VPage::findGroupPages($this->session->get("m_user_id"),$this->session->get("m_note_id"));
        
        $filename = "Learned_".$this->session->get("m_user_id")."_".$note->m_note_id."_".date( "Y-m-d-His" , time()).".csv";
        $f = fopen($this->learnedinput_dir.$filename, "w");
        if ( $f ) {
            foreach($pages as $page){
                $line = array($page->m_page_id,$page->m_learned_datetime,$page->m_learned_correctedcount,$page->m_learned_masterylevel);
                fputcsv($f, $line);
            }
        }
        fclose($f);

        chdir($this->working_dir);
        system('mono '.$this->masteryExe." ".$filename);

        $f = fopen($this->learnedoutput_dir.$filename, "r");
        if ( $f ) {
            while (($line = fgetcsv($f)) !== FALSE) {
                $records[] = $line;
            }
        }
        fclose($f);
        unlink($this->learnedoutput_dir.$filename);

        TLearninglist::deleteUserId($this->session->get("m_user_id"));
        $initline = true;
        $pages = array();
        foreach($records as $record){
            if($initline){
                $masterylevel = $record[0];
                $initline = false;
            }else{
                $learninglist = new TLearninglist();
                $learninglist->m_user_id = $this->session->get("m_user_id");
                $learninglist->m_page_id = $record[0];
                if($record[1]<1)array_push($pages, $record[0]);
                $learninglist->t_learninglist_memorystrength = $record[1];
                $learninglist->save();
            }
        }
        $this->session->set("pages", $pages);
        
        $this->view->setVar("note", $note);
        $this->view->setVar("masterylevel", $masterylevel);
    }

    public function editAction(){
        $this->view->title .= "ノート編集";

        $pages = VPage::findPages($this->session->get("m_user_id"),$this->session->get("m_note_id"));
        $this->view->setVar("pages", $pages);
        $this->view->setVar("m_note_name", $this->session->get("m_note_name"));
    }

    public function pageAction($m_page_no){
        $this->view->title .= "ページ編集";
        
        $request = new Request();
        if ($request->isPost() == true) {
            $update = false;
            if($this->data['m_page_type'] == 1){
                $basic = new VBasic();
                if($this->session->has("m_page_no")){
                    $basic->m_page_id = VBasic::findNoteNo($this->session->get("m_note_id"),$this->session->get("m_page_no"));
                    $basic->m_page_no = $this->session->get("m_page_no");
                    $update = true;
                }else $basic->m_page_no = VBasic::findNextPageNo($this->session->get("m_note_id"));
                $basic->m_note_id = $this->session->get("m_note_id");
                $basic->m_user_id = $this->session->get("m_user_id");
                $basic->m_page_type = 1;
                $basic->m_basic_word = $this->data['m_basic_word'];
                $basic->m_basic_description = $this->data['m_basic_description'];
                $basic->m_basic_reverse_flag = $this->data['m_basic_reverse_flag'];
                if ($basic->upsert($update) === false)
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
                    $update = true;
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
                if ($choosable->upsert($update) === false)
                {
                    $message = $this->getErrorMessages($choosable);
                    if(count($message)==0)$this->response->redirect("/help?c=000");
                    $this->view->setVar("errormessage", $message);
                }else{
                    $this->response->redirect("/note/edit");
                }
            }
        }elseif($m_page_no > 0){
            $this->session->set("m_page_no", $m_page_no);
            $page = VPage::findPageNo($this->session->get("m_user_id"),$this->session->get("m_note_id"),$m_page_no);
            if($page[0]->m_page_type==1){
                $this->data['m_basic_word'] = $page[0]->m_basic_word;
                $this->data['m_basic_description'] = $page[0]->m_basic_description;
                if($page[0]->m_basic_reverse_flag==1) $this->data["startpos"]=1;
            }elseif($page[0]->m_page_type==2){
                $this->data['m_choosable_sentence'] = $page[0]->m_choosable_sentence;
                $this->data['m_choosable_selection_count'] = $page[0]->m_choosable_selection_count;
                $this->data['m_choosable_answer'] = $page[0]->m_choosable_answer;
                for($i=1;$i<=$page[0]->m_choosable_selection_count;$i++){
                    $this->data['m_selection_text'.$i]=$page[$i-1]->m_selection_text;
                }
                $this->data["startpos"]=2;
            }
        }else{
            $this->session->remove("m_page_no");
        }
        if($this->data["startpos"]==null)$this->data["startpos"]=0;
        if($this->data["m_choosable_selection_count"]==null)$this->data["m_choosable_selection_count"]=4;
        if($this->data["m_choosable_answer"]==null)$this->data["m_choosable_answer"]=1;
        $this->view->setVar("data", $this->data);
        $this->view->setVar("m_note_name", $this->session->get("m_note_name"));
    }
}