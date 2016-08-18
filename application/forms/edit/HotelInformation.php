<?php 

class Application_Form_Edit_HotelInformation extends Zend_Form {
	public function init(){
		$this->setMethod('post');

		/// name hotel
		$label = 'nazwa hotelu';

            $this->addElement(
             'text',
             'name_hotel',
                    array(
                          'label'=>'Nazwa hotelu:',
                          'required'=>true,
                          'filters'=>array('StringTrim','StripNewlines'),
                           'validators'=>array(
                                 array('NotEmpty',true),
                                 array('StringLength',true, array('min'=>2,'max'=>80)),
                            )));

        //$this->setAttrib("class", "subform-add");

        $this->name_hotel->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość.",
            Zend_Validate_StringLength::TOO_SHORT => "Podane $label jest zbyt krótkie.
                $label musi zawierać od 2 do 80 znakow",
            Zend_Validate_StringLength::TOO_LONG => "Podany $label jest zbyt długie.
                $label musi zawierać od 2 do 80 znakow")
                );

        $this->name_hotel->getValidator('NotEmpty')->setMessages(array(
        Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));

        /* get info from database*/
        $db = new Application_Model_DbTable_TypeOfHotel();
        $sql = "select * from type_of_hotel";
        $typ =  $db->fetchAll();

         $select_data = array();
        foreach ($typ as $typ_row) {
            $select_data[$typ_row['id_type_of_hotel']] = $typ_row['name']; 
        }

        $this->addElement(  'select',
                            'type_of_hotel',
                            array('label'=>'Typ hotelu',
                                  'multiOptions'=>$select_data,
                                  'required'=>true,
                                  'filters'=>array('StringTrim','StripNewlines'),
                                  'validators'=>array(
                                      array('NotEmpty',true)
                                  )));
        $this->type_of_hotel->getValidator('NotEmpty')->setMessages(array(
        Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));


         /**** NIP ****/

        $this->addElement('text',
                          'nip',
                          array('label'=>'NIP',
                                'required'=>false,
                                'filters'=>array('StringTrim','StripNewlines'),
                                  'validators'=>array(
                                      array('NotEmpty',true),
                                      array('StringLength',true, array('min'=>10,'max'=>10)),
                                  )));

        $this->nip->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość.",
            Zend_Validate_StringLength::TOO_SHORT => "Niepoprawna długość.",
            Zend_Validate_StringLength::TOO_LONG => "Niepoprawna długość."));

        $this->nip->getValidator('NotEmpty')->setMessages(array(
        Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));



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
                          'required'=>true,
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


?>