<?php

class Application_Form_Form_StatusReservation extends Zend_Form
{
 
    public function init()
    {
        $this->setOptions(array('class'=>'set_status_reservation'));

        $this->setMethod('post');
    }

    public function setStatus($currentStatus){
       
      
        $this->addElement(
            'select',
            'status_reservation',
             array('label' =>'Status rezerwacji:',
                    'required'=>true,
                    'multiOptions' => array(0 => 'wybierz',
                                            1 => 'zgłoszony - oczekuje na potwierdzenie',
                                            2 => 'rezerwacja potwierdzona',
                                            3 => 'rezerwacja anulowana przez administratora'),
                    'value' => $currentStatus,
                    'validators'=>array(
                             array('Digits', true)
                    ))
          );

       
    }
}

