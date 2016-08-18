<?php
class My_Function_GetRow
{
    public function getRow($nameTable, $nameId, $idValue)
    {
        $db = null;

        
        switch($nameTable)
        {
            case 'user':
            {
                 $db = new Application_Model_DbTable_User();
                 break;
            }
            case 'user_info':
            {
                 $db = new Application_Model_DbTable_UserInfo();
                 break;
            }
            case 'user_address':
            {
                 $db = new Application_Model_DbTable_UserAddress();
                 break;
            }
            case 'user_contact':
            {
                 $db = new Application_Model_DbTable_UserContact();
                 break;
            }
        }

        switch($nameId)
        {
            case 'id_user':
            {
                $sql = $db->select()->where('id_user = ?', $idValue);
                break;
            }
        }

        $row= $db->fetchRow($sql)->toArray();
        


       return $row;
    }


}
?>
