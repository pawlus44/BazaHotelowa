<?php

class My_Function_CheckIsLogin {

    static public function checkIsLogin(){
        $auth = Zend_Auth::getInstance();

        if($auth->hasIdentity()){

            $isLogin = 1;

        }else {
            $isLogin = 0;
        }

        return $isLogin;
    }
}
?>
