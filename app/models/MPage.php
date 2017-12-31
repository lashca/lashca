<?php

class MPage extends ModelBase
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lashca");
        $this->setSource("m_page");
        $this->hasMany('m_page_id', 'MBasic', 'm_page_id', ['alias' => 'MBasic']);
        $this->hasMany('m_page_id', 'MChoosable', 'm_page_id', ['alias' => 'MChoosable']);
        $this->hasMany('m_page_id', 'MLearned', 'm_page_id', ['alias' => 'MLearned']);
        $this->hasMany('m_page_id', 'MPageanswer', 'm_page_id', ['alias' => 'MPageanswer']);
        $this->hasMany('m_page_id', 'TAnswerlog', 'm_page_id', ['alias' => 'TAnswerlog']);
        $this->hasMany('m_page_id', 'TLearninglist', 'm_page_id', ['alias' => 'TLearninglist']);
        $this->belongsTo('m_note_id', '\MNote', 'm_note_id', ['alias' => 'MNote']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'm_page';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MPage[]|MPage|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MPage|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
