<?php

class Application_Form_Edit_Password extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');

        $subform_login = new Application_Form_Subform_LoginUser();

        

        /////////////////////////// KONTROLKA HASŁO
        $this->addElement (
                'password',
                'first_password',
                array(
                    'label'=>'Nowe hasło:',
                    'required'=>true,
                    'filters'=>array('StringTrim','StripNewlines'),
                    'validators'=>array(
                        array('NotEmpty',true),
                        array('StringLength',true, array('min'=>8,'max'=>128)))
                )
                );

            $this->first_password->getValidator('NotEmpty')->setMessages(array(
            Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));

            $this->first_password->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość podanego hasła.",
            Zend_Validate_StringLength::TOO_SHORT => "Podane hasło jest zbyt krótkie.
                Hasło musi zawierać od 8 do 128 znaków",
            Zend_Validate_StringLength::TOO_LONG => "Podane hasło jest zbyt długie.
                Hasło musi zawierać od 8 do 128 znaków")
                );

        ///////////////////////////// SPRAWDZENIE POPRAWNOŚCI HASŁA
        $this->addElement (
                'password',
                'second_password',
                array(
                    'label'=>'Powtórz hasło:',
                    'required'=>true,
                    'filters'=>array('StringTrim','StripNewlines'),
                    'validators'=>array(
                        array('NotEmpty',true)
                )));

        $this->second_password->getValidator('NotEmpty')->setMessages(array(
        Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));

        $confpassword= new My_Validators_PasswordConfirmation();
        $this->second_password->addValidator($confpassword,true, array('first_password'));


        $button_label = 'Zmień hasło';
           $this->addElement(
                'submit',
                'submit_change_password',
                array(
                    'label'=>$button_label,
                    'reguired'=>true,
                    'class'=>'button_dark_blue'
                )
           );



    }




}

