<?php

use Phalcon\Db\Column;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Mvc\Model\Transaction\Manager as TxManager;

class VNote extends ModelBase
{

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
    public $m_note_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    public $m_holdingnote_no;

    /**
     *
     * @var string
     * @Column(type="string", length=30, nullable=true)
     */
    public $m_note_name;

    /**
     *
     * @var string
     * @Column(type="string", length=45, nullable=true)
     */
    public $m_notecategory_name;

    /**
     *
     * @var integer
     * @Column(type="integer", length=21, nullable=false)
     */
    public $pagecount;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $learneddate;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lashca");
        $this->setSource("v_note");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'v_note';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VNote[]|VNote|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VNote|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function findHoldingNo($m_user_id,$m_holdingnote_no)
    {
        $conditions = "m_user_id = :m_user_id: and m_holdingnote_no = :m_holdingnote_no:";
        $parameters = array("m_user_id" => $m_user_id,"m_holdingnote_no" => $m_holdingnote_no);
        $types = array("m_user_id" => Column::BIND_PARAM_INT,"m_holdingnote_no" => Column::BIND_PARAM_INT);
        return VNote::findFirst(array($conditions,"bind" => $parameters,"bindTypes" => $types));
    }

}
