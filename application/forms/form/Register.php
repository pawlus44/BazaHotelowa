<?php

class Application_Form_Form_Register extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');

    $form_user = new Application_Form_Subform_User();
    $form_user_adddress = new Application_Form_Subform_UserAddress();
    $form_user_info = new Application_Form_Subform_UserInfo();
    $form_user_contact = new Application_Form_Subform_UserContact();

    $this->addSubForm($form_user, 'form_user');
    $this->addSubForm($form_user_adddress, 'form_user_address');
    $this->addSubForm($form_user_info, 'form_user_info');
    $this->addSubForm($form_user_contact, 'form_user_contact');
    

    $button_label = 'Rejestracja';
                $this->addElement(
                'submit',
                'submit_register',
                array(
                    'label'=>$button_label,
                    'reguired'=>true,
                    'class'=>'text-5 button_dark_orange'
                )
                );

    }


}

