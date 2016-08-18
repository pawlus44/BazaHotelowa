<?php
 class PanelClientController extends My_Controller_Bookmark
{
    public function init()
    {
        $this->view->infoToolbar = 1;

        //$this->view->whichBookmark =  $this->whichBookmark; // 1 zakladka i podmenu "Twoje konto"
        $this->view->nameBookmark = 'dane konta';
        $this->mainPath = "-> Start -> Panel klienta";
        $this ->_helper->layout()->setLayout("layout_panel");
    }

    public function startAction(){


        /* zmienne do przekazania przy każdej akcjii */
         $this->view->isLogin = $this->isLogin;
         $this->view->whoIsLogin= $this->whoIsLogin;
         $this->view->loginName = $this->loginName;
         $this->view->mainPath = $this->mainPath;
         $this->view->whichBookmark =  $this->whichBookmark;
         $this->view->idHotel = $this->idHotel;

    }

    public function profilAction(){

         $table_user = new Application_Model_DbTable_User();
         $table_userInfo = new Application_Model_DbTable_UserInfo();

         $this->view->idUser = $this->idUser;


         $this->view->rowUser = My_Function_GetInfoUser::getRowId('user', $this->idUser);
         $this->view->rowUserInfo = My_Function_GetInfoUser::getRowId('user_info', $this->idUser);


         $formEditPassword = new Application_Form_Edit_Password();
         $url= $this->view->url(array('action'=>'profil'));
         $formEditPassword->setAction($url);

         $formEditUserInfo = new Application_Form_Edit_UserInfo();
         $url= $this->view->url(array('action'=>'profil'));
         $formEditUserInfo->setAction($url);

         
         if( $this->getRequest()->isPost() ){

             if($formEditPassword->isValid($this->getRequest()->getPost())){

                 $data_user = $formEditPassword->getValues();
                 $salt = sha1(date('Y-m-d H:i:s').''.My_Function_RandomPassword::randomPassword());
                 $new_password = sha1($data_user['first_password'].$salt);

                 $db_user = new Zend_Db_Table('user');
                 $many = $db_user->update(array('password'=>$new_password, 'salt'=>$salt),array('id_user = ?'=>$this->idUser));

                   if($many != 0){
                        $this->view->komunikat = "<span style='color: green'>Hasło zostało zmienione.</span>";
                        $this->view->formEditPassword = $formEditPassword;
                   }else{
                       $this->view->formEditPassword = $formEditPassword;
                        $this->view->komunikat = "<span style='color: red'>Hasło nie zostało zmienione.</span>";
                   }
             }else {
                    $this->view->formEditPassword = $formEditPassword;
                    $this->view->komunikat = "<span style='color: red'>Hasło nie zostało zmienione.</span>";
             }

         } else {
            $this->view->formEditPassword = $formEditPassword;
            $this->view->formEditUserInfo = $formEditUserInfo;
            //$this->view->komunikat = "Bez zmian";
         }


         /* zmienne do przekazania przy każdej akcjii */
         $this->view->isLogin = $this->isLogin;
         $this->view->whoIsLogin= $this->whoIsLogin;
         $this->view->loginName = $this->loginName;
         $this->view->mainPath = $this->mainPath;
         $this->view->whichBookmark =  $this->whichBookmark;
         $this->view->idHotel = $this->idHotel;

    }

    public function addressAction(){

        /* pobranie danych do wyświetlenia */
         $this->view->rowUserInfo = My_Function_GetInfoUser::getRowId('user_info', $this->idUser);
         $this->view->rowUserAddress = My_Function_GetInfoUser::getRowId('user_address', $this->idUser);
         $this->view->rowUserContact = My_Function_GetInfoUser::getRowId('user_contact', $this->idUser);

        /* formularzed do edycji */

         $this->view->formEditUserAddress = new Application_Form_Edit_UserAddress();
         $this->view->formEditUserInfo = new Application_Form_Edit_UserInfo();
         $this->view->formEditUserContact =new Application_Form_Edit_UserContact();
         
        /* zmienne do przekazania przy każdej akcjii */
         $this->view->isLogin = $this->isLogin;
         $this->view->whoIsLogin= $this->whoIsLogin;
         $this->view->loginName = $this->loginName;
         $this->view->mainPath = $this->mainPath;
         $this->view->whichBookmark =  $this->whichBookmark;
         $this->view->idHotel = $this->idHotel;

    }

    /**** USER INFO *****/

    public function  formUserInfoAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        
        $rowUserInfo = My_Function_GetInfoUser::getRowId('user_info', $this->idUser);
        $table_data = array('name' => $rowUserInfo['name'], 'surname' => $rowUserInfo['surname'] );
        
        $formEditUserInfo = new Application_Form_Edit_UserInfo();
        $formEditUserInfo -> populate($table_data);
        
        echo $formEditUserInfo;
    }
 
    public function  formUserInfoProcessAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        $isValid = 0;

        $formEditUserInfo = new Application_Form_Edit_UserInfo();

        if( $this->getRequest()->isPost()){
            if($formEditUserInfo->isValid($this->getRequest()->getPost())){

                $date = $formEditUserInfo->getValues();

                $db_user_info = new Zend_Db_Table('user_info');
                $many = $db_user_info->update(array('name' =>$date['form_user_info']['name'], 
                                                    'surname' => $date['form_user_info']['surname']),
                                              array('id_user = ?'=>$this->idUser));

            
              
                   if($many == 1){
                        $tablica = array("isValid"=>1, "form"=>0);
                   }else {
                        $tablica = array("isValid"=>0, "form"=>$formEditUserInfo->render());
                   }
            }else
            {
               $tablica = array("isValid"=>0, "form"=>$formEditUserInfo->render());
            }
        }

        $jsonObjectWithExpression = Zend_Json::encode($tablica);

        echo $jsonObjectWithExpression;

        

    }

    /**** USER ADDRESS ****/


    public function formUserAddressAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $rowUserAddress = My_Function_GetInfoUser::getRowId('user_address', $this->idUser);
        $table_data = array('city'     =>   $rowUserAddress['city'],
                            'street'   =>   $rowUserAddress['street'],
                            'no_bulid' =>   $rowUserAddress['number_bulid'],
                            'no_local' =>   $rowUserAddress['number_local'],
                            'zip_code' =>   $rowUserAddress['code_post'],
                            'post'     =>   $rowUserAddress['post'],
                           'country'  =>   $rowUserAddress['country']
            );

        $formEditUserAddress = new Application_Form_Edit_UserAddress();
        $formEditUserAddress -> populate($table_data);

        echo $formEditUserAddress;
    }



    public function formUserAddressProcessAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        $isValid = 0;

        $formEditUserAddress = new Application_Form_Edit_UserAddress();

        if( $this->getRequest()->isPost()){
            if($formEditUserAddress->isValid($this->getRequest()->getPost())){
                
                $date = $formEditUserAddress->getValues();
                $db_user_address = new Zend_Db_Table('user_address');
                $many = $db_user_address -> update(
                            array('city'         =>   $date['form_user_address']['city'],
                                  'street'       =>   $date['form_user_address']['street'],
                                  'number_bulid' =>   $date['form_user_address']['no_bulid'],
                                  'number_local' =>   $date['form_user_address']['no_local'],
                                  'code_post'    =>   $date['form_user_address']['zip_code'],
                                  'post'         =>   $date['form_user_address']['post'],
                                  'country'      =>   $date['form_user_address']['country']),
                            array('id_user = ?'  =>   $this->idUser));
                
                   if($many == 1){
                        $table = array("isValid"=>1, "form"=>0);
                   }else {
                        $table = array("isValid"=>0, "form"=>$formEditUserAddress->render());
                   }           


            }else{
                $table = array("isValid"=>0, "form"=>$formEditUserAddress->render());
            }
         }


        $jsonObjectWithExpression = Zend_Json::encode($table);
        echo $jsonObjectWithExpression;


    }
  


//****  USER CONTACT ******/////

   public function formUserContactAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $rowUserContact = My_Function_GetInfoUser::getRowId('user_contact', $this->idUser);
        $table_data = array('telephone'     =>   $rowUserContact['telephone'],
                            'email_alter'   =>   $rowUserContact['email'],
            );

        $formEditUserContact = new Application_Form_Edit_UserContact();
        $formEditUserContact -> populate($table_data);

        echo $formEditUserContact;
    }


    public function formUserContactProcessAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();
        $isValid = 0;

        $formEditUserContact = new Application_Form_Edit_UserContact();

        if( $this->getRequest()->isPost()){
            if($formEditUserContact->isValid($this->getRequest()->getPost())){
                
                $date = $formEditUserContact->getValues();
                $db_user_contact = new Zend_Db_Table('user_contact');
                $many = $db_user_contact -> update(
                            array('telephone'         =>   $date['form_user_contact']['telephone'],
                                  'email'       =>   $date['form_user_contact']['email_alter']),
                            array('id_user = ?'  =>   $this->idUser));
                
                   if($many == 1){
                        $table = array("isValid"=>1, "form"=>0);
                   }else {
                        $table = array("isValid"=>0, "form"=>$formEditUserContact->render());
                   }           


            }else{
                $table = array("isValid"=>0, "form"=>$formEditUserContact->render());
            }
         }


        $jsonObjectWithExpression = Zend_Json::encode($table);
        echo $jsonObjectWithExpression;


    }
  
}
?>
