<?php

use Phalcon\Db\Column;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\Between;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class VChoosable extends ModelBase
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
    public $m_choosable_sentence;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $m_choosable_answer;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $m_choosable_selection_count;

    public $m_selection_text;

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            [
                'm_note_id',
                'm_page_no',
                'm_page_type',
                'm_choosable_sentence',
                'm_choosable_answer',
            ],
            new PresenceOf([
                'message' => $this->PresenceOfMes,
            ])
        );

        $validator->add(
            [
                'm_choosable_sentence',
            ],
            new StringLength([
                "max"            => 300,
                "min"            => 0,
                "messageMaximum" => "300".$this->messageMaximumMes,
                "messageMinimum" => "0".$this->messageMinimumMes,
            ])
        );

        $validator->add(
            [
                'm_choosable_selection_count',
            ],
            new Between([
                "minimum" => 1,
                "maximum" => 8,
                "message" => $this->BetweenMes,
            ])
        );

        $validator->add(
            'm_choosable_answer',
            new Between([
                "minimum" => 1,
                "maximum" => $this->m_choosable_selection_count,
                "message" => $this->BetweenMes,
            ])
        );

        $validator->add(
            'm_selection_text',
            new Selectiontext([
                "maximum" => $this->m_choosable_selection_count,
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
        $this->setSource("v_choosable");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'v_choosable';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VChoosable[]|VChoosable|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VChoosable|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function upsert($update)
    {
        $txManager = new TxManager();
        $transaction = $txManager->get();
        $page = new MPage();
        $choosable = new MChoosable();
        $selection = new MSelection();
        $learned = new MLearned();

        $page->setTransaction($transaction);
        $choosable->setTransaction($transaction);
        $selection->setTransaction($transaction);
        $learned->setTransaction($transaction);
        
        $savedata = array(
            "m_page_id" => $this->m_page_id,
            "m_note_id" => $this->m_note_id,
            "m_user_id" => $this->m_user_id,
            "m_page_no" => $this->m_page_no,
            "m_page_type" => $this->m_page_type,
            "m_choosable_sentence" => $this->m_choosable_sentence,
            "m_choosable_answer" => $this->m_choosable_answer,
            "m_choosable_selection_count" => $this->m_choosable_selection_count,
        );

        if($this->validation()===false){
            return false;
        }
        $page->save($savedata);
        if($page->m_page_id > 0){
            $this->m_page_id = $page->m_page_id;
            $savedata["m_page_id"] = $page->m_page_id;
            if(!$choosable->save($savedata))return false;
            if(!$update and !$learned->save($savedata))return false;
            
            for($i=1;$i<=$this->m_choosable_selection_count;$i++){
                $selection = new MSelection();
                $selection->setTransaction($transaction);
                $savedata["m_selection_no"] = $i;
                $savedata["m_selection_text"] = $this->m_selection_text[$i];
                if(!$selection->save($savedata))return false;
            }
            $transaction->commit();
            return true;
        }else{
            return false;
        }
    }

}
