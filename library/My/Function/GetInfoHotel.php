<?php

class My_Function_GetInfoHotel {

    static public function getIdHotel($id_user){
       $db = new Zend_Db_Table('admin_to_hotel');
       $sql = $db->select()->where('id_user = ?', $id_user);
       $date = $db->fetchRow($sql); 
       return $date['id_hotel'];
    }

    static public function checkExistHotel($id_hotel, $name_table){
        $db = new Zend_Db_Table($name_table);
        $sql = $db->select()->where('id_hotel = ?', $id_hotel);
        $date = $db->fetchRow($sql);

        if( count($date) != 0){
       		return 1;
        } else {
        	return 0;
        }
       
    }
}
?>