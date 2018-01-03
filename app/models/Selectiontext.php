<?php

use \Phalcon\Validation\Message;
use \Phalcon\Validation\Validator;
use \Phalcon\Validation\ValidatorInterface;

class Selectiontext extends Validator implements ValidatorInterface
{

    public function validate(\Phalcon\Validation $validation, $attribute)
    {
        $mes = new ModelBase();
        $value = $validation->getValue($attribute);
        $maximum  = $this->getOption('maximum');

        for($i=1;$i<=$maximum;$i++){
            if($value[$i] == null or $value[$i] == ""){
                $validation->appendMessage(new Message($mes->PresenceOfMes, $attribute, 'Selectiontext'));
                return false;
            }
        }
        return true;
    }

}