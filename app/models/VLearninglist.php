<?php

use Phalcon\Db\Column;

class VLearninglist extends ModelBase
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
    public $m_user_id;

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
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=true)
     */
    public $m_note_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=20, nullable=true)
     */
    public $m_page_no;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
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
    public $m_basic_word;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $m_basic_description;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $m_basic_reverse_flag;

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

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $m_selection_no;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $m_selection_text;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $m_learned_datetime;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    public $m_learned_correctedcount;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    public $m_learned_masterylevel;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lashca");
        $this->setSource("v_learninglist");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'v_learninglist';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VLearninglist[]|VLearninglist|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VLearninglist|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function findUser($m_user_id){
        return parent::find(array("conditions" => "m_user_id = ".$m_user_id));
    }

    public static function findPageNo($m_user_id,$m_page_id)
    {
        $conditions = "m_user_id = :m_user_id: and m_page_id = :m_page_id: ";
        $parameters = array("m_user_id" => $m_user_id,"m_page_id" => $m_page_id);
        $types = array("m_user_id" => Column::BIND_PARAM_INT,"m_page_id" => Column::BIND_PARAM_INT);
        return parent::findFirst(array($conditions,"bind" => $parameters,"bindTypes" => $types));
    }

}
