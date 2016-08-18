<?php
class My_Function_ActivationLink {
    static public function  generateLink()
    {

    }

    static public function encrypt($message)
    {
        $encrypted = base64_encode($message);
        return $encrypted;
    }

    static public function decrypt($message)
    {
        $encrypted  = base64_decode($message);
        return $encrypted;
    }

    public function createLink( $urlAction , $text = 'brak')
    {
        $link = $code = ' ';
        $code = $this->encrypt($text);

        $link = $urlAction.'/'.'active_account/'.$code;

        return $link;
    }

}
?>
