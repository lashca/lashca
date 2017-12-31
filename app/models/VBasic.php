<?php

use Phalcon\Db\Column;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class VBasic extends ModelBase
{

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    public $m_page_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    public $m_note_id;

    public $m_user_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    public $m_page_no;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $m_page_type;

    /**
     *
     * @var string
     * @Column(type="string", length=767, nullable=true)
     */
    public $m_page_urlword;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $m_basic_word;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $m_basic_description;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $m_basic_reverse_flag;

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            [
                'm_note_id',
                'm_user_id',
                'm_page_no',
                'm_page_type',
                'm_basic_word',
                'm_basic_description',
                'm_basic_reverse_flag',
            ],
            new PresenceOf([
                'message' => $this->PresenceOfMes,
            ])
        );

        $validator->add(
            [
                'm_basic_word',
                'm_basic_description',
            ],
            new StringLength([
                "max"            => 300,
                "min"            => 0,
                "messageMaximum" => "300".$this->messageMaximumMes,
                "messageMinimum" => "0".$this->messageMinimumMes,
            ])
        );

        $validator->add(
            'm_page_type',
            new Regex([
                "pattern" => "/^[1]$/",
                "message" => $this->PresenceOfMes,
            ])
        );

        $validator->add(
            'm_basic_reverse_flag',
            new Regex([
                "pattern" => "/^[01]$/",
                "message" => $this->PresenceOfMes,
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
        $this->setSource("v_basic");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'v_basic';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VBasic[]|VBasic|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VBasic|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function findNextPageNo($m_note_id)
    {
        $m_page_no = parent::maximum(array("column" => "m_page_no","conditions" => "m_note_id = ".$m_note_id));
        if($m_page_no > 0)return $m_page_no+1;
        else return 1;
    }

    public function save($data=null, $whiteList=null)
    {
        $txManager = new TxManager();
        $transaction = $txManager->get();
        $page = new MPage();
        $basic = new MBasic();
        $learned = new MLearned();

        $page->setTransaction($transaction);
        $basic->setTransaction($transaction);
        
        $savedata = array(
            "m_page_id" => $this->m_page_id,
            "m_note_id" => $this->m_note_id,
            "m_user_id" => $this->m_user_id,
            "m_page_no" => $this->m_page_no,
            "m_page_type" => $this->m_page_type,
            "m_basic_word" => $this->m_basic_word,
            "m_basic_description" => $this->m_basic_description,
            "m_basic_reverse_flag" => $this->m_basic_reverse_flag,
            "m_page_urlword" => $this->m_page_urlword,
        );

        if($this->validation()===false){
            return false;
        }
        $page->save($savedata);
        if($page->m_page_id > 0){
            $this->m_page_id = $page->m_page_id;
            $savedata["m_page_id"] = $page->m_page_id;
            if(!$basic->save($savedata) or !$learned->save($savedata)){
                return false;
            }
            $transaction->commit();
            return true;
        }else{
            return false;
        }
    }

}
