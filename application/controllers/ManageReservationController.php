<?php 
 class ManageReservationController extends My_Controller_Bookmark
{
    public function init(){
        $this->whichBookmark = 2; // 3 zakladka i podmenu "Zarządzanie hotelem"
        $this->mainPath = "-> Start -> Panel klienta";
        $this ->_helper->layout()->setLayout("layout_panel");
        $this->idHotel=1;
    }

    public function indexAction(){
        /* zmienne do przekazania przy każdej akcjii */
         $this->view->isLogin = $this->isLogin;
         $this->view->whoIsLogin= $this->whoIsLogin;
         $this->view->loginName = $this->loginName;
         $this->view->mainPath = $this->mainPath;
         $this->view->whichBookmark =  2;
         $this->view->idHotel = $this->idHotel;
    }

    public function currentReservationsAction(){

        $reservation = new Application_Model_DbTable_Reservation();
        $select = $reservation->select();
        $select->setIntegrityCheck(false);

        $sql = $select -> from('reservation as r')
                       -> joinLeft('user_info as ui', 'r.id_user = ui.id_user')
                       -> where('r.status = ?',2)
                       -> where('r.id_hotel = ?', $this->idHotel)
                       -> where('date_start <= ?', date('Y-m-d'))
                       -> where('date_stop >= ?', date('Y-m-d'));

       $this->view->listReservation = $reservation -> fetchAll($sql);


        /* zmienne do przekazania przy każdej akcjii */
         $this->view->isLogin = $this->isLogin;
         $this->view->whoIsLogin= $this->whoIsLogin;
         $this->view->loginName = $this->loginName;
         $this->view->mainPath = $this->mainPath;
         $this->view->whichBookmark =  2;
         $this->view->idHotel = $this->idHotel;
    }

    public function waitingReservationsAction(){

        $reservation = new Application_Model_DbTable_Reservation();
        $select = $reservation->select();
        $select->setIntegrityCheck(false);

        $sql = $select -> from('reservation as r')
                       -> joinLeft('user_info as ui', 'r.id_user = ui.id_user')
                       -> where('r.status = ?',1)
                       -> where('r.id_hotel = ?', $this->idHotel);

       $this->view->listReservation = $reservation -> fetchAll($sql);

        

        /* zmienne do przekazania przy każdej akcjii */
         $this->view->isLogin = $this->isLogin;
         $this->view->whoIsLogin= $this->whoIsLogin;
         $this->view->loginName = $this->loginName;
         $this->view->mainPath = $this->mainPath;
         $this->view->whichBookmark =  2;
         $this->view->idHotel = $this->idHotel;
    }

    public function confirmedReservationsAction(){
        $reservation = new Application_Model_DbTable_Reservation();
        $select = $reservation->select();
        $select->setIntegrityCheck(false);

        $sql = $select -> from('reservation as r')
                       -> joinLeft('user_info as ui', 'r.id_user = ui.id_user')
                       -> where('r.status = ?',2)
                       -> where('r.id_hotel = ?', $this->idHotel);

       $this->view->listReservation = $reservation -> fetchAll($sql);


        /* zmienne do przekazania przy każdej akcjii */
         $this->view->isLogin = $this->isLogin;
         $this->view->whoIsLogin= $this->whoIsLogin;
         $this->view->loginName = $this->loginName;
         $this->view->mainPath = $this->mainPath;
         $this->view->whichBookmark =  2;
         $this->view->idHotel = $this->idHotel;
    }

    public function archiveReservationsAction(){

        $reservation = new Application_Model_DbTable_Reservation();
        $select = $reservation->select();
        $select->setIntegrityCheck(false);

        $sql = $select -> from('reservation as r')
                       -> joinLeft('user_info as ui', 'r.id_user = ui.id_user')
                       -> where('r.status = ?',2)
                       -> where('r.id_hotel = ?', $this->idHotel)
                       -> where('date_stop < ?', date('Y-m-d'))
                       -> orWhere('status = ?', 3);

       $this->view->listReservation = $reservation -> fetchAll($sql);


        /* zmienne do przekazania przy każdej akcjii */
         $this->view->isLogin = $this->isLogin;
         $this->view->whoIsLogin= $this->whoIsLogin;
         $this->view->loginName = $this->loginName;
         $this->view->mainPath = $this->mainPath;
         $this->view->whichBookmark =  2;
         $this->view->idHotel = $this->idHotel;
    }  

    //AJAX
    public function getRoomReservationAction(){
        $this->_helper->layout->disableLayout();

        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();

            $reservationRoom = new Application_Model_DbTable_RoomReservation();
            $select = $reservationRoom->select();
            $select->setIntegrityCheck(false);

            $sql= $select -> from('reservation_room as rr')
                          -> joinLeft('rooms as rs',
                                      'rr.id_room = rs.id')
                          -> where('rr.id_reservation = ?', $data['id_reservation'])
                          -> order(array('rs.name_room ASC'));
            $this->view->info_list = $reservationRoom->fetchAll($sql);
            
            $statusForm = new Application_Form_Form_StatusReservation();
            $statusForm->setStatus($data['status_reservation']);
            $this->view->statusForm = $statusForm;

            $this->view->id_reservation= $data['id_reservation'];
        }

    }   

    //AJAX
    public function setStatusReservationAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();


        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();

            $reservation =new Application_Model_DbTable_Reservation();
            $len = $reservation
                    -> update(array('status' => $data['status_reservation']),
                              array('id_reservation = ?' => $data['id_reservation'])
                       );


        }

    }   
}
?>   