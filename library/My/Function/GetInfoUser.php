<?php
class My_Function_GetInfoUser {

    public function getIdUser($nazwa)
    {
      $db = new Application_Model_DbTable_User();

      $sql = $db->select('id_user')->where('login = ?', $nazwa);
      $r = $db->fetchRow($sql);
      $id_user = $r['id_user'];
      return (int)$id_user;
    }

    public function getIdUser2($name_column,$value)
    {
      $db = new Application_Model_DbTable_User();

      $zakres=array(
          $name_column,
          $value);
      
      $sql = $db->select('id_user')->where('? = ?', $zakres );
      $r = $db->fetchRow($sql);
      $id_user = $r['id_user'];
      return (int)$id_user;
    }

    static public function getIdUserLogin($nazwa)
    {
      $db = new Application_Model_DbTable_User();

      $sql = $db->select('id_user')->where('login = ?', $nazwa);
      $r = $db->fetchRow($sql);
      $id_user = $r['id_user'];
      return (int)$id_user;
    }

    public function getIdUserEmail($nazwa)
    {
      $db = new Application_Model_DbTable_User();

      $sql = $db->select('id_user')->where('email = ?', $nazwa);
      $r = $db->fetchRow($sql);
      $id_user = $r['id_user'];
      return (int)$id_user;
    }

    static public function getTypeOfUser($name_user)
    {
        $db = new Application_Model_DbTable_User();
        $sql = $db->select('id_type_of_user')->where('login = ?', $name_user);
        $r = $db->fetchRow($sql);
        $typeOfUser = $r['id_type_of_user'];
        return (int)$typeOfUser;
    }

    static public function getRowId($table_name, $id_user){
        $db = new Zend_Db_Table($table_name);
        $sql = $db->select()->where('id_user = ?', $id_user);
        return $db->fetchRow($sql);
    }

    static public function checkAdminHotel($id_user){
        $db_adminToHotel = new Application_Model_DbTable_AdminToHotel();
        $sql = $db_adminToHotel->select()->where('id_user = ?', $id_user);
        $dateATH = $db_adminToHotel->fetchRow($sql);
        if($dateATH == null){
            return false;
        } else {
            return true;
        }  

    }
}

?>
