<?php

class AuthUserController extends My_Controller_Default
{

    public function init()
    {
        //$this->view->infoToolbar = 0;
        $this->mainPath = "-> Start ";
    }

    public function registerUserFormAction()
    {
        $formRegister = new Application_Form_Form_Register();
        $url= $this->view->url(array('action'=>'register-user-form-process'));
        $formRegister->setAction($url);
        $this->view->formRegister = $formRegister;

        /* zmienne przekazywane standardowo*/
        $this->view->mainPath = $this->mainPath." -> Rejestracja użytkownika";
    }

    public function registerUserFormProcessAction(){
        $formRegister = new Application_Form_Form_Register();

        if($this->isLogin == 0){

           if($this->getRequest()->isPost()){
                if($formRegister->isValid($this->getRequest()->getPost())){

                    /// ZABEZPIECZENIE przed napisaniem
                    

                    $db_user = new Application_Model_DbTable_User();
                    $data_user = $formRegister->getSubForm('form_user')->getValues();

                    if(My_Function_GetInfoUser::getIdUserLogin($data_user['form_user']['username']) == 0){

                        $db_user_address = new Application_Model_DbTable_UserAddress();
                        $db_user_info = new Application_Model_DbTable_UserInfo();
                        $db_user_contact = new Application_Model_DbTable_UserContact();

                        $data_address = $formRegister->getSubForm('form_user_address')->getValues();
                        $data_info = $formRegister->getSubForm('form_user_info')->getValues();
                        $data_contact = $formRegister->getSubForm('form_user_contact')->getValues();

                        $salt = sha1(date('Y-m-d H:i:s').''.My_Function_RandomPassword::randomPassword());

                        $data_to_save = array('login' => $data_user['form_user']['username'],
                                              'password' => sha1($data_user['form_user']['first_password'].$salt),
                                              'email' => $data_user['form_user']['email'],
                                              'salt' => $salt,
                                              'id_type_of_user' => 1);

                        $last_id_user = $db_user -> insert($data_to_save);

                        if($last_id_user ){
                            $data_to_save_address = array(
                                'id_user' => $last_id_user,
                                'city' => $data_address['form_user_address']['city'],
                                'street' => $data_address['form_user_address']['street'],
                                'number_bulid' => $data_address['form_user_address']['no_bulid'],
                                'number_local' => $data_address['form_user_address']['no_local'],
                                'code_post' => $data_address['form_user_address']['zip_code'],
                                'post' => $data_address['form_user_address']['post'],
                                'country' => $data_address['form_user_address']['country'],
                            );

                            $data_to_save_info = array(
                                'id_user' => $last_id_user,
                                'name' => $data_info['form_user_info']['name'],
                                'surname' => $data_info['form_user_info']['surname']
                            );

                            $data_to_save_contact = array(
                                'id_user' => $last_id_user,
                                'telephone' =>$data_contact['form_user_contact']['telephone'],
                                'email' => $data_contact['form_user_contact']['email_alter']
                            );


                            $last_id_user = $db_user_address -> insert($data_to_save_address);
                            $last_id_user = $db_user_info -> insert($data_to_save_info);
                            $last_id_user = $db_user_contact -> insert($data_to_save_contact);

                            $this->view->komunikat = "<span class='message_ok'>Użytkownik został zarejestrowany pomyślnie.</span><br>
                            Użyj formularza do logowania aby zalogować się do serwisu";

                            $this->view->isRegisterOk=1;
                        }


                    }else
                    {
                          $this->view->komunikat = "<span class='message_ok'>Użytkownik został zarejestrowany pomyślnie.</span><br>
                            Użyj formularza do logowania aby zalogować się do serwisu";
                          $this->view->isRegisterOk=1;
                    }
                } else
                {
                    $this->view->formRegister = $formRegister;
                    $this->view->komunikat = "<span style='color:red;'>Użytkownik nie został zarejestrowany. <br>
                        Uzupełnij wymagane dane.</span>";
                    $this->view->isRegisterOk=0;
                }
           } else {
               $this->view->komunikat = "Błąd.";
           }
        } else {

                    $this->view->komunikat = "<span style='color:red;'>Nie można dodać konta gdy jesteś już zalogowany.</span>";
                    $this->view->isRegisterOk=1;

        }



               /* zmienne przekazywane standardowo*/
        $this->view->mainPath = $this->mainPath." -> Rejestracja użytkownika";

    }

