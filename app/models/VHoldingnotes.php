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
     * @Column(type="integer", length=10, nullable=true)
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
                "max"            => 30,
                "min"            => 1,
                "messageMaximum" => "20".$this->messageMaximumMes,
                "messageMinimum" => "1".$this->messageMinimumMes,
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
        return $m_holdingnote_no = parent::find(array("conditions" => "m_user_id = ".$m_user_id));
    }

    public static function findHoldingNo($m_user_id,$m_holdingnote_no)
    {
        return parent::findFirst(array("conditions" => "m_user_id = ".$m_user_id." and m_holdingnote_no = ".$m_holdingnote_no." and m_note_profit = 0"));
    }

    public function save($data=null, $whiteList=null)
    {
        $txManager = new TxManager();
        $transaction = $txManager->get();
        $holdingnotes = new MHoldingnotes();
        $note = new MNote();

        $holdingnotes->setTransaction($transaction);
        $note->setTransaction($transaction);
        
        $savedata = array(
            "m_note_id" => $this->m_note_id,
            "m_user_id" => $this->m_user_id,
            "m_note_name" => $this->m_note_name,
            "m_holdingnote_no" => $this->m_holdingnote_no,
            "m_notecategory_id" => $this->m_notecategory_id,
            "m_holdingnote_starttime" => $this->m_holdingnote_starttime,
            "m_holdingnote_endtime" => $this->m_holdingnote_endtime,
            "m_note_profit" => $this->m_note_profit,
            "m_note_price" => $this->m_note_price,
            "m_note_no" => $this->m_note_no,
        );

        if($this->validation()===false){
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

    public function insertNote(){
        $this->m_holdingnote_no = VHoldingnotes::findNextHoldingNo($this->m_user_id);
        return $this->save();
    }

    public function updateNote(){
        $holdingnotes = VHoldingnotes::findHoldingNo($this->m_user_id,$this->m_holdingnote_no);
        $this->m_notecategory_id = $holdingnotes->m_notecategory_id;
        $this->m_note_id = $holdingnotes->m_note_id;
        $this->m_holdingnote_starttime = $holdingnotes->m_holdingnote_starttime;
        $this->m_holdingnote_endtime = $holdingnotes->m_holdingnote_endtime;
        $this->m_note_profit = $holdingnotes->m_note_profit;
        $this->m_note_price = $holdingnotes->m_note_price;
        $this->m_note_no = $holdingnotes->m_note_no;
        return $this->save();
    }

}
