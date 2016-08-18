<?php
 class ManageConfigurationRoomController extends My_Controller_Bookmark
{
    public function init()
    {
        $this->whichBookmark = 3; // 3 zakladka i podmenu "Zarządzanie hotelem"
        $this->mainPath = "-> Start -> Panel klienta";
        $this ->_helper->layout()->setLayout("layout_panel");
        $this->idHotel=1;
    }


    public function manageRoomAction (){
        $this->view->formRoomEquipment = new Application_Form_Form_RoomConfiguration();
        $roomConfiguration = new Application_Model_DbTable_ConfigurationRoom();
        $sql = $roomConfiguration
                ->select()
                ->where('id_hotel = ?',$this->idHotel);

        $this->view->listRoomConfiguration = $roomConfiguration->fetchAll($sql);
        $this->view->sql = $sql;
        //$this->view->test = $roomConfiguration->fetchAll($sql)->toArray();

        /* zmienne do przekazania przy każdej akcjii */
         $this->view->isLogin = $this->isLogin;
         $this->view->whoIsLogin= $this->whoIsLogin;
         $this->view->loginName = $this->loginName;
         $this->view->mainPath = $this->mainPath;
         $this->view->whichBookmark =  3;
         $this->view->idHotel = $this->idHotel;
    }

    //AJAX
    public function addRoomConfigurationAction (){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();


        $formRoomEquipment = new Application_Form_Form_RoomConfiguration();

        if($this->getRequest()->isPost()){

            $data = $this->getRequest()->getPost();
            $id_conf = $data['id_conf'];
            unset($data['id_conf']);
            // usunac z data element id_conf i bedzie GIT
            // zapisac id_conf do osbnej zmiennej


            if($formRoomEquipment->isValid($data)){

                    $isset_room = isset($data['equipment_room']);

                    if( $isset_room ){
                        $equipment_room = $data['equipment_room'];
                        unset($data['equipment_room']);
                    }

                    $configurationRoom = new Application_Model_DbTable_ConfigurationRoom();
                    $data['id_hotel'] = $this->idHotel;


                    if( $id_conf != '' ){
                        /// edycja

                        $len_update = $configurationRoom->update($data, array('id = ?' => $id_conf)); //tutaj mozna dodac jeszczie id_hotel

                        if( $isset_room ){
                            $confEquiRoom = new Application_Model_DbTable_ConfEquiRoom();
                            $len_delete = $confEquiRoom->delete(array('id_configuration = ?' => $id_conf));
                            foreach ($equipment_room as $value){
                                $confEquiRoom->insert(array('id_configuration'=>$id_conf,
                                                            'id_equipment'=>$value
                                                            )
                                );
                            }
                        }

                       $date_result = array('result_save'=>2,
                                                 'data' => $data,
                                                 'id_conf' =>$id_conf);

                    } else {
                        /// zapisywanie


                        $id_configuration = $configurationRoom->insert($data);

                        if( $isset_room ){
                            $confEquiRoom = new Application_Model_DbTable_ConfEquiRoom();
                            foreach ($equipment_room as $value) {
                                $confEquiRoom->insert(array('id_configuration'=>$id_configuration,
                                                            'id_equipment'=>$value
                                                            )
                                                     );
                            }
                        }
                            $date_result = array('result_save'=>1,
                                                 'data' => $data,
                                                 'id_conf' =>$id_configuration);
                     }

            } else {
                $date_result = array('result_save'=>0
                                 ,'error_comunicat' => $formRoomEquipment->getMessages()
                                 ,'get_values' => $_POST['name_configuration']
                                 );
            }
        } else {
            $date_result = array('result_save'=>'2',
                                 'error_comunicat' => 'Błąd zapisu');
        }

        //$date_result = array('result_save'=>0, 'get_values' => $_POST['name_configuration']);
        echo Zend_Json::encode($date_result);
    }

    //AJAX
    public function getRoomConfigurationAction (){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();


        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();

            $roomConfiguration = new Application_Model_DbTable_ConfigurationRoom();
            $sql = $roomConfiguration
                ->select()
                ->where('id = ?',(int)$data['id_conf']);

            $confEquiRoom = new Application_Model_DbTable_ConfEquiRoom();
            $sql2= $confEquiRoom
                    ->select()
                    ->where('id_configuration = ?', (int)$data['id_conf']);

            $date_result = array('result_save'=>'1',
                                 'data' => $roomConfiguration->fetchAll($sql)->toArray(),
                                 'data_equi' => $confEquiRoom ->fetchAll($sql2)->toArray()
                                );
        } else {
            $date_result = array('result_save'=>'2',
                                 'error_comunicat' => 'Błąd. Wymuszenie uruchomienia');
        }

        //$date_result = array('result_save'=>0, 'get_values' => $_POST['name_configuration']);
        echo Zend_Json::encode($date_result);
    }

    //AJAX
     public function deleteRoomConfigurationAction (){
         $this->_helper->viewRenderer->setNoRender();
         $this->_helper->getHelper('layout')->disableLayout();

         if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();

            $room = new Application_Model_DbTable_Room();
            $sql = $room->select()->where('id_configuration = ?', $data['id_conf']);
            $roomIsExist = $room->fetchRow($sql);


            if($roomIsExist){
                 $date_result = array('result_save'=>'3',
                                 'error_comunicat' => 'Nie można usunąć konfiguracji przypisanej do pokoju!');
            } else {
                $roomConfiguration = new Application_Model_DbTable_ConfigurationRoom();
                $sql = $roomConfiguration
                    ->delete(array('id = ?' => (int)$data['id_conf']));

                $confEquiRoom = new Application_Model_DbTable_ConfEquiRoom();
                $sql2= $confEquiRoom
                        ->delete(array('id_configuration = ?' => (int)$data['id_conf']));

                $date_result = array('result_save'=>'1');
            }

            
         } else {
            $date_result = array('result_save'=>'2',
                                 'error_comunicat' => 'Błąd. Wymuszenie uruchomienia');
         }

         echo Zend_Json::encode($date_result);

     }
}
?>