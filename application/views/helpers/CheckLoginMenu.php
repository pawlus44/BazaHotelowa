<?php
    class Zend_View_Helper_CheckLoginMenu extends Zend_View_Helper_Abstract
    {
        public function checkLoginMenu($isLogin, $whoIsLogin)
        {
            if( $isLogin == 0){
            return $this->view->render('partialViews/isNotLoginMenu.phtml');
            } elseif ($isLogin == 1){

                if($whoIsLogin == 1){
                    return $this->view->render('partialViews/isLoginClientMenu.phtml');
                } elseif ($whoIsLogin == 2 ){
                    return $this->view->render('partialViews/isLoginManagerMenu.phtml');
                }

            } else{

            }

        }
    }
?>
