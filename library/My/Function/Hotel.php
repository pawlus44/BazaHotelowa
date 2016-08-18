<?php

class My_Function_Hotel {

	static public function getHotelById( $idHotel){
		$data = array('hotel_info' => '',
					  'room'  => array('info' => array(),
					  				   'offers' => array()
					  				  ),
					  'services' => array() 
					  );

		$hotel = new Application_Model_DbTable_Hotel();
		$hotelAddress = new Application_Model_DbTable_HotelAddress();
		$typeOfHotel = new Application_Model_DbTable_TypeOfHotel();
		
		/* get info hotel */
		$select = $hotel->select();
       	$select->setIntegrityCheck(false); 

       	$sql = $select
            ->from(array('h'=>'hotel'))
            ->joinInner(array('ha'=>'hotel_address'),
                       'h.id_hotel = ha.id_hotel')
            ->joinInner(array('toh'=>'type_of_hotel'),
                       'h.id_type_of_hotel = toh.id_type_of_hotel',
                       array('toh.name_image')) 
            ->where('h.id_hotel = ?', $idHotel);

        $data['hotel_info'] =  $hotel->fetchRow($sql)->toArray();

        /* get info (min_price)*/

        $room = new Application_Model_DbTable_Room();
        $roomConfiguration = new Application_Model_DbTable_ConfigurationRoom();
        
   
        $sql = $room->select()
        			->from(array('rooms'),array('min(price_per_person) as min_price'))
        			->where('id_hotel = ?', $idHotel);

        $data['room']['info'] = $room->fetchRow($sql)->toArray();

        /* get offers */


        $select = $room->select();
        $select->setIntegrityCheck(false); 
        $sql = $select
            ->from(array('r'=>'rooms'))
            ->joinInner(array('rc'=>'configuration_rooms'),
                       'r.id_configuration = rc.id') 
            ->where('r.id_hotel = ?', $idHotel)
            ->group(array('r.number_bad','r.price_per_person','r.price_per_room'));

		$data['room']['offers'] = $room->fetchAll($sql)->toArray();

        $data['sql'] = $sql;
        /* get equpment rooms*/
		$equipmentRoom = new Application_Model_DbTable_EquipmentRoom();
		$confEquiRoom = new Application_Model_DbTable_ConfEquiRoom();

		$select = $roomConfiguration ->select();
		$select->setIntegrityCheck(false);

		$sql= $select
              ->from(array('e'=>'equipment_rooms'))
              ->joinInner(array('cer'=>'conf_equi_rooms'),
                       'e.id = cer.id_equipment',
                       array())
              ->joinInner(array('rc'=>'configuration_rooms'),
                       'cer.id_configuration = rc.id',
                       array())           
              ->where('rc.id_hotel = ?', $idHotel)
              ->group(array('e.id'));

        $data['services'] = $equipmentRoom->fetchAll($sql)->toArray();
        $data['sql'] = $sql;
		return $data;
	}

  static public function getHotelInfoById( $idHotel){
    $data = array('hotel_info' => '',
 
            );

    $hotel = new Application_Model_DbTable_Hotel();
    $hotelAddress = new Application_Model_DbTable_HotelAddress();
    $typeOfHotel = new Application_Model_DbTable_TypeOfHotel();
    
    /* get info hotel */
    $select = $hotel->select();
        $select->setIntegrityCheck(false); 

        $sql = $select
            ->from(array('h'=>'hotel'))
            ->joinInner(array('ha'=>'hotel_address'),
                       'h.id_hotel = ha.id_hotel')
            ->joinInner(array('toh'=>'type_of_hotel'),
                       'h.id_type_of_hotel = toh.id_type_of_hotel',
                       array('toh.name_image')) 
            ->where('h.id_hotel = ?', $idHotel);

        $data['hotel_info'] =  $hotel->fetchRow($sql)->toArray();

       
    return $data;
  }

    static public function validateDataHotel($idHotel){
        $dataHotel = My_Function_Hotel::getHotelById( $idHotel);
        $errors = $warnings = array();

        //errors
        if(count($dataHotel['room']['offers']) == 0){
            $errors['room']='Nie wprowadzono do systemu żadnego pokoju który można wynająć.';
        }

        if($dataHotel['hotel_info']['basic_description_hotel']==''){
            $errors['basic_description_hotel'] = 'Brak opisu hotelu.';
        }

        if($dataHotel['hotel_info']['name_logo_file']==''){
            $errors['name_logo_file'] = 'Brak zdjęcia/loga hotelu.';
        }

        if(   $dataHotel['hotel_info']['city'] == ''
           || $dataHotel['hotel_info']['number_bulid'] == ''
           || $dataHotel['hotel_info']['code_post'] == ''
           || $dataHotel['hotel_info']['post'] == ''
           )
        {
            $errors['address'] = 'Nie podano pełnego adresu.';
        }


        //warnings
        if(count($dataHotel['room']['offers']) < 5){
            $warnings['room']='Ilość wprowadzonych pokoi wydaje się zbyt mała. 
            Optymalna liczba to min. 5 pokoi.';
        }

        if(count($dataHotel['services']) == 0){
            $warnings['services']='Nie znaleziono żadnych usług oferowanych przez hotel.';
        }


        return array('dataHotel' => $dataHotel,
                   'errors' => $errors,
                   'warnings' => $warnings);
    }

    static public function getHotelsList(){
        $hotel = new Application_Model_DbTable_Hotel(); 
        $sql = $hotel->select()->where('status = ?', 1 );

        $listHotel = $hotel->fetchAll($sql);
        $arrayListHotel = array();

        foreach ($listHotel as $singleHotel) {
            $arrayListHotel['hotel_'.$singleHotel->id_hotel] = 
            My_Function_Hotel::getHotelById((int)$singleHotel->id_hotel);
        }   


        return $arrayListHotel;
    }

    static public function getHotelsListByIdList($listId){
        $arrayListHotel = array();

        foreach ($listId as $singleHotel) {
            $arrayListHotel['hotel_'.$singleHotel->id_hotel] = 
            My_Function_Hotel::getHotelById((int)$singleHotel->id_hotel);
        }   


        return $arrayListHotel;
    }




}
?>