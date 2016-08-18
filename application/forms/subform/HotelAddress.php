<?php

class Application_Form_Subform_HotelAddress extends Zend_Form_SubForm
{

    public function init()
    {
        ////////////////// CITY
                    
            $label = "miejscowość";
            $this->addElement(
             'text',
             'city',
                    array(
                          'label'=>'Miejscowość:',
                          'required'=>true,
                          'filters'=>array('StringTrim','StripNewlines'),
                           'validators'=>array(
                                 array('NotEmpty',true),
                                 array('StringLength',true, array('min'=>2,'max'=>80)),
                            )));

        $this->setAttrib("class", "subform-add");

        $this->city->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość.",
            Zend_Validate_StringLength::TOO_SHORT => "Podane $label jest zbyt krótkie.
                $label musi zawierać od 2 do 80 znakow",
            Zend_Validate_StringLength::TOO_LONG => "Podany $label jest zbyt długie.
                $label musi zawierać od 2 do 80 znakow")
                );

        $this->city->getValidator('NotEmpty')->setMessages(array(
        Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));


        ////////////////// STREET

            $label = "ulica";
            $this->addElement(
             'text',
             'street',
                    array(
                          'label'=>'Ulica:',
                          'required'=>false,
                          'filters'=>array('StringTrim','StripNewlines'),
                           'validators'=>array(
                                array('NotEmpty',true),
                                 array('StringLength',true, array('min'=>2,'max'=>100)),
                            )));

        $this->street->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość.",
            Zend_Validate_StringLength::TOO_SHORT => "Podane $label jest zbyt krótkie.
                $label musi zawierać od 2 do 100 znakow",
            Zend_Validate_StringLength::TOO_LONG => "Podany $label jest zbyt długie.
                $label musi zawierać od 2 do 100 znakow")
                );

        $this->street->getValidator('NotEmpty')->setMessages(array(
        Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));

        ////////////////// NUMBER BUILDING

            $label = "numer budynku";
            $this->addElement(
             'text',
             'number_bulid',
                    array(
                          'label'=>'Numer budynku:',
                          'required'=>true,
                          'filters'=>array('StringTrim','StripNewlines'),
                           'validators'=>array(
                                 array('NotEmpty',true),
                                 array('StringLength',true, array('min'=>1,'max'=>10)),
                            )));

        $this->number_bulid->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość.",
            Zend_Validate_StringLength::TOO_SHORT => "Podane $label jest zbyt krótkie.
                $label musi zawierać od 1 do 10 znakow",
            Zend_Validate_StringLength::TOO_LONG => "Podany $label jest zbyt długie.
                $label musi zawierać od 1 do 10 znakow")
                );

        $this->number_bulid->getValidator('NotEmpty')->setMessages(array(
        Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));


        ////////////////// KODPOCZTOWY
            $label = "kod pocztowy";
            $this->addElement(
             'text',
             'zip_code',
                    array(
                          'label'=>'Kod pocztowy:',
                          'required'=>true,
                          'filters'=>array('StringTrim','StripNewlines'),
                           'validators'=>array(
                                 array('NotEmpty',true),
                                 array('StringLength',true, array('min'=>1,'max'=>6)),
                                 array('Regex',false,array('/[0-9]{2}[-]{1}[0-9]{3}/')),
                            )));

        $this->zip_code->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość.",
            Zend_Validate_StringLength::TOO_SHORT => "Podane $label jest zbyt krótkie.
                $label musi zawierać od 1 do 6 znakow",
            Zend_Validate_StringLength::TOO_LONG => "Podany $label jest zbyt długie.
                $label musi zawierać od 1 do 6 znakow")
                );

        $this->zip_code->getValidator('NotEmpty')->setMessages(array(
        Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));

        $this->zip_code->getValidator('Regex')->setMessages(array(
        Zend_Validate_Regex::INVALID=>"Nie właściwy kod pocztowy"
        ));

        ////////////////// POCZTA
            $label = "poczta";
            $this->addElement(
             'text',
             'post',
                    array(
                          'label'=>'Poczta:',
                          'required'=>true,
                          'filters'=>array('StringTrim','StripNewlines'),
                           'validators'=>array(
                                 array('NotEmpty',true),
                                 array('StringLength',true, array('min'=>2,'max'=>80)),
                            )));

        $this->post->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość.",
            Zend_Validate_StringLength::TOO_SHORT => "Podane $label jest zbyt krótkie.
                $label musi zawierać od 2 do 80 znakow",
            Zend_Validate_StringLength::TOO_LONG => "Podany $label jest zbyt długie.
                $label musi zawierać od 2 do 80 znakow")
                );

        $this->post->getValidator('NotEmpty')->setMessages(array(
        Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));
        
        ////////////////// PAŃSTWO
                    $label = "państwo";
            $this->addElement(
             'text',
             'country',
                    array(
                          'label'=>'Państwo:',
                          'required'=>false,
                          'filters'=>array('StringTrim','StripNewlines'),
                           'validators'=>array(
                                 array('NotEmpty',true),
                                 array('StringLength',true, array('min'=>2,'max'=>128)),
                            )));

        $this->country->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość.",
            Zend_Validate_StringLength::TOO_SHORT => "Podane $label jest zbyt krótkie.
                $label musi zawierać od 1 do 10 znakow",
            Zend_Validate_StringLength::TOO_LONG => "Podany $label jest zbyt długie.
                $label musi zawierać od 1 do 10 znakow")
                );

        $this->country->getValidator('NotEmpty')->setMessages(array(
        Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));
    }


}

