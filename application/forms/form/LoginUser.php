<?php

class Application_Form_Form_LoginUser extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');

        $subform_login = new Application_Form_Subform_LoginUser();

        $this->addSubForm($subform_login, 'subform_login');

///////////////////////////// PRZYCISK PRZETWARZANIA FORMULARZA
        $this->addElement(
                'submit',
                'submit_login',
                array(
                    'label'=>'Zaloguj',
                    'reguired'=>true
                )
                );
        
    }


}

