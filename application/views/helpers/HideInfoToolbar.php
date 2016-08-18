<?php
    class Zend_View_Helper_HideInfoToolbar extends Zend_View_Helper_Abstract
    {
        public function hideInfoToolbar($infoToolbar, $isLogin)
        {
            if( $isLogin == 0){
            return $this->view->render('partialViews/displayInfoToolbar.phtml');
            } elseif ($infoToolbar == 1) {
                return $this->view->render('partialViews/displayInfoToolbarHotel.phtml');
            } else {

            }

        }
    }
?>
