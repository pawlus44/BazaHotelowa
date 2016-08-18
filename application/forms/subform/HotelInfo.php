<?php

class Application_Form_Subform_HotelInfo extends Zend_Form_SubForm
{
	public function init(){
		////// HOTEL NAME
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
                                'required'=>true,
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

    }

    //// typ of hotel

    
    


}




/* szablon */
/*
class Application_Form_Subform_HotelInfo extends Zend_Form_SubForm
{
	public function init(){

	}
}
*/



?>