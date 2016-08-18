<?php

class Application_Form_Subform_LoginUser extends Zend_Form_SubForm
{

    public function init()
    {
        $this->setMethod('post');
        /////////////////////////// KONTROLKA NAZWA UŻYTKOWNIKA
        $this->addElement(
         'text',
         'username',
                array(
                      'label'=>'Login/e-mail:',
                      'required'=>true,
                      'filters'=>array('StringTrim','StripNewlines'),
                      'validators'=>array(
                       array('NotEmpty',true))
                ));

        $this->username->getValidator('NotEmpty')->setMessages(array(
        Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));
/////////////////////////// KONTROLKA HASŁO
        $this->addElement (
                'password',
                'password',
                array(
                    'label'=>'Hasło:',
                    'required'=>true,
                    'filters'=>array('StringTrim','StripNewlines'),
                    'validators'=>array(
                    array('NotEmpty',true))
                ));

        $this->password->getValidator('NotEmpty')->setMessages(array(
        Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));


    }


}

