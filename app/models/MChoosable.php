<?php

class MChoosable extends ModelBase
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=20, nullable=false)
     */
    public $m_page_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $m_choosable_sentence;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $m_choosable_answer;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $m_choosable_selection_count;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lashca");
        $this->setSource("m_choosable");
        $this->hasMany('m_page_id', 'MSelection', 'm_page_id', ['alias' => 'MSelection']);
        $this->belongsTo('m_page_id', '\MPage', 'm_page_id', ['alias' => 'MPage']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'm_choosable';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MChoosable[]|MChoosable|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MChoosable|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