    public function loginFormAction(){
        if($this->isLogin == 0){
            $loginForm = new Application_Form_Form_LoginUser();
            $url = $this->view->url(array('action'=>'login-form-process'));
            $loginForm->setAction($url);

            $this->view->loginForm = $loginForm;
        } else {
            $this->view->isLogin = 1;
            $this->view->hasHotel = My_Function_GetInfoUser::checkAdminHotel($this->idUser);
            $this->view->whoIsLogin = $this->whoIsLogin;
            $this->view->komunikat ="";// "<span class='message_ok'>Użytkownik jest już zalogowany.</span>";
            $this->view->loginName = $this->loginName;
        }

        /* zmienne przekazywane standardowo*/
        $this->view->mainPath = $this->mainPath." -> Logowanie";
    }

    public function loginFormProcessAction(){

        if($this->getRequest()->isPost() && $this->isLogin == 0){
          
                $loginForm = new Application_Form_Form_LoginUser();

                if($loginForm->isValid($this->getRequest()->getPost())){
                    $adapter = new Zend_Auth_Adapter_DbTable(
                            null,
                            'user',
                            'login',
                            'password',
                            'SHA1(CONCAT(?, salt))'
                            );

                    $adapter->setIdentity($loginForm->getSubForm('subform_login')->getValue('username'));
                    $adapter->setCredential($loginForm->getSubForm('subform_login')->getValue('password'));

                    $auth = Zend_Auth::getInstance();
                    $result = $auth->authenticate($adapter);

                    if( $auth->hasIdentity() ){
                       $this->view->komunikat = "<span style='color:green'>Zalogowano pomyślnie.</span>";
                       $this->view->isLogin = 1;
                       $this->view->loginName = $auth->getIdentity();

                       $typeOfUser = My_Function_GetInfoUser::getTypeOfUser
                       ($loginForm->getSubForm('subform_login')->getValue('username'));


                        $this->view->whoIsLogin = $typeOfUser;



                    } else {
                        $this->view->komunikat = "<span style='color:red;'>Nie zalogowano.
                            <br>Nie znaleziono użytkownika lub podano błędne hasło!</span>";
                        $this->view->loginForm=$loginForm;
                        $this->view->isLogin = 0;

                    }

                } else {
                    $this->view->loginForm=$loginForm;
                }
                
                
        } else {
            $this->view->isLogin = 1;
            $this->view->whoIsLogin = $this->whoIsLogin;
            $this->view->komunikat ="";// "<span class='message_ok'>Użytkownik jest już zalogowany.</span>";
            $this->view->loginName = $this->loginName;
        }

        /* zmienne przekazywane standardowo*/
        $this->view->mainPath = $this->mainPath." -> Logowanie";

    }

    public function loginFormProcessAjaxAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        if($this->getRequest()->isPost()){

                $loginForm = new Application_Form_Form_LoginUser();

                if($loginForm->isValid($this->getRequest()->getPost()))
                {
                    $adapter = new Zend_Auth_Adapter_DbTable(
                            null,
                            'user',
                            'login',
                            'password',
                            'SHA1(CONCAT(?, salt))'
                            );

                    $adapter->setIdentity($loginForm->getSubForm('subform_login')->getValue('username'));
                    $adapter->setCredential($loginForm->getSubForm('subform_login')->getValue('password'));

                    $auth = Zend_Auth::getInstance();
                    $result = $auth->authenticate($adapter);

                    if( $auth->hasIdentity() ){
                        //echo $this->_helper->redirector('index', 'index','default');
                        $date_result = array('result' => '1',
                                             'redirect_to' => '/auth-user/login-form');
                    } else{
                       $date_result = array('result' => '2', 
                                         'communique' => 'Nie zalogowano.<br> Nie znaleziono użytkownika lub podano błędne hasło!');
                    }

                } else {
                    $date_result = array('result' => '2', 
                                         'communique' => 'Nie zalogowano.<br>Nie znaleziono użytkownika lub podano błędne hasło!');
                }
                
                
        } else {
            $date_result = array('result' => '1',
                                 'redirect_to' => '/auth-user/login-form');
        }

