<?php

class Application_Form_Subform_UserContact extends Zend_Form_SubForm
{

    public function init()
    {
            //////////////////////////////  KONTROLA E-MAIL
            $label = "e-mail";
            $this->addElement(
             'text',
             'email_alter',
                    array(
                          'label'=>'Alternatywny e-mail użytkownika:',
                          'required'=>false,
                          'filters'=>array('StringTrim','StripNewlines'),
                           'validators'=>array(
                                 array('EmailAddress',true),
                                 array('StringLength',true, array('min'=>6,'max'=>128)),
                            )));
        
        $this->setAttrib("class", "subform-add");


        $this->email_alter->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość.",
            Zend_Validate_StringLength::TOO_SHORT => "Podane $label jest zbyt krótkie.
                $label musi zawierać od 6 do 128 znakow",
            Zend_Validate_StringLength::TOO_LONG => "Podany $label jest zbyt długie.
                $label musi zawierać od 6 do 128 znakow")
                );

        $this->email_alter->getValidator('EmailAddress')->setMessages(array(
                Zend_Validate_EmailAddress::INVALID_FORMAT=>"Podany adres e-mail jest niepoprawny."
        ));
/////////////////////////// KONTROLKA TELEFON
         $label = "Telefon";
         $this->addElement(
         'text',
         'telephone',
                array(
                      'label'=>'Telefon:',
                      'required'=>false,
                      'filters'=>array('StringTrim','StripNewlines'),
                      'validators'=>array(
                            array('StringLength',true, array('min'=>4,'max'=>20)))
                    ));

        $this->telephone->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość.",
            Zend_Validate_StringLength::TOO_SHORT => "Podane $label jest zbyt krótkie.
                $label musi zawierać od 4 do 20 znakow",
            Zend_Validate_StringLength::TOO_LONG => "Podany $label jest zbyt długie.
                $label musi zawierać od 4 do 20 znakow")
                );

    }


}

