<?php 
 class ManageMediaController extends My_Controller_Bookmark
{
    public function init()
    {
        $this->whichBookmark = 3; // 3 zakladka i podmenu "Zarządzanie hotelem"
        $this->mainPath = "-> Start -> Panel klienta";
        $this ->_helper->layout()->setLayout("layout_panel");
        $this->idHotel=1;
    }

    public function startAction(){

        $this->view->formHotelLogo = new Application_Form_Form_HotelLogo();
        
        $hotel = new Application_Model_DbTable_Hotel();
        $sql = $hotel->select()->where('id_hotel = ?' , $this->idHotel);
        $this->view->hotel = $hotel->fetchRow($sql);

        /* zmienne do przekazania przy każdej akcjii */
        $this->view->isLogin = $this->isLogin;
        $this->view->whoIsLogin= $this->whoIsLogin;
        $this->view->loginName = $this->loginName;
        $this->view->mainPath = $this->mainPath;
        $this->view->whichBookmark =  3;
        $this->view->idHotel = $this->idHotel;
    }

    //AJAX
    public function saveLogoAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        if($this->getRequest()->isPost()){
            //$_FILES["hotel_logo"]["name"] = 'test.jpg';
            $fileName= $_FILES["hotel_logo"]["name"];
            $upload = new Zend_File_Transfer();


            $upload_dir = APPLICATION_PATH.'/../public/hotel_media/hotel_'.$this->idHotel;

            if(!file_exists($upload_dir)){
                mkdir($upload_dir, 0777, true);
            }

            $upload->setDestination($upload_dir);
            $upload->receive();

            $hotel = new Application_Model_DbTable_Hotel();
            $len_update = $hotel->update(
                array('name_logo_file'=>$fileName),
                array('id_hotel = ?' => $this->idHotel)
                );

            $date_result = array('result_save'=>1, 
                                 'name_uploud_file' => $fileName,
                                'id' => $this->idHotel
                                 );
        }

        echo Zend_Json::encode($date_result);
    }
}
?>   