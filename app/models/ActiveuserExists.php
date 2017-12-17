<?php

use \Phalcon\Validation\Message;
use \Phalcon\Validation\Validator;
use \Phalcon\Validation\ValidatorInterface;

class ActiveuserExists extends Validator implements ValidatorInterface
{

    public function validate(\Phalcon\Validation $validation, $attribute)
    {
        $mes = new ModelBase();
        $value = $validation->getValue($attribute);
        $result = MActiveuser::findFirst("m_user_mail = '".$value."'")->m_user_id;
        
        if ($result > 0)
        {
            $validation->appendMessage(new Message($mes->ActiveuserExistsMes, $attribute, 'ActiveuserExists'));
            return false;
        }
        return true;
    }

}