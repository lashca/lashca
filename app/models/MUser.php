<?php

class MUser extends ModelBase
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=20, nullable=false)
     */
    public $m_user_id;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $m_user_lastname;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $m_user_firstname;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $m_user_sex;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $m_user_birthday;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    public $m_user_school;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $m_user_company;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $m_user_department;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $m_user_hash;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $m_user_registereddate;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lashca");
        $this->setSource("m_user");
        $this->hasMany('m_user_id', 'MActiveuser', 'm_user_id', ['alias' => 'MActiveuser']);
        $this->hasMany('m_user_id', 'MNote', 'm_user_id', ['alias' => 'MNote']);
        $this->hasMany('m_user_id', 'MTerminateduser', 'm_user_id', ['alias' => 'MTerminateduser']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'm_user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MUser[]|MUser|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MUser|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
