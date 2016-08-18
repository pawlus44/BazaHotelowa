<?php
class My_Function_RegisterUser {

    public function registerUser($typeOfUser, $form_register, $url_link = null)
    {
        $form_user_data = $form_register->getSubForm('form_user')->getValues(true);
                    $salt1=sha1(time());
                    $data_insert_table_user = array(
                            'login'=>$form_user_data['username'],
                            'password'=>sha1($form_user_data['first_password'].$salt1),
                            //'password'=>$form_user_data['first_password'],
                            'email'=>$form_user_data['email'],
                            'salt'=>$salt1,
                            'id_user_of_type'=>$typeOfUser
                        );
                    $db_user = new Application_Model_DbTable_User();
                    $results = $db_user->insert($data_insert_table_user);


    //***************///////////////////////// POZOSTAŁE TABELE  //***************************//
                    /////////////////////////// DOSTĘP DO SUBFORMÓW

                    //$form_user_info_data = $form_register->getSubForm('form_user_info')->getValues(true);
                    //$form_user_contact_data = $form_register->getSubForm('form_user_contact')->getValues(true);
                    //$form_user_address_data = $form_register->getSubForm('form_user_address')->getValues(true);


                    /////////////////////////// POMOCNICZE I DODATKOWE

                    $getId = new My_Function_GetInfoUser();
                    $id_user = $getId->getIdUser($form_user_data['username']);

                    /////////////////////////// TABLICE Z DANYMI Z FORMULARZY

                    /*$data_insert_table_user_info = array(
                            'name'=>$form_user_info_data['name'],
                            'name2'=>$form_user_info_data['second_name'],
                            'surname'=>$form_user_info_data['surname'],
                            //'surname2'=>$form_user_info_data['surname2'],
                            'id_user'=>$id_user
                        );

                    $data_insert_table_user_contact = array(
                        'email'=>$form_user_contact_data['email_alter'],
                        'telephone'=>$form_user_contact_data['telephone'],
                        'id_user'=>$id_user
                    );

                    $data_insert_table_user_address = array(
                       'city'=>$form_user_address_data['city'],
                        'street'=>$form_user_address_data['street'],
                        'number_building'=>$form_user_address_data['no_bulid'],
                        'number_local'=>$form_user_address_data['no_local'],
                        'zip_code'=>$form_user_address_data['zip_code'],
                        'post'=>$form_user_address_data['post'],
                        'country'=>$form_user_address_data['country'],
                        'id_user'=>$id_user
                    );
                    */

                    //$active_code = sha1($id_user.$form_user_data['email'].$form_user_info_data['name']);
                    $active_code = sha1($id_user.'testtestTestekGracjan');
                    $active_code = $id_user.$active_code;
    
                    $data_insert_table_user_status = array(
                        'id_info_status'=>1,
                        'id_user'=>$id_user,
                        'date'=>date('Ymd'),
                        'active_code'=>$active_code
                    );

                    /////////////////////////// OBIEKTY DOSTĘPU DO BAZY DANYCH

                    //$db_user_info = new Application_Model_DbTable_UserInfo();
                    //$db_user_contact = new Application_Model_DbTable_UserContact();
                    //$db_user_address = new Application_Model_DbTable_UserAddress();
                    $db_user_status = new Application_Model_DbTable_UserStatus();

                    /////////////////////////// WSTAWIANIE DANYCH DO BAZY DANYCH

                    //$results1 =  $db_user_info->insert($data_insert_table_user_info);
                   // $results2 =  $db_user_contact->insert($data_insert_table_user_contact);
                    //$results3 =  $db_user_address->insert($data_insert_table_user_address);
                    $results4 =  $db_user_status->insert( $data_insert_table_user_status);

                    $results1=$results2=$results3=1;


                    /////////////////////////// WYSYLANIE MAILA
                    if($results1 != 0 && $results2 != 0 && $results3 !=0
                       && $results4 !=0 &&  $url_link != null){

                        
                        $activationLink = new My_Function_ActivationLink();
                        $url = $activationLink ->createLink($url_link,$active_code);

                        

                        //send-email
                        /*
                        $to = 'pawel686@vp.pl';
                        $mail = new My_Mail_Onet();
                        $mail->mailNew($to);*/


                    }

                    // tymczasowe wupubliczninie linku
                    return $url;

    }

}

?>
