<?php

use \Phalcon\Validation\Message;
use \Phalcon\Validation\Validator;
use \Phalcon\Validation\ValidatorInterface;

class DateExists extends Validator implements ValidatorInterface
{

    public function validate(\Phalcon\Validation $validation, $attribute)
    {
        $mes = new ModelBase();
        $value = $validation->getValue($attribute);
        
        try{
            list($Y, $m, $d) = explode('-', $value);
            if (checkdate($m, $d, $Y) === true) {
                return true;
            }
        }catch(Exception $e){}

        $validation->appendMessage(new Message($mes->DateExistsMes, $attribute, 'ActiveuserExists'));
        return false;
    }

}