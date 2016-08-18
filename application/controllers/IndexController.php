<?php

class IndexController extends My_Controller_Default
{

    public function init()
    {
        $this->infoToolbar = 1;
        $this->whoIsLogin = 1;
        $this->isLogin = 1;
    }

    public function indexAction()
    {
         $this->view->isLogin = $this->isLogin;
         $this->view->whoIsLogin = $this->whoIsLogin;
         $this->view->infoToolbar = $this->infoToolbar;
         $this->view->whichDisplayPanel=$this->whichDisplayPanel;

         $this->view->listHotel = My_Function_Hotel::getHotelsList();
         
         $this->view->komunikat = $this->komunikat;

        /* zmienne przekazywane standardowo*/
        $this->view->mainPath = $this->mainPath." -> Start";
        $this->view->loginName = $this->loginName;
    }

    public function addHotelStartAction()
    {
        if($this->isLogin == 1 ){
            $this->view->loginName = $this->loginName;
        }


        $this->view->isLogin = $this->isLogin;
        $this->view->whoIsLogin = $this->whoIsLogin;
        $this->view->infoToolbar = $this->infoToolbar;
        $this->view->whichDisplayPanel=$this->whichDisplayPanel;


        /* zmienne przekazywane standardowo*/
        $this->view->mainPath = $this->mainPath." -> Start -> Dodoaj hotel do bazy";
        
    }

    public function reservationRoomAction(){

        $hotel = new Application_Model_DbTable_Hotel();

        if($this->getRequest()->isGet()){
            $id_hotel = (int) $this->getRequest()->getParam('data');
            
            $sql = $hotel
                    -> select()
                    -> where('id_hotel = ?', $id_hotel)
                    -> where('status = ?', 1);
            $dataHotel = $hotel->fetchRow($sql);
        }

        if($dataHotel == null){
            $this->view->komunikat = array('type' => '0', 'text'=>"Błąd. Nie odnaleziono hotelu");
        } else {
            $this->view->dataHotel = My_Function_Hotel::getHotelInfoById($id_hotel);
            //$this->view->komunikat = array('type' => '0', 'text'=>"Błąd. Nie odnaleziono hotelu");
        }



        $this->view->mainPath = $this->mainPath." -> Rejestracja on-line";
        $this->view->isLogin = $this->isLogin;
        $this->view->whoIsLogin = $this->whoIsLogin;
        $this->view->infoToolbar = $this->infoToolbar;
        $this->view->whichDisplayPanel=$this->whichDisplayPanel;
        $this->view->loginName = $this->loginName;
        
    }

