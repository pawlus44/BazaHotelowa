<?php 

class Application_Form_Edit_HotelDescription extends Zend_Form {
	public function init(){
		//$this->method = 'post';

		$this->addElement(
			'textarea',
			'basic_description_hotel',
			array('label' => 'Opis podstawowy:',
				'maxlength' => 10,
				'size' => 1000,
				'rows' => 5)
        );
			


		$this->addElement(
			'textarea',
			'extend_description_hotel',
			array('label' => 'Opis rozszerzony:',
					'rows' => 5)
			);


	}

}