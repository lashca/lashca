<?php

use Phalcon\Mvc\Model;

class ModelBase extends Model
{
    public $PresenceOfMes = "未入力";
    public $messageMaximumMes = "字以上";
    public $messageMinimumMes = "字以下";
    public $EmailValidatorMes = "入力ミス";
    public $UniquenessMes = "登録済み";
    public $DateExistsMes = "未入力";
    public $BetweenMes = "入力ミス";
    public $ActiveuserExistsMes = "登録済みメールアドレス";
    public $SemiuserExistsMes = "仮登録済みメールアドレス";

    protected $secret = "lashca#2017-11-29-00:45";
    protected $passlength = 20;

    public function beforeValidationOnCreate() {
        $this->setup(array('notNullValidations' => false));
    }

    
}