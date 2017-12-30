<?php

use Phalcon\Db\Column;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class VHoldingnotes extends ModelBase
{

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=true)
     */
    public $m_notecategory_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    public $m_note_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    public $m_user_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    public $m_holdingnote_no;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $m_holdingnote_starttime;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $m_holdingnote_endtime;

    /**
     *
     * @var string
     * @Column(type="string", length=30, nullable=true)
     */
    public $m_note_name;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $m_note_masterylevel;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    public $m_note_profit;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $m_note_price;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $m_note_no;

    /**
     *
     * @var string
     * @Column(type="string", length=45, nullable=true)
     */
    public $m_notecategory_name;

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            [
                'm_note_name',
                'm_user_id',
                'm_holdingnote_no',
            ],
            new PresenceOf([
                'message' => $this->PresenceOfMes,
            ])
        );

        $validator->add(
            'm_note_name',
            new StringLength([
                "max"            => 10,
                "min"            => 0,
                "messageMaximum" => "10".$this->messageMaximumMes,
                "messageMinimum" => "0".$this->messageMinimumMes,
            ])
        );
    }
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lashca");
        $this->setSource("v_holdingnotes");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'v_holdingnotes';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VHoldingnotes[]|VHoldingnotes|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VHoldingnotes|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function findNextHoldingNo($m_user_id)
    {
        $m_holdingnote_no = parent::maximum(array("column" => "m_holdingnote_no","conditions" => "m_user_id = ".$m_user_id));
        if($m_holdingnote_no > 0)return $m_holdingnote_no+1;
        else return 1;
    }

    public static function findHoldingnotes($m_user_id)
    {
        return $m_holdingnote_no = parent::maximum(array("conditions" => "m_user_id = ".$m_user_id));
    }

    public function save($data=null, $whiteList=null)
    {
        $txManager = new TxManager();
        $transaction = $txManager->get();
        $holdingnotes = new MHoldingnotes();
        $note = new MNote();

        $holdingnotes->setTransaction($transaction);
        $note->setTransaction($transaction);

        $this->m_holdingnote_no = VHoldingnotes::findNextHoldingNo($this->m_user_id);
        
        $savedata = array(
            "m_note_id" => $this->m_note_id,
            "m_user_id" => $this->m_user_id,
            "m_note_name" => $this->m_note_name,
            "m_holdingnote_no" => $this->m_holdingnote_no,
        );

        if($this->validation()===false){
            $transaction->rollback();
            return false;
        }
        $note->save($savedata);
        if($note->m_note_id > 0){
            $this->m_note_id = $note->m_note_id;
            $savedata["m_note_id"] = $note->m_note_id;
            if($holdingnotes->save($savedata)===false){
                return false;
            }
            $transaction->commit();
            return true;
        }else{
            return false;
        }
    }
}
