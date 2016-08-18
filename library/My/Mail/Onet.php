
<?php

class My_Mail_Onet extends My_Mail_Mail
{
    protected $_smtp_server  = 'smtp.poczta.onet.pl';
    protected $_from_email   = 'pawelpor@op.pl';
    protected $_from_caption = 'Administrator serwisu bazahotelowa.net';

    protected $_config = array(
        'ssl'      => 'tls',
        'port'     => 465,
        'auth'     => 'login',
        'username' => 'pawelpor@op.pl',
        'password' => 'rybna1'
    );

}