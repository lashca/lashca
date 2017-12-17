<?php

use \Phalcon\Validation\Message;
use \Phalcon\Validation\Validator;
use \Phalcon\Validation\ValidatorInterface;

class SemiuserExists extends Validator implements ValidatorInterface
{

    public function validate(\Phalcon\Validation $validation, $attribute)
    {
        $mes = new ModelBase();
        $value = $validation->getValue($attribute);
        $result = MSemiuser::findFirst("m_semiuser_mail = '".$value."' and m_semiuser_registereddate >= '". date("Y-m-d H:i:s",time()-24*3600)."'")->m_semiuser_id;
        
        if ($result > 0)
        {
            $validation->appendMessage(new Message($mes->SemiuserExistsMes, $attribute, 'SemiuserExists'));
            return false;
        }
        return true;
    }

}