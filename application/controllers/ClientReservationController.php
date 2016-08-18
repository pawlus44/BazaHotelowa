<?php class ClientReservationController extends My_Controller_Bookmark{
    public function init(){
        $this->whichBookmark = 4; 
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
         $this->view->whichBookmark =  4;
         $this->view->idHotel = $this->idHotel;
    }

    public function reservationsAction(){

        $reservation = new Application_Model_DbTable_Reservation();
        $select = $reservation->select();
        $select->setIntegrityCheck(false);

        $sql = $select -> from('reservation as r')
                       -> joinLeft('user_info as ui', 'r.id_user = ui.id_user')
                       -> where('r.id_user = ?', $this->idUser)
                       -> order(array('r.date_add'));

        $this->view->listReservation = $reservation -> fetchAll($sql);
        $this->view->list_status = array(  0 => 'brak',
                                            1 => 'zgłoszony - oczekuje na potwierdzenie',
                                            2 => 'rezerwacja potwierdzona',
                                            3 => 'rezerwacja anulowana przez administratora');

        /* zmienne do przekazania przy każdej akcjii */
         $this->view->isLogin = $this->isLogin;
         $this->view->whoIsLogin= $this->whoIsLogin;
         $this->view->loginName = $this->loginName;
         $this->view->mainPath = $this->mainPath;
         
        if($this->idHotel){
            $this->view->whichBookmark =  2;
        } else {
            $this->view->whichBookmark =  4;
        } 
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

            $this->view->id_reservation= $data['id_reservation'];
        }

    }   
   
}
 