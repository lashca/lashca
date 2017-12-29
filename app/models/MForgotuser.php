<?php

use Phalcon\Mvc\Controller;
use Phalcon\Db\Column;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class MForgotuser extends ModelBase
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=20, nullable=false)
     */
    public $m_forgotuser_id;

    /**
     *
     * @var string
     * @Column(type="string", length=767, nullable=false)
     */
    public $m_forgotuser_mail;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $m_forgotuser_hash;

    public $pass;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $m_forgotuser_registereddate;

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'm_forgotuser_mail',
            new PresenceOf([
                'message' => $this->PresenceOfMes,
            ])
        );


        $validator->add(
            'm_forgotuser_mail',
            new Email([
                'message' => $this->EmailValidatorMes,
            ])
        );

        $validator->add(
            'm_forgotuser_mail',
            new StringLength([
                "max"            => 300,
                "min"            => 0,
                "messageMaximum" => "300".$this->messageMaximumMes,
                "messageMinimum" => "0".$this->messageMinimumMes,
            ])
        );

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("m_forgotuser");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'm_forgotuser';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MForgotuser[]|MForgotuser|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MForgotuser|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function getForgetUser($passid){
        $forgotuser = new MForgotuser();
        if(strlen($passid)>$forgotuser->passlength){
            $m_forgotuser_id = substr($passid,$forgotuser->passlength-strlen($passid));
            $m_forgotuser_hash = hash_hmac("sha256",substr($passid,0,$forgotuser->passlength),$forgotuser->secret);
            $conditions = "m_forgotuser_id = :m_forgotuser_id: AND m_forgotuser_hash = :m_forgotuser_hash: and m_forgotuser_registereddate >= :m_forgotuser_registereddate:";
            $parameters = array("m_forgotuser_id" => $m_forgotuser_id,"m_forgotuser_hash" => $m_forgotuser_hash,"m_forgotuser_registereddate"=>date("Y-m-d H:i:s",time()-24*3600));
            $types = array("m_forgotuser_id" => Column::BIND_PARAM_INT);
            $forgotuser = MForgotuser::findFirst(array($conditions,"bind" => $parameters,"bindTypes" => $types));
        }

        return $forgotuser;
    }

    public static function mailExists($m_forgotuser_mail){
        $result = MForgotuser::findFirst("m_forgotuser_mail = '".$m_forgotuser_mail."' and m_forgotuser_registereddate >= '". date("Y-m-d H:i:s",time()-24*3600)."'")->m_forgotuser_id;
        if ($result > 0)return true;
        return false;
    }

    public function save($data=null, $whiteList=null)
    {
        $this->m_forgotuser_id = MForgotuser::findFirst("m_forgotuser_mail = '".$this->m_forgotuser_mail."' and m_forgotuser_registereddate < '". date("Y-m-d H:i:s",time()-24*3600)."'")->m_forgotuser_id;
        $this->pass = substr(hash_hmac("sha256",'lashca'.$this->m_forgotuser_mail.microtime(true),$this->secret),0,$this->passlength);
        $this->m_forgotuser_hash = hash_hmac("sha256",$this->pass,$this->secret);
        $this->m_forgotuser_registereddate = date("Y-m-d H:i:s",time());
        return parent::save();
    }

}
