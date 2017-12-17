<?php

use Phalcon\Mvc\Controller;
use Phalcon\Db\Column;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class MSemiuser extends ModelBase
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=20, nullable=false)
     */
    public $m_semiuser_id;

    /**
     *
     * @var string
     * @Column(type="string", length=767, nullable=false)
     */
    public $m_semiuser_mail;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $m_semiuser_hash;

    public $pass;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $m_semiuser_registereddate;

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'm_semiuser_mail',
            new PresenceOf([
                'message' => $this->PresenceOfMes,
            ])
        );


        $validator->add(
            'm_semiuser_mail',
            new Email([
                'message' => $this->EmailValidatorMes,
            ])
        );

        $validator->add(
            'm_semiuser_mail',
            new StringLength([
                "max"            => 300,
                "min"            => 0,
                "messageMaximum" => "300".$this->messageMaximumMes,
                "messageMinimum" => "0".$this->messageMinimumMes,
            ])
        );

        $validator->add(
            'm_semiuser_mail',
            new ActiveuserExists([
                'message' => $this->ActiveuserExistsMes,
            ])
        );

        $validator->add(
            'm_semiuser_mail',
            new SemiuserExists([
                'message' => $this->SemiuserExistsMes,
            ])
        );

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lashca");
        $this->setSource("m_semiuser");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'm_semiuser';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MSemiuser[]|MSemiuser|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MSemiuser|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function getSemiUser($passid){
        $semiuser = new MSemiuser();
        if(strlen($passid)>$semiuser->passlength){
            $m_semiuser_id = substr($passid,$semiuser->passlength-strlen($passid));
            $m_semiuser_hash = hash_hmac("sha256",substr($passid,0,$semiuser->passlength),$semiuser->secret);
            $conditions = "m_semiuser_id = :m_semiuser_id: AND m_semiuser_hash = :m_semiuser_hash: and m_semiuser_registereddate >= :m_semiuser_registereddate:";
            $parameters = array("m_semiuser_id" => $m_semiuser_id,"m_semiuser_hash" => $m_semiuser_hash,"m_semiuser_registereddate"=>date("Y-m-d H:i:s",time()-24*3600));
            $types = array("m_semiuser_id" => Column::BIND_PARAM_INT);
            $semiuser = MSemiuser::findFirst(array($conditions,"bind" => $parameters,"bindTypes" => $types));
        }

        return $semiuser;
    }

    public static function mailExists($m_semiuser_mail){
        $result = MSemiuser::findFirst("m_semiuser_mail = '".$m_semiuser_mail."' and m_semiuser_registereddate >= '". date("Y-m-d H:i:s",time()-24*3600)."'")->m_semiuser_id;
        if ($result > 0)return true;
        return false;
    }

    public function save($data=null, $whiteList=null)
    {
        $this->m_semiuser_id = MSemiuser::findFirst("m_semiuser_mail = '".$this->m_semiuser_mail."' and m_semiuser_registereddate < '". date("Y-m-d H:i:s",time()-24*3600)."'")->m_semiuser_id;
        $this->pass = substr(hash_hmac("sha256",'lashca'.$this->m_semiuser_mail.microtime(true),$this->secret),0,$this->passlength);
        $this->m_semiuser_hash = hash_hmac("sha256",$this->pass,$this->secret);
        $this->m_semiuser_registereddate = date("Y-m-d H:i:s",time());
        return parent::save();
    }

}
