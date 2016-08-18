<?php

class Application_Form_Subform_UserInfo extends Zend_Form_SubForm
{

    public function init()
    {
        $this->setMethod('post');

////////////////////////////////// IMIE
       $label = "imię";
         $this->addElement(
         'text',
         'name',
                array(
                      'label'=>'Imię (imiona):',
                      'required'=>true,
                      'filters'=>array('StringTrim','StripNewlines'),
                      'validators'=>array(
                            array('NotEmpty',true),
                            array('StringLength',true, array('min'=>2,'max'=>128)))
                    ));

        $this->setAttrib("class", "subform-add");

        $this->name->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość.",
            Zend_Validate_StringLength::TOO_SHORT => "Podane $label jest zbyt krótkie.
                $label musi zawierać od 2 do 128 znakow",
            Zend_Validate_StringLength::TOO_LONG => "Podany $label jest zbyt długie.
                $label musi zawierać od 2 do 128 znakow")
                );

        $this->name->getValidator('NotEmpty')->setMessages(array(
        Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));
        
////////////////////////////////// IMIE 2
/*        $label = "Drugie imię";

         $this->addElement(
         'text',
         'second_name',
                array(
                      'label'=>'Drugie imię:',
                      'required'=>false,
                      'filters'=>array('StringTrim','StripNewlines'),
                      'validators'=>array(
                            array('StringLength',true, array('min'=>2,'max'=>128))
                    )
                 ));

        $this->second_name->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość.",
            Zend_Validate_StringLength::TOO_SHORT => "Podane $label jest zbyt krótkie.
                $label musi zawierać od 2 do 128 znakow",
            Zend_Validate_StringLength::TOO_LONG => "Podany $label jest zbyt długie.
                $label musi zawierać od 2 do 128 znakow")
                );

*/
////////////////////////////////// NAZWISKO
        $label = "nazwisko";
         $this->addElement(
         'text',
         'surname',
                array(
                      'label'=>'Nazwisko:',
                      'required'=>true,
                      'filters'=>array('StringTrim','StripNewlines'),
                      'validators'=>array(
                            array('NotEmpty',true),
                            array('StringLength',true, array('min'=>2,'max'=>128)))
                    ));

        $this->surname->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość.",
            Zend_Validate_StringLength::TOO_SHORT => "Podane $label jest zbyt krótkie.
                $label musi zawierać od 2 do 128 znakow",
            Zend_Validate_StringLength::TOO_LONG => "Podany $label jest zbyt długie.
                $label musi zawierać od 2 do 128 znakow")
                );

        $this->surname->getValidator('NotEmpty')->setMessages(array(
        Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));

////////////////////////////////// NAZWISKO 2
/*         $label = "Nazwisko 2";
         $this->addElement(
         'text',
         'surname2',
                array(
                      'label'=>'Nazwisko:',
                      'required'=>true,
                      'filters'=>array('StringTrim','StripNewlines'),
                      'validators'=>array(
                            array('StringLength',true, array('min'=>2,'max'=>128)))
                    ));

        $this->surname2->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość.",
            Zend_Validate_StringLength::TOO_SHORT => "Podane $label jest zbyt krótkie.
                $label musi zawierać od 2 do 128 znakow",
            Zend_Validate_StringLength::TOO_LONG => "Podany $label jest zbyt długie.
                $label musi zawierać od 2 do 128 znakow")
                );
 */

    }



}

