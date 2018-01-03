<?php

class MLearned extends ModelBase
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
     * @var integer
     * @Primary
     * @Column(type="integer", length=20, nullable=false)
     */
    public $m_user_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $m_learned_datetime;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $m_learned_correctedcount;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $m_learned_masterylevel;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lashca");
        $this->setSource("m_learned");
        $this->belongsTo('m_page_id', '\MPage', 'm_page_id', ['alias' => 'MPage']);
        $this->belongsTo('m_user_id', '\MUser', 'm_user_id', ['alias' => 'MUser']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'm_learned';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MLearned[]|MLearned|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MLearned|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
