<?php
class Zend_View_Helper_SingleHotel extends Zend_View_Helper_Abstract{

        public function singleHotel(){
        	return $this->view->render('partialViews/singleHotel.phtml');
        }

    }


?>
