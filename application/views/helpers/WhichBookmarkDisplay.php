<?php
    class Zend_View_Helper_WhichBookmarkDisplay extends Zend_View_Helper_Abstract
    {
        public function whichBookmarkDisplay($wichBookmark)
        {
            if( $wichBookmark == 1){
                return $this->view->render('partialViews/displayBookmarkAccountInfo.phtml');
            } else if($wichBookmark == 2) {
                return $this->view->render('partialViews/displayBookmarkReservation.phtml');
            } else if($wichBookmark == 3) {
                return $this->view->render('partialViews/displayBookmarkCMSHotel.phtml');
            } else if($wichBookmark == 4) {
                return $this->view->render('partialViews/displayBookmarkClientReservation.phtml');
            }

        }
    }
?>