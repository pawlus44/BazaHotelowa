<?php

class Application_Form_Form_HotelLogo extends Zend_Form
{
 
    public function init()
    {
        $this->setOptions(array('id'=>'hotel-logo-form'));

        $this->setMethod('post');

        $this->addElement(
             'file',
             'hotel_logo',
                  array(
                        //'label'=>'Wybierz zdjęcie tytułowe lub logo hotelu:',
                        'required'=>true,
                        'style' => array("display:none")
                        ));
    }

}

