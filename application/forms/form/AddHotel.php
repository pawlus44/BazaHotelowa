<?php 

class Application_Form_Form_AddHotel extends Zend_Form {
	public function init(){

		$this->setMethod('post');

		$hotelInfo = new Application_Form_Subform_HotelInfo();
		$hotelAddress = new Application_Form_Subform_HotelAddress();


		$this->addSubForm($hotelInfo, 'hotel_info');
		$this->addSubForm($hotelAddress, 'hotel_address');

		$this->addElement('submit', 
						  'submit_add_hotel',
						  array('label' => 'Zapisz dane',
						  		'class' => 'button_dark_orange'));
	}

}


?>