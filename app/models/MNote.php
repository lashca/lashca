<?php

class MNote extends ModelBase
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=20, nullable=false)
     */
    public $m_note_id;

    /**
     *
     * @var string
     * @Column(type="string", length=30, nullable=false)
     */
    public $m_note_name;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $m_note_profit;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $m_note_price;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=false)
     */
    public $m_notecategory_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $m_note_no;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lashca");
        $this->setSource("m_note");
        $this->hasMany('m_note_id', 'MHoldingnotes', 'm_note_id', ['alias' => 'MHoldingnotes']);
        $this->hasMany('m_note_id', 'MHoldingtags', 'm_note_id', ['alias' => 'MHoldingtags']);
        $this->hasMany('m_note_id', 'MPage', 'm_note_id', ['alias' => 'MPage']);
        $this->belongsTo('m_notecategory_id', '\MNotecategory', 'm_notecategory_id', ['alias' => 'MNotecategory']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'm_note';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MNote[]|MNote|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MNote|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
