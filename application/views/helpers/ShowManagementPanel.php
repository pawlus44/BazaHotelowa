<?php
class Zend_View_Helper_ShowManagementPanel extends Zend_View_Helper_Abstract{

        public function showManagementPanel($showPanel){
            if($showPanel == 1){ // show panel managment client
                return $this->view->render('partialViews/clientPanel.phtml');
                
            } elseif ($showPanel == 2) { // show panel managment admin hotel
                return $this->view->render('partialViews/adminPanel.phtml');
            }

        }

    }


?>
