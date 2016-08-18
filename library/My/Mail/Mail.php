<?php

class My_Mail_Mail
{
    protected $_mail;
    protected $_transport;

    protected $_smtp_server  = null;
    protected $_from_email   = null;
    protected $_from_caption = null;

    protected $_config = array(
        'ssl'      => '',
        'port'     =>  0,
        'auth'     => '',
        'username' => '',
        'password' => ''
    );

    public function __construct()
    {
        $this->_transport = new Zend_Mail_Transport_Smtp($this->_smtp_server, $this->_config);
        Zend_Mail::setDefaultTransport($this->_transport);
        $this->_mail = new Zend_Mail('UTF-8');
    }

    public function send($options)
    {
        $this->_mail->setFrom($this->_from_email, $this->_from_caption);
        $this->_mail->setBodyText($options['body']);
        $this->_mail->addTo($options['to']);
        $this->_mail->setSubject($options['subject']);
        $this->_mail->send();
    }

    public function mailNewPassword($to, $password)
    {
        $this->send(array(
            'to'      => $to,
            'subject' => 'Resetowanie hasła',
            'body'    => "Oto nowe hasło w serwisie example.net\n\n{$password}\n\n"
        ));
    }

        public function mailNew($to, $message)
    {
        $this->send(array(
            'to'      => $to,
            'subject' => 'Test bazahotelowa',
            'body'    => $message
        ));
    }


}