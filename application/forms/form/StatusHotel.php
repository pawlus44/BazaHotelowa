<?php 

class Application_Form_Form_StatusHotel extends Zend_Form {
	public function init(){

		$this->setMethod('post');

		$this->addElement(
            'select',
            'status_hotel',
             array('label' =>'Ustaw status:',
                    'required'=>true,
                    'multiOptions' => array('0' => 'wybierz',
                    						'1'	=> 'opublikowany',
                    						'2' => 'wyłączony z publikacji'
                    					   ),
                    'validators'=>array(
                             array('Digits', true)
                    ))
        );

		$this->addElement('submit', 
						  'submit_status_hotel',
						  array('label'=>'Zmień status',
						  		'class'=>'button_dark_orange'
						  	));
	}

}


?>