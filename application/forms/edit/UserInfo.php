<?php

class Application_Form_Edit_UserInfo extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');


        $form_user_info = new Application_Form_Subform_UserInfo();
        $this->addSubForm($form_user_info, 'form_user_info');
        /*$button_label = 'Zmień dane';
           $this->addElement(
                'button',
                'button_change_userinfo',
                array(
                    'label'=>$button_label,
                    'reguired'=>true,
                    'class'=>'text-5'
                )
           );*/



    }




}

