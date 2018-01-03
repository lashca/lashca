<?php

class MHoldingnotes extends ModelBase
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=20, nullable=false)
     */
    public $m_user_id;

    /**
     *
     * @var integer
     * @Primary
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lashca");
        $this->setSource("m_holdingnotes");
        $this->belongsTo('m_note_id', '\MNote', 'm_note_id', ['alias' => 'MNote']);
        $this->belongsTo('m_user_id', '\MUser', 'm_user_id', ['alias' => 'MUser']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'm_holdingnotes';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MHoldingnotes[]|MHoldingnotes|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MHoldingnotes|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    

}
