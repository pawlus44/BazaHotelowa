<?php

class Application_Form_Form_SearchHotel extends Zend_Form
{

    public function init(){
        $this->setMethod('post');

        $this->addElement(
        'text',
        'city',
            array(
                    //'allowEmpty' => rt,
                    'label'=>'Miasto:',
                    'required'=>false,
                    'filters'=>array('StringTrim','StripNewlines'),
                )         
        );

        $this->addElement(
            'select',
            'price_per_person',
            array('label' =>'Cena za osobę:',
                    'required'=>false,
                    'multiOptions' => 
                        array(
                            '0' => '',
                            '1' => 'poniżej 20zł',
                            '2' => 'od 20 zł do 30 zł',
                            '3' => 'od 30 zł do 50 zł',
                            '4' => 'od 50 zł do 100 zł',
                            '5' => 'od 100 zł do 200 zł',
                            '6' => 'od 200 zł do 500 zł',
                            '7' => 'powyżej 500 zł'
                           )
            )
        );

        $this->addElement(
            'select',
            'type_of_hotel',
            array('label' =>'Standard:',
                    'required'=>false,
                    'multiOptions' => 
                        array(
                            '0' => '',
                            '1' => 'Hotel 1 gwiazdkowy',
                            '2' => 'Hotel 2 gwiazdkowy',
                            '3' => 'Hotel 3 gwiazdkowy',
                            '4' => 'Hotel 4 gwiazdkowy',
                            '5' => 'Hotel 5 gwiazdkowy',
                            '6' => 'Camping/Pole namiotowe',
                            '7' => 'Schronisko młodzieżowe'
                           )
            )
        );


    }
}

