<?php

use Phalcon\Http\Request;

class SignupController extends ControllerBase
{
    public function beforeExecuteRoute()
    {
        parent::beforeExecuteRoute();
        $this->view->setTemplateAfter('base_signup');
        if($this->session->has("m_user_id") and VActiveuser::findId($this->session->get("m_user_id"))->m_user_id>0) {
            $this->dispatcher->forward(array('controller' => 'menu','action' => ''));
        }
    }

    public function indexAction()
    {
        $this->view->action_name = "仮登録";

        $request = new Request();
        if ($request->isPost() == true) {
            $semiuser = new MSemiuser();
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
        $this->view->action_name = "仮登録完了";

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
		$body .= "Copyright (C) ".date("Y",time())." Lashca, all rights reserved.";
        mb_send_mail($this->session->get('m_semiuser_mail'), $title, $body, "From: ".$this->lashcamail);

        $this->session->destroy();
    }

    public function registrationAction($passid)
    {
        $this->view->action_name = "本登録";

        $request = new Request();
        $this->session->start();
        if ($request->isPost() == true and $this->session->has("m_semiuser_mail")) {
            $avtiveuser = new VActiveuser();
            $avtiveuser->m_user_lastname = $this->data['m_user_lastname'];
            $avtiveuser->m_user_firstname = $this->data['m_user_firstname'];
            $avtiveuser->m_user_name = $this->data['m_user_lastname'].$this->data['m_user_firstname'];
            $avtiveuser->m_user_sex = $this->data['m_user_sex'];
            $avtiveuser->m_user_birthday = $this->data['m_user_birthday_year']."-".$this->data['m_user_birthday_month']."-".$this->data['m_user_birthday_day'];
            $avtiveuser->pass = $this->data['pass'];
            $avtiveuser->m_user_mail = $this->session->get("m_semiuser_mail");
            $avtiveuser->m_user_hash = hash_hmac("sha256",$avtiveuser->pass,$this->secret);
            $avtiveuser->m_user_registereddate = date("Y-m-d H:i:s",time());
            if ($avtiveuser->save() === false)
            {
                $message = $this->getErrorMessages($avtiveuser);
                if(count($message)==0)$this->response->redirect("/help?c=002");
                $this->view->setVar("email", $this->session->get("m_semiuser_mail"));
                $this->view->setVar("errormessage", $message);
            }else{
                $this->session->set("m_user_id", $avtiveuser->m_user_id);
                $this->session->set("m_user_lastname", $avtiveuser->m_user_lastname);
                $this->session->set("m_user_firstname", $avtiveuser->m_user_firstname);
                $this->session->set("m_user_mail", $avtiveuser->m_user_mail);
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
        if($this->data['m_user_birthday_year']=="")$this->data['m_user_birthday_year']="'年'";
        if($this->data['m_user_birthday_month']=="")$this->data['m_user_birthday_month']="'月'";
        if($this->data['m_user_birthday_day']=="")$this->data['m_user_birthday_day']="'日'";
        $this->view->setVar("data", $this->data);
    }

    public function loginAction()
    {
        $this->view->action_name = "ログイン";

        $request = new Request();
        if ($request->isPost() == true) {
            $avtiveuser = VActiveuser::findEmailPass($this->data["m_user_mail"],$this->data['pass']);
            if ($avtiveuser->m_user_id > 0) {
                $this->session->start();
                $this->session->set("m_user_id", $avtiveuser->m_user_id);
                $this->session->set("m_user_lastname", $avtiveuser->m_user_lastname);
                $this->session->set("m_user_firstname", $avtiveuser->m_user_firstname);
                $this->session->set("m_user_mail", $avtiveuser->m_user_mail);
                if($this->session->has("url")) {
                    $this->response->redirect($this->session->get("url"));
                }else{
                    $this->response->redirect("/menu");
                }
            }else{
                $this->view->setVar("data", $this->data);
                $this->view->setVar("errormessage", "メールアドレスまたはパスワードが間違ってます。");
            }
        }
    }

    public function forgotAction()
    {
        $this->view->action_name = "パスワード再登録依頼";

        $request = new Request();
        if ($request->isPost() == true) {
            $forgotuser = new MForgotuser();
            $forgotuser->m_forgotuser_mail = $this->data[m_forgotuser_mail];
            $this->session->start();
            if(MForgotuser::mailExists($forgotuser->m_forgotuser_mail)){
                $this->session->set("sendFlag", false);
            }else{
                $this->session->set("sendFlag", true);
            }
            if ($forgotuser->save() === false)
            {
                $this->view->setVar("data", $this->data);
                $this->view->setVar("errormessage", $this->getErrorMessages($forgotuser));
            }else{
                $this->session->start();
                $this->session->set("m_forgotuser_id", $forgotuser->m_forgotuser_id);
                $this->session->set("m_forgotuser_mail", $forgotuser->m_forgotuser_mail);
                $this->session->set("pass", $forgotuser->pass);
                $this->response->redirect("/signup/forgotcomplete");
            }
        }
    }

    public function forgotcompleteAction()
    {
        $this->view->action_name = "パスワード再登録受付完了";

        if(!$this->session->has("m_forgotuser_mail") or !MForgotuser::mailExists($this->session->get("m_forgotuser_mail"))) {
            $this->response->redirect("/signup/forgot");
        }
        if($this->session->get('sendFlag') and VActiveuser::findEmail($this->session->get("m_forgotuser_mail"))->m_user_id>0){
            $title = "【Lashca】パスワードの再発行";
            $body = "お世話になっております。"."\n";
            $body .= "Lashcaサポートセンターでございます。"."\n\n";
            $body .= "パスワード再登録依頼を受付ました。"."\n";
            $body .= "以下のURLからパスワードの再登録を行ってください。"."\n\n";
            $body .= "URL: https://".$_SERVER['HTTP_HOST']."/signup/reset/".$this->session->get('pass').$this->session->get('m_forgotuser_id')."\n\n";
            $body .= "何卒よろしくお願いいたします。"."\n\n";
            $body .= "―――――――――――――――――――――――――――――――"."\n";
            $body .= "Copyright (C) ".date("Y",time())." Lashca, all rights reserved.";
            mb_send_mail($this->session->get('m_forgotuser_mail'), $title, $body, "From: ".$this->lashcamail);
        }
        $this->session->destroy();
    }

    public function resetAction($passid)
    {
        $this->view->action_name = "パスワード再登録";

        $request = new Request();
        $this->session->start();
        if ($request->isPost() == true and $this->session->has("m_forgotuser_mail")) {
            $avtiveuser = new VActiveuser();
            $avtiveuser->pass = $this->data['pass'];
            $avtiveuser->m_user_mail = $this->session->get("m_forgotuser_mail");
            if ($avtiveuser->updatePass() === false)
            {
                $message = $this->getErrorMessages($avtiveuser);
                $this->view->setVar("email", $this->session->get("m_forgotuser_mail"));
                $this->view->setVar("errormessage", $message);
            }else{
                $this->session->set("m_user_lastname", $avtiveuser->m_user_lastname);
                $this->session->set("m_user_firstname", $avtiveuser->m_user_firstname);
                $this->session->set("m_user_mail", $avtiveuser->m_user_mail);
                $this->response->redirect("/signup/resetcomplete");
            }
        }else{
            $forgotuser = MForgotuser::getForgetUser($passid);
            if($forgotuser->m_forgotuser_id>0){
                $this->session->set("m_forgotuser_mail", $forgotuser->m_forgotuser_mail);
                $this->view->setVar("email", $forgotuser->m_forgotuser_mail);
            }else{
                $this->response->redirect("/help?c=000");
            }
        }
        $this->view->setVar("data", $this->data);
    }

    public function resetcompleteAction(){
        $this->view->action_name = "パスワード再登録完了";
        if ($this->session->has("m_user_mail")) {
            $this->session->start();
            $this->session->set("m_user_id", VActiveuser::findEmail($this->session->get("m_user_mail"))->m_user_id);
        }else{
            $this->response->redirect("/help?c=000");
        }
    }

    public function termsAction(){
        $this->view->action_name = "利用規約";
        
    }

    public function privacyAction(){
        $this->view->action_name = "プライバシーポリシー";
    }
}