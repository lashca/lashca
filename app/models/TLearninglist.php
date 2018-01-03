<?php

class TLearninglist extends ModelBase
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
    public $m_page_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $t_learninglist_memorystrength;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $t_learninglist_learned;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $t_learninglist_corrected;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $t_learninglist_answer_time;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $t_learninglist_next_learned_datetime;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $t_learninglist_next_masterylevel;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $t_learninglist_next_correted_count;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lashca");
        $this->setSource("t_learninglist");
        $this->belongsTo('m_user_id', '\MUser', 'm_user_id', ['alias' => 'MUser']);
        $this->belongsTo('m_page_id', '\MPage', 'm_page_id', ['alias' => 'MPage']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 't_learninglist';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TLearninglist[]|TLearninglist|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TLearninglist|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function findUser($m_user_id){
        return TLearninglist::find("m_user_id = ".$m_user_id);
    }

    public static function deleteUserId($m_user_id){
        $learninglist = TLearninglist::find("m_user_id = ".$m_user_id);
        $learninglist->delete();
    }

}