        echo Zend_Json::encode($date_result);
    }

    public function logoutAction()
    {
        //$this->_helper->viewRenderer->setNoRender();

        if($this->isLogin == 1){

            $auth = Zend_Auth::getInstance();
            $flag= $auth->clearIdentity();

            if($flag==0){
                $this->view->isLogin = 0;
                $this->view->infoToolbar= 1;
                $this->view->komunikat = "<span class='message_ok'> Wylogowano z systemu.</span>";
                $this->_helper->redirector('index', 'index','default');
            } else {
                $this->view->komunikat = "<span class='message_not_ok'>Błąd. Nie wylogowano!</span>";
            }
        }

        /* zmienne przekazywane standardowo*/
        $this->view->mainPath = $this->mainPath." -> Wyloguj";


    }

    public function addHotelAction()
    {
        if($this->isLogin == 1){
            
            $db_adminToHotel = new Application_Model_DbTable_AdminToHotel();
            $sql = $db_adminToHotel->select()->where('id_user = ?', $this->idUser);
            $dateATH = $db_adminToHotel->fetchRow($sql);
            if($dateATH == null){
                $formAddHotel = new Application_Form_Form_AddHotel();
                $url = $this->view->url(array('controller' =>'auth-user','action'=>'add-hotel-process'));
                $formAddHotel->setAction($url);
                $this->view->formAddHotel = $formAddHotel;
            } else {
                 $this->view->komunikat = "<span class='message_not_ok'>Ten użytkownik zarządza już hotelem!</span>";
            }
        } else {
            $this->view->komunikat = "<span class='message_not_ok'>Usługa dostępna po zalogowaniu!</span>";
        }


        /* zmienne przekazywane przy każde akcji */
        $this->view->isLogin = $this->isLogin;
        $this->view->whoIsLogin = $this->whoIsLogin;
        $this->view->loginName = $this->loginName;
        $this->view->mainPath = $this->mainPath."-> Dodaj hotel";

    }

    public function addHotelProcessAction(){
        if($this->isLogin == 1){    

            $formAddHotel = new Application_Form_Form_AddHotel();

            // sprawdzam czy użytkownik nie obsługuje już hotelu
            $db_adminToHotel = new Application_Model_DbTable_AdminToHotel();
            
            /*$sql = $db_adminToHotel->select()->where('id_user = ?', $this->idUser);
            $dateATH = $db_adminToHotel->fetchRow($sql);*/
            if(My_Function_GetInfoUser::checkAdminHotel($this->idUser) == false){

                if($this->getRequest()->isPost()){
                    if( $formAddHotel->isValid($this->getRequest()->getPost()) ){
                         // obiekty dostępu do bazy
                        $db_hotelAddress = new Application_Model_DbTable_HotelAddress();
                        $db_hotel = new Application_Model_DbTable_Hotel();

                        // obiekty zbierające dane z formularza
                        $date_formHotelInfo = $formAddHotel->getSubForm('hotel_info')->getValues();
                        $date_formHotelAddress = $formAddHotel->getSubForm('hotel_address')->getValues();

                        // przygotowanie danych do zapisu
                        $dateToHotel = array(
                        'name_hotel'     =>$date_formHotelInfo['hotel_info']['name_hotel'],
                        'nip'            =>$date_formHotelInfo['hotel_info']['nip'],
                        'id_type_of_hotel'=> $date_formHotelInfo['hotel_info']['type_of_hotel'],
                        'public_hotel' => 2,
                        'date_add' => time(),
                        'status' => 2); // staus == 2 wylaczony z publikacji

                        // zapis do bazy
                        $lastId = $db_hotel->insert($dateToHotel);
                        $result = 1;
                        if( $lastId != 0){
                            $dateToHotelAddress = array(
                                'id_hotel' => $lastId,
                                'city' => $date_formHotelAddress['hotel_address']['city'],
                                'street' => $date_formHotelAddress['hotel_address']['street'],
                                'number_bulid'=> $date_formHotelAddress['hotel_address']['number_bulid'],
                                'code_post' => $date_formHotelAddress['hotel_address']['zip_code'],
                                'post' => $date_formHotelAddress['hotel_address']['post'],
                                'country' => $date_formHotelAddress['hotel_address']['country']);

                                $result = $db_hotelAddress -> insert($dateToHotelAddress);
                        }

                        if ($result != 0){
                            $dateAdminToHotel = array(
                                'id_user'=>$this->idUser,
                                'id_hotel'=> $lastId
                                );
                            $result = $db_adminToHotel -> insert($dateAdminToHotel);
                        } 
                         $this->view->result = $result;
                         $this->view->komunikat = "<span class='message_ok'>Dane zostały zapisane!</span>";
                         $this->view->formAddHotel = $formAddHotel;
                    } else {
                        $this->view->result = 0;
                        $this->view->formAddHotel = $formAddHotel;
                        $this->view->komunikat = "<span class='message_not_ok'>Wprowadzone dane nie spełniają wymogów!</span>";
                    }

                }



            } else {
                $this->view->result = 1;
                $this->view->komunikat = "<span class='message_not_ok'>Ten użytkownik zarządza już hotelem!</span>";
            }


        
        } else {
            $this->view->komunikat = "<span class='message_not_ok'>Usługa dostępna po zalogowaniu!</span>";
        }


                /* zmienne przekazywane przy każde akcji */
        $this->view->isLogin = $this->isLogin;
        $this->view->whoIsLogin = $this->whoIsLogin;
        $this->view->loginName = $this->loginName;
        $this->view->mainPath = $this->mainPath."-> Dodaj hotel";

    }


}

?>