<?php

class VPage extends ModelBase
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
     * @var integer
     * @Column(type="integer", length=20, nullable=true)
     */
    public $m_user_id;

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
        $this->setSource("v_page");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'v_page';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VPage[]|VPage|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VPage|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function findPages($m_user_id,$m_note_id)
    {
        return parent::find(array("conditions" => "m_user_id = ".$m_user_id." and m_note_id = ".$m_note_id));
    }

    public static function findPageNo($m_user_id,$m_note_id,$m_page_no)
    {
        return parent::find(array("conditions" => "m_user_id = ".$m_user_id." and m_note_id = ".$m_note_id." and m_page_no = ".$m_page_no));
    }

}
