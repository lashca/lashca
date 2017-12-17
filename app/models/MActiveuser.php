<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

class MActiveuser extends ModelBase
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
     * @var string
     * @Column(type="string", length=767, nullable=false)
     */
    public $m_user_mail;

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'm_user_mail',
            new Uniqueness([
                "message" => $this->UniquenessMes,
            ])
        );

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lashca");
        $this->setSource("m_activeuser");
        $this->belongsTo('m_user_id', '\MUser', 'm_user_id', ['alias' => 'MUser']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return MActiveuser[]|MActiveuser|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return MActiveuser|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'm_activeuser';
    }

}
