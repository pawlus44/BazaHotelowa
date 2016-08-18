<?php
class My_Function_Db {
    public static function madeParis($data_object, $key, $value ){
        $data = array();

        foreach ($data_object as $row) {
            $data[$row[$key]] = $row[$value]; 
        }

        return $data;
    }

}
?>
