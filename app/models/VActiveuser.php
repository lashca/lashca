<?php

use Phalcon\Db\Column;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class VActiveuser extends ModelBase
{

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    public $m_user_id;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $m_user_lastname;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $m_user_firstname;

    public $m_user_name;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $m_user_sex;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $m_user_birthday;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    public $m_user_school;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $m_user_company;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $m_user_department;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $m_user_hash;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $m_user_registereddate;

    /**
     *
     * @var string
     * @Column(type="string", length=767, nullable=true)
     */
    public $m_user_mail;

    public $pass;

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            [
                'm_user_name',
                'm_user_lastname',
                'm_user_firstname',
                'm_user_sex',
                'm_user_birthday',
                'pass',
            ],
            new PresenceOf([
                'message' => $this->PresenceOfMes,
            ])
        );

        $validator->add(
            'm_user_name',
            new StringLength([
                "max"            => 200,
                "min"            => 0,
                "messageMaximum" => "200".$this->messageMaximumMes,
                "messageMinimum" => "0".$this->messageMinimumMes,
            ])
        );

        $validator->add(
            'pass',
            new StringLength([
                "max"            => 50,
                "min"            => 8,
                "messageMaximum" => "50".$this->messageMaximumMes,
                "messageMinimum" => "8".$this->messageMinimumMes,
            ])
        );

        $validator->add(
            [
                'm_user_name',
                'm_user_lastname',
                'm_user_firstname',
            ],
            new Regex([
                "pattern" => "/^[ぁ-んァ-ンー\w一-龠]+$/",
                "message" => "全角文字・半角英数字のみ",
            ])
        );

        $validator->add(
            'm_user_sex',
            new Regex([
                "pattern" => "/^[01]$/",
                "message" => $this->PresenceOfMes,
            ])
        );

        $validator->add(
            'pass',
            new Regex([
                "pattern" => "/^[\w\.\-#]+$/",
                "message" => "英数記号(.-#)のみ",
            ])
        );

        $validator->add(
            'm_user_birthday',
            new DateExists([
                "message" => $this->DateExistsMes,
            ])
        );

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("v_activeuser");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'v_activeuser';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VActiveuser[]|VActiveuser|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VActiveuser|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function findId($m_user_id)
    {
        $user = new VActiveuser();
        $conditions = "m_user_id = :m_user_id:";
        $parameters = array("m_user_id" => $m_user_id);
        $types = array("m_user_id" => Column::BIND_PARAM_INT);
        return VActiveuser::findFirst(array($conditions,"bind" => $parameters,"bindTypes" => $types));
    }

    public static function findEmail($m_user_mail)
    {
        $user = new VActiveuser();
        $conditions = "m_user_mail = :m_user_mail:";
        $parameters = array("m_user_mail" => $m_user_mail);
        return VActiveuser::findFirst(array($conditions,"bind" => $parameters));
    }

    public static function findEmailPass($m_user_mail,$pass)
    {
        $user = new VActiveuser();
        $m_user_hash = hash_hmac("sha256",$pass,$user->secret);
        $conditions = "m_user_mail = :m_user_mail: AND m_user_hash = :m_user_hash:";
        $parameters = array("m_user_mail" => $m_user_mail,"m_user_hash" => $m_user_hash);
        return VActiveuser::findFirst(array($conditions,"bind" => $parameters));
    }

    public function save($data=null, $whiteList=null)
    {
        $txManager = new TxManager();
        $transaction = $txManager->get();
        $user = new MUser();
        $activeuser = new MActiveuser();

        $user->setTransaction($transaction);
        $activeuser->setTransaction($transaction);

        $this->m_user_hash = hash_hmac("sha256",$this->pass,$this->secret);
        $this->m_user_registereddate = date("Y-m-d H:i:s",time());
        
        $savedata = array(
            "m_user_id" => $this->m_user_id,
            "m_user_lastname" => $this->m_user_lastname,
            "m_user_firstname" => $this->m_user_firstname,
            "m_user_sex" => $this->m_user_sex,
            "m_user_birthday" => $this->m_user_birthday,
            "m_user_school" => $this->m_user_school,
            "m_user_company" => $this->m_user_company,
            "m_user_department" => $this->m_user_department,
            "m_user_hash" => $this->m_user_hash,
            "m_user_registereddate" => $this->m_user_registereddate,
            "m_user_mail" => $this->m_user_mail,
        );

        if($this->validation()===false){
            return false;
        }
        $user->save($savedata);
        if($user->m_user_id > 0){
            $this->m_user_id = $user->m_user_id;
            $savedata["m_user_id"] = $user->m_user_id;
            if($activeuser->save($savedata)===false){
                return false;
            }
            $transaction->commit();
            return true;
        }else{
            return false;
        }
    }

    public function updatePass(){
        $txManager = new TxManager();
        $transaction = $txManager->get();
        $user = new MUser();
        $user->setTransaction($transaction);

        $conditions = "m_user_mail = :m_user_mail:";
        $parameters = array("m_user_mail" => $this->m_user_mail);
        $activeuser = VActiveuser::findFirst(array($conditions,"bind" => $parameters));
        $activeuser->pass = $this->pass;
        $activeuser->m_user_hash = hash_hmac("sha256",$this->pass,$user->secret);

        $savedata = array(
            "m_user_id" => $activeuser->m_user_id,
            "m_user_lastname" => $activeuser->m_user_lastname,
            "m_user_firstname" => $activeuser->m_user_firstname,
            "m_user_sex" => $activeuser->m_user_sex,
            "m_user_birthday" => $activeuser->m_user_birthday,
            "m_user_school" => $activeuser->m_user_school,
            "m_user_company" => $activeuser->m_user_company,
            "m_user_department" => $activeuser->m_user_department,
            "m_user_hash" => $activeuser->m_user_hash,
            "m_user_registereddate" => $activeuser->m_user_registereddate,
            "m_user_mail" => $activeuser->m_user_mail,
        );

        $this->m_user_id = $activeuser->m_user_id;
        $this->m_user_lastname = $activeuser->m_user_lastname;
        $this->m_user_firstname = $activeuser->m_user_firstname;
        $this->m_user_name = $activeuser->m_user_lastname.$activeuser->m_user_firstname;
        $this->m_user_sex = $activeuser->m_user_sex;
        $this->m_user_birthday = $activeuser->m_user_birthday;
        $this->m_user_school = $activeuser->m_user_school;
        $this->m_user_company = $activeuser->m_user_company;
        $this->m_user_department = $activeuser->m_user_department;
        $this->m_user_hash = $activeuser->m_user_hash;
        $this->m_user_registereddate = $activeuser->m_user_registereddate;
        $this->m_user_mail = $activeuser->m_user_mail;
        $this->pass = $activeuser->pass;


        if($this->validation()===false)return false;
        
        if($user->save($savedata)){
            $transaction->commit();
            return true;
        }else{
            return false;
        }
        
    }
}