    //AJAX
    public function reservationRoomInfoAction(){
        //$this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $availableRoom =array();
            $keyToDelete = array();

            $hotel = new Application_Model_DbTable_Hotel();

            $select= $hotel->select();
            $select->setIntegrityCheck(false); 
            $sql = $select
                ->from(array('r'=>'rooms'))
                ->joinLeft(array('rr'=>'reservation_room'),
                           'rr.id_room = r.id')
                ->joinLeft(array('cr'=>'configuration_rooms'),
                           'cr.id = r.id_configuration')
                ->where('r.id_hotel = ?', $data['id_hotel']);


            $listRooms = $hotel -> fetchAll($sql) -> toArray();

            foreach ($listRooms as $key => $room) {
                 $availableRoom[$room['number_bad'].'_os_'.$room['price_per_person'].'_pp_'.
                $room['id_configuration']] = 0;
            }

            foreach ($listRooms as $key => $room) {
                $super_key = $room['number_bad'].'_os_'.$room['price_per_person'].'_pp_'.
                $room['id_configuration'];

                if( $room['date_start']) {
                    if( ($data['date_start'] < $room['date_start']
                        && $data['date_stop'] < $room['date_start'] ) 
                        ||
                        ($data['date_start'] > $room['date_stop']
                        && $data['date_stop'] > $room['date_stop'])                       
                        ){

                        if($availableRoom[$super_key] != 0){
                              $keyToDelete['index_'.$key] = $key;
                        }

                        $availableRoom[$super_key] =
                        $availableRoom[$super_key] + 1;
                    } else {
                          $keyToDelete['index_'.$key] = $key;
                    }
                } else {

                    if($availableRoom[$super_key] != 0){
                        $keyToDelete['index_'.$key] = $key;
                    }

                    $availableRoom[$super_key] = 
                    $availableRoom[$super_key] + 1;

                }
            }

            foreach ($keyToDelete as $key => $value) {
                 unset($listRooms[(int)$value]);
            }


            $this->view->displayList = count($listRooms, COUNT_RECURSIVE);
            $this->view->listRooms = $listRooms;
            $this->view->availableRoom = $availableRoom;
            $this->view->keyToDelete = $keyToDelete;
        } 

 
    }

    //AJAX
    public function saveReservationRoomAction(){
        $this->_helper->layout->disableLayout();
        
        if($this->getRequest()->isPost() && $this->isLogin ){
            $data = $this->getRequest()->getPost();

            $room = new Application_Model_DbTable_Room();
            $reservationRoom = new Application_Model_DbTable_RoomReservation();
            $reservation = new Application_Model_DbTable_Reservation();

            $bootstrap=$this->getInvokeArg('bootstrap');
            $db = $bootstrap->getResource('db');
            //$db->setFetchMode();
            $check = 0;
            foreach ($data['room_reserve'] as $key => $row) {
                //pobranie pokoi zajetych
                $select = $room->select();
                $select->setIntegrityCheck(false); 
                $sql = $select
                        ->from(array('r'=>'rooms'), array('r.id','r.id'))
                        ->joinLeft(array('cr'=>'configuration_rooms'),
                           'cr.id = r.id_configuration')
                        ->joinLeft(array('rr'=>'reservation_room'),
                                  'rr.id_room = r.id',
                                  array(''))
                                  
                        ->where('r.id_hotel = ?', $data['id_hotel'])
                        ->where('r.number_bad = ?', $row['number_bad'])
                        ->where('r.id_configuration =?', $row['id_configuration'])
                        ->where('rr.date_start <= ?',$data['date_start'])
                        ->where('rr.date_stop >= ?',$data['date_start'])
                        ->orWhere('rr.date_start <= ?',$data['date_stop'])
                        ->where('rr.date_stop >= ?',$data['date_stop']);
                $notAvailableRoom = $db->fetchPairs($sql);
                
                //pobranie wszytskich pokoi
                $select = $room->select();
                $sql = $select
                        ->from(array('r'=>'rooms'), array('r.id','r.id'))
                        ->where('r.id_hotel = ?', $data['id_hotel'])
                        //->where('r.id_configuration =?', $row['id_configuration'])
                        ->where('r.number_bad = ?', $row['number_bad']);
                $allRoom = $db->fetchPairs($sql);
                
                //roznica
                $availableRoom = array_diff($allRoom,$notAvailableRoom );
                $availableRoom = array_values($availableRoom);


                if( isset($availableRoom[0])){
                    $saveConfiguration[$key] = array(
                                                'result'=> 1,
                                                'id_room' => $availableRoom[0] );

                } else {   
                    $saveConfiguration[$key] = array(
                                                'result'=> 0 );
                    $check = 1;
                }
            
            }

            if( $check != 1){
                $id_reservation = $reservation
                                    ->insert(array('id_hotel' => $data['id_hotel'],
                                                   'id_user' => $this ->idUser,
                                                   'status' => 1,
                                                   'number_room' => count($saveConfiguration),
                                                   'date_start' => $data['date_start'],
                                                   'date_stop' => $data['date_stop']
                                            ));
                foreach ($saveConfiguration as $key => $row) {
                      $id_res_room = $reservationRoom
                                    ->insert(array('id_room'=>$row['id_room'],
                                                   'id_reservation' => $id_reservation,
                                                   'date_start'=>$data['date_start'],
                                                   'date_stop'=>$data['date_stop']
                                        ));                  
                }
                $this->view->statusSave = 1;

            } else {
                $this->view->statusSave = 0;
            }

                $this->view->notAvailableRoom= $notAvailableRoom;
                $this->view->allRoom = $allRoom;
                $this->view->availableRoom = $availableRoom;  
           
        } else{
            $this->view->statusSave = 0;
        }


        $this->view->loginForm = new Application_Form_Form_LoginUser();
        $this->view->isLogin = $this->isLogin;
        $this->view->whoIsLogin = $this->whoIsLogin;
        $this->view->infoToolbar = $this->infoToolbar;
        $this->view->whichDisplayPanel=$this->whichDisplayPanel;
    }

    public function showSearchHotelAction(){

        $this->view->searchForm = new Application_Form_Form_SearchHotel();

        $this->view->mainPath = $this->mainPath." -> Wyszukiwarka";
        $this->view->isLogin = $this->isLogin;
        $this->view->whoIsLogin = $this->whoIsLogin;
        $this->view->infoToolbar = $this->infoToolbar;
        $this->view->whichDisplayPanel=$this->whichDisplayPanel;
        $this->view->loginName = $this->loginName;

    } 

    // AJAX
    public function actionSearchHotelAction(){
        $this->_helper->layout->disableLayout();

        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();

            $listPrice = array( '1' => 'r.price_per_person <= 20',
                                '2' => 'r.price_per_person > 20 AND r.price_per_person <= 30',
                                '3' => 'r.price_per_person > 30 AND r.price_per_person <= 50',
                                '4' => 'r.price_per_person > 50 AND r.price_per_person <= 100',
                                '5' => 'r.price_per_person > 100 AND r.price_per_person <= 200',
                                '6' => 'r.price_per_person > 200 AND r.price_per_person <= 500',
                                '7' => 'r.price_per_person <= 500'
                            ); 

            $hotel = new Application_Model_DbTable_Hotel;

            $select = $hotel -> select();
            $select ->setIntegrityCheck(false);

            $select -> from('hotel as h',array('h.id_hotel'))
                    -> joinLeft('hotel_address as ha', 
                                'h.id_hotel = ha.id_hotel',
                                array(''))
                    -> joinLeft('rooms as r', 
                                'h.id_hotel = r.id_hotel',
                                array(''))
                    -> where('h.status = ?', 1 )
                    -> group(array('h.id_hotel'));

            

            if($data['city'] != ''){
                $select -> where('city = ?' , $data['city']);
            }

            if($data['type_of_hotel'] != 0){
                $select -> where('h.id_type_of_hotel = ?',$data['type_of_hotel']);
            }

            if($data['price_per_person'] != 0){
                $select -> where($listPrice[$data['price_per_person']]);
            }


            $this->view->sql = $select;
            $this->view->listHotel =My_Function_Hotel::getHotelsListByIdList($hotel->fetchAll($select));

        }

    }

    public function getListCityAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        $hotelAddress = new Application_Model_DbTable_HotelAddress();

        $sql = $hotelAddress 
                -> select() 
                -> from('hotel_address',array('city'))
                -> group(array('city'));

        $listCity = $hotelAddress->fetchAll($sql)->toArray();
        $clearListCity = array();

        foreach ($listCity as $key => $single) {
            $clearListCity[] = $single['city'];
        }

        echo Zend_Json::encode($clearListCity);
    }

    public function reservationInfoAction(){
        $this->view->mainPath = $this->mainPath." -> Rezerwacje";
        $this->view->isLogin = $this->isLogin;
        $this->view->whoIsLogin = $this->whoIsLogin;
        $this->view->infoToolbar = $this->infoToolbar;
        $this->view->whichDisplayPanel=$this->whichDisplayPanel;
        $this->view->loginName = $this->loginName;
    }

    public function systemInfoAction(){
        $this->view->mainPath = $this->mainPath." -> System Zarządzania Hotelem";
        $this->view->isLogin = $this->isLogin;
        $this->view->whoIsLogin = $this->whoIsLogin;
        $this->view->infoToolbar = $this->infoToolbar;
        $this->view->whichDisplayPanel=$this->whichDisplayPanel;
        $this->view->loginName = $this->loginName;
    }



}

