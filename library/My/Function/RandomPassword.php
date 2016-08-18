<?php
class My_Function_RandomPassword
{
    public static function randomPassword()
    {
        $password = '';
        for($i = 0; $i < 10; $i++)
        {
            $password .= chr(rand(ord('a'),ord('z')));
        }
        
        return $password;
    }
}

?>
