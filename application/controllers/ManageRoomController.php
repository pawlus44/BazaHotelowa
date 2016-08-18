<?php

class ManageRoomController extends My_Controller_Bookmark{
	
	public function init()
    {
        $this->whichBookmark = 3; // 3 zakladka i podmenu "Zarządzanie hotelem"
        $this->mainPath = "-> Start -> Panel klienta";
        $this ->_helper->layout()->setLayout("layout_panel");
        $this->idHotel=1;
    }

    public function roomAction(){
    	$formRoom = new Application_Form_Form_Room();
    	$formRoom->addMyElementForm($this->idHotel);

    	$this->view->formRoom = $formRoom;

    	
        $room = new Application_Model_DbTable_Room();

        $select = $room->select();
       $select->setIntegrityCheck(false);        
        


            $sql = $select
            ->from(array('r'=>'rooms'))
            ->joinInner(array('rc'=>'configuration_rooms'),
                       'r.id_configuration = rc.id',    
                       array('rc.name_configuration')) 
            ->where('r.id_hotel = ?', $this->idHotel);

        $this->view->sql = $sql;
        $this->view->listRoom = $room->fetchAll($sql);
        
    	 /* zmienne do przekazania przy każdej akcjii */
         $this->view->isLogin = $this->isLogin;
         $this->view->whoIsLogin= $this->whoIsLogin;
         $this->view->loginName = $this->loginName;
         $this->view->mainPath = $this->mainPath;
         $this->view->whichBookmark =  3;
         $this->view->idHotel = $this->idHotel;

    }

    //AJAX
    public function addRoomAction() {
    	$this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        
        $formRoom = new Application_Form_Form_Room();
        $formRoom->addMyElementForm($this->idHotel);
        $room = new Application_Model_DbTable_Room();
        $confRoom = new Application_Model_DbTable_ConfigurationRoom();
        

        if($this->getRequest()->isPost()){
        	
        	$data = $this->getRequest()->getPost();

        	$id_room = $data['id_room'];
            unset($data['id_room']);

            if($formRoom->isValid($data)){	
            	
            	
            	               if($id_room == 0 || $id_room ==''){
                    //zapis
                    $data['id_hotel']=$this->idHotel;
                    $new_id_room = $room->insert($data);

                    $sql = $confRoom->select()->where('id = ?', $data['id_configuration']);
                    $result = $confRoom->fetchRow($sql)->toArray();
                    $data['name_configuration']= $result['name_configuration'];
                            
                    $date_result = array('result_save'=>1,
                                         'data' => $data,
                                         'id_room' =>$new_id_room);
                    
                } else {
                    //edycja
                    $length_update=$room->update($data,array('id = ?' => $id_room));

                    $sql = $confRoom->select()->where('id = ?', $data['id_configuration']);
                    $result = $confRoom->fetchRow($sql)->toArray();
                    $data['name_configuration']= $result['name_configuration'];

                    $date_result = array('result_save'=>3,
                                         'data_update'=>$data,
                                         'id_room'=>$id_room);
                }
               
               


            } else {
            	$date_result = array('result_save' => 0,
            						 'error_comunicat' => $formRoom->getMessages()
                                 );
            }
            
        } else {
            $date_result = array('result_save'=> 3);
        }

            echo Zend_Json::encode($date_result);
        
    }

   //AJAX
    public function getRoomInfoAction(){

        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();


        $room = new Application_Model_DbTable_Room();

        if($this->getRequest()->isPost()){
            
            $data = $this->getRequest()->getPost();

            $id_room = (int)$data['id_room'];

            if($id_room != '' || $id_room != 0){
                //$select = $room->select(Zend_Db_Table_Abstract::SELECT_WITH_FROM_PART);
                //$select->setIntegrityCheck(false);

                $sql = $room->select()->where('id = ?', $id_room);
                $singleRoom = $room->fetchAll($sql)->toArray();

                    $date_result = array('result_save'=>1,
                                         'singleRoom' => $singleRoom);
            }


        } else {
            $date_result = array('result_save'=>'2',
                                 'error_comunicat' => 'Błąd. Wymuszenie uruchomienia'); 
        }    
        //$date_result = array('result_save'=>1);   
        echo Zend_Json::encode($date_result);
    }

    // AJAX

    public function deleteRoomAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $room = new Application_Model_DbTable_Room();
            $result = $room->delete(array('id = ?' => $data['id_room']));
            $date_result = array('result_save'=>'1');
        }

        echo Zend_Json::encode($date_result);
    }
}