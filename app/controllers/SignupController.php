<?php

use Phalcon\Http\Request;

class SignupController extends ControllerBase
{      
    public function indexAction()
    {
        $this->view->title .= "仮登録";

        $request = new Request();
        if ($request->isPost() == true) {
            $semiuser = new MSemiuser();
            $this->data = $this->trimSpace($this->data);
            $semiuser->m_semiuser_mail = $this->data[m_semiuser_mail];
            if ($semiuser->save() === false)
            {
                $this->view->setVar("data", $this->data);
                $this->view->setVar("errormessage", $this->getErrorMessages($semiuser));
            }else{
                $this->session->start();
                $this->session->set("m_semiuser_id", $semiuser->m_semiuser_id);
                $this->session->set("m_semiuser_mail", $semiuser->m_semiuser_mail);
                $this->session->set("pass", $semiuser->pass);
                $this->response->redirect("/signup/complete");
            }
        }
    }

    public function completeAction()
    {
        $this->view->title .= "仮登録完了";

        if(!$this->session->has("m_semiuser_mail") or !MSemiuser::mailExists($this->session->get("m_semiuser_mail"))) {
            $this->response->redirect("/signup");
        }
        $title = "【Lashca】仮登録完了が完了しました。";
        $body = "お世話になっております。"."\n";
		$body .= "Lashcaサポートセンターでございます。"."\n\n";
		$body .= "このたびは、「Lashca」をお申し込みいただき、"."\n";
		$body .= "誠にありがとうございます。仮登録を承りました。"."\n\n";
		$body .= "当サービスのお申し込みを完了させるには、以下のURLにアクセスして、"."\n";
		$body .= "本登録のお手続きをお進めください。"."\n";
		$body .= "￣￣￣￣￣￣￣￣"."\n";
		$body .= "URL: https://".$_SERVER['HTTP_HOST']."/signup/registration/".$this->session->get('pass').$this->session->get('m_semiuser_id')."\n";
		$body .= "┏…┳…┓"."\n";
		$body .= "┃重┃要┃仮登録より、24時間以内に本登録を行ってください。"."\n";
		$body .= "┗…┻…┛………………………………………………………………"."\n";
		$body .= "上述URLは、発行より24時間経つと無効になります。"."\n\n";
		$body .= "無効となった場合、お手数をおかけして申し訳ございませんが、"."\n";
		$body .= "再度仮登録のお手続きをお願いいたします。"."\n\n";
		$body .= "※当メールは自動送信専用となり、返信は受け付けておりません。"."\n\n";
		$body .= "何卒よろしくお願いいたします。"."\n\n";
		$body .= "―――――――――――――――――――――――――――――――"."\n";
		$body .= "Copyright (C) ".date("Y",time())." Lashca.com all rights reserved.";
        mb_send_mail($this->session->get('m_semiuser_mail'), $title, $body, "From: ".$this->lashcamail);

        $this->session->destroy();
    }

    public function registrationAction($passid)
    {
        $this->view->title .= "本登録";

        $request = new Request();
        $this->session->start();
        if ($request->isPost() == true and $this->session->has("m_semiuser_mail")) {
            $this->data = $this->trimSpace($this->data);
            $avtiveuser = new VActiveuser();
            $avtiveuser->m_user_lastname = $this->data['m_user_lastname'];
            $avtiveuser->m_user_firstname = $this->data['m_user_firstname'];
            $avtiveuser->m_user_name = $this->data['m_user_lastname'].$this->data['m_user_firstname'];
            $avtiveuser->m_user_sex = $this->data['m_user_sex'];
            $avtiveuser->m_user_birthday = $this->data['m_user_birthday_year']."-".$this->data['m_user_birthday_month']."-".$this->data['m_user_birthday_day'];
            $avtiveuser->pass = $this->data['pass'];
            $avtiveuser->m_user_mail = $this->session->get("m_semiuser_mail");
            if ($avtiveuser->save() === false)
            {
                $message = $this->getErrorMessages($avtiveuser);
                if(strlen($message)==0)$this->response->redirect("/help?c=002");
                $this->view->setVar("email", $this->session->get("m_semiuser_mail"));
                $this->view->setVar("errormessage", $this->getErrorMessages($avtiveuser));
            }else{
                $this->session->set("m_user_id", $avtiveuser->m_user_id);
                $this->view->setVar("email", $avtiveuser->m_user_id);
                $this->response->redirect("/menu");
            }
        }else{
            $semiuser = MSemiuser::getSemiUser($passid);
            if($semiuser->m_semiuser_id>0){
                $this->session->set("m_semiuser_mail", $semiuser->m_semiuser_mail);
                $this->view->setVar("email", $semiuser->m_semiuser_mail);
            }else{
                $this->response->redirect("/help?c=001");
            }
        }
        if($this->data['m_user_birthday_year']=="")$this->data['m_user_birthday_year']="'----'";
        if($this->data['m_user_birthday_month']=="")$this->data['m_user_birthday_month']="'--'";
        if($this->data['m_user_birthday_day']=="")$this->data['m_user_birthday_day']="'--'";
        $this->view->setVar("data", $this->data);
    }
}

