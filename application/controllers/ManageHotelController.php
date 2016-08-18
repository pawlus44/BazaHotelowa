<?php 
 class ManageHotelController extends My_Controller_Bookmark
{
    public function init()
    {
        $this->whichBookmark = 3; // 3 zakladka i podmenu "Zarządzanie hotelem"
        $this->mainPath = "-> Start -> Panel klienta";
        $this ->_helper->layout()->setLayout("layout_panel");
        $this->idHotel=1;
    }

    public function startAction(){
        $labeStatusHotel = array('0' => "<span class='on_status'>wyłączony z publikacji</span>",
                                 '1' => "<span class='public_status'>opublikowany</span>",
                                 '2' => "<span class='on_status'>wyłączony z publikacji</span>"
                                 );

        $data =  My_Function_Hotel::validateDataHotel($this->idHotel);
        $this->view->statusHotel = $labeStatusHotel[$data['dataHotel']['hotel_info']['status']];
        $this->view->error_status = 0;   
        
        if($this->getRequest()->isPost()){
            $dataPost = $this->getRequest()->getPost();

            $hotel = new Application_Model_DbTable_Hotel();
            

            if($dataPost['status_hotel'] != 1 || count($data['errors']) == 0){
                $hotel -> update(array('status'=>$dataPost['status_hotel']),
                                 array('id_hotel = ?' => $this->idHotel)); 
                $this->view->statusHotel = $labeStatusHotel[$dataPost['status_hotel']];
            } else {
                $this->view->statusHotel = $labeStatusHotel['2'];
                $this->view->error_status = 1;
            }
        }

               
        $this->view->dataHotel = $data['dataHotel'];
        $this->view->errorList = $data['errors'];
        $this->view->warningsList = $data['warnings'];
      
        $this->view->formStatus = new Application_Form_Form_StatusHotel();



        /* zmienne do przekazania przy każdej akcjii */
         $this->view->isLogin = $this->isLogin;
         $this->view->whoIsLogin= $this->whoIsLogin;
         $this->view->loginName = $this->loginName;
         $this->view->mainPath = $this->mainPath;
         $this->view->whichBookmark =  3;
         $this->view->idHotel = $this->idHotel;
    }

    public function hotelAction(){
        $hotelInformation = new Application_Form_Edit_HotelInformation();
        $hotelDescription = new Application_Form_Edit_HotelDescription();
        $hotel = new Application_Model_DbTable_Hotel();
        $hotelAddress = new Application_Model_DbTable_HotelAddress();

        if($this->getRequest()->isPost()){
            
            if($hotelInformation->isValid($this->getRequest()->getPost()) ){
                // sprawdzenie czy update czy insert
                $dataHotelInformation = $hotelInformation->getValues();
                if( My_Function_GetInfoHotel::checkExistHotel($this->idHotel,'hotel_address') ){
                    ///updatecik

                    $resultUpdate = $hotelAddress
                                    ->update(
                                        array(
                                        'city' => $dataHotelInformation['city'],
                                        'street' => $dataHotelInformation['street'],
                                        'number_bulid' => $dataHotelInformation['number_bulid'],
                                        'code_post' => $dataHotelInformation['zip_code'],
                                        'post' => $dataHotelInformation['post'],
                                        'country' => $dataHotelInformation['country']
                                        ), 
                                    array('id_hotel = ?' => $this->idHotel ));
                } else {
                    $data =  array(
                            'id_hotel' => $this->idHotel,
                            'city' => $dataHotelInformation['city'],
                            'street' => $dataHotelInformation['street'],
                            'number_bulid' => $dataHotelInformation['number_bulid'],
                            'number_local' => $dataHotelInformation['number_bulid'],
                            'code_post' => $dataHotelInformation['zip_code'],
                            'post' => $dataHotelInformation['post'],
                            'country' => $dataHotelInformation['country']);
                    $resultSelect = $hotelAddress->insert($data);
                }
            }
            
            if( $hotelDescription -> isValid($this->getRequest()->getPost()) )
            {
                $dataHotelDescription = $hotelDescription->getValues();
                $dataHotelInformation = $hotelInformation->getValues();
                if( My_Function_GetInfoHotel::checkExistHotel($this->idHotel,'hotel') ){
                    ///updatecik
                    $resultUpdate = $hotel->update(array(
                        'name_hotel' => $dataHotelInformation['name_hotel'],
                        'basic_description_hotel' => $dataHotelDescription['basic_description_hotel'],
                        'extend_description_hotel' => $dataHotelDescription['extend_description_hotel'],
                        'id_type_of_hotel' =>$dataHotelInformation['type_of_hotel'],
                        'nip' => $dataHotelInformation['nip']
                        ),
                    array('id_hotel = ?' => $this->idHotel ));
                }
            }
        }
            
        $select = $hotel->select()->where('id_hotel = ?', $this->idHotel);
        $hotelData = $hotel->fetchRow($select);

        $select = $hotelAddress->select()->where('id_hotel = ?', $this->idHotel);
        $hotelAddressData = $hotelAddress -> fetchRow($select);

        $hotelDataForm = array('name_hotel' => $hotelData['name_hotel'],
                               'type_of_hotel' => $hotelData['id_type_of_hotel'],
                               'nip' => $hotelData['nip'],
                               'city' => $hotelAddressData['city'],
                               'street' => $hotelAddressData['street'],
                               'number_bulid' => $hotelAddressData['number_bulid'],
                               'zip_code' => $hotelAddressData['code_post'],
                               'post' => $hotelAddressData['post'],
                               'country' => $hotelAddressData['country']
                                );

        $hotelDescriptionDataForm = array(
                                'basic_description_hotel' => $hotelData['basic_description_hotel'],
                                'extend_description_hotel' => $hotelData['extend_description_hotel']
                                );

        //$this->view->testData = $dataHotelInformation['post'];
        $this->view->hotelInformation = $hotelInformation->populate($hotelDataForm);
        $this->view->hotelDescription = $hotelDescription->populate($hotelDescriptionDataForm);
               
        /* zmienne do przekazania przy każdej akcjii */
         $this->view->isLogin = $this->isLogin;
         $this->view->whoIsLogin= $this->whoIsLogin;
         $this->view->loginName = $this->loginName;
         $this->view->mainPath = $this->mainPath;
         $this->view->whichBookmark =  3;
         $this->view->idHotel = $this->idHotel;
    }

}
?>   