<?php

class Application_Form_Form_Test extends Zend_Form
{

    public function init()
    {
            //$filters_1 = array('StringTrim','StripNewlines');

        $this->setMethod('post');
   /*     $view=Zend_Layout::getMvcInstance()->getView();

        $url = $view ->url(array('controller'=>'auth','action'=>'processregistrationform'));
        $this->setAction($url);
*/
/////////////////////////// KONTROLKA NAZWA UŻYTKOWNIKA
        $my_decorator = new My_Decorated_AddTag();
        $my_decorator_1 = new My_Decorated_EndTag();
        
        $this->addElement(
         'text',
         'username',
                array(
                      //'allowEmpty' => rt,
                      'label'=>'Login:',
                      'required'=>true,
                      'filters'=>array('StringTrim','StripNewlines'),
                      'validators'=>array(
                            array('NotEmpty',true),
                            array('Db_NoRecordExists',true,array('table'=>'user','field'=>'login')),
                            array('StringLength',true, array('min'=>1,'max'=>32))
                      )
                    //,'decorators'=>array($my_decorator)
                    )
                );

        $this->username->getValidator('NotEmpty')->setMessages(array(
        Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));

        $valcorrect= new My_Validators_CorrectValue();
        $this->username->addValidator($valcorrect);

        $this->username->getValidator('Db_NoRecordExists')->setMessages(
                array(Zend_Validate_Db_NoRecordExists::ERROR_RECORD_FOUND =>
                    "Login już istnieje. Użyj innego"));
        $this->username->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość podanego loginu.",
            Zend_Validate_StringLength::TOO_SHORT => "Podany login jest zbyt krótki.
                Login musi zawierać od 8 do 32 znakow",
            Zend_Validate_StringLength::TOO_LONG => "Podany login  jest zbyt długi.
                Login musi zawierać od 8 do 32 znakow")
                );
        $this->username->getValidator('My_Validators_CorrectValue')->setMessages(
                array(My_Validators_CorrectValue::NOT_CONTENT_DIGITS =>
                    "Podany login nie zawiera wymaganej jednej cyfry ",
                      My_Validators_CorrectValue::NOT_CONTENT_HUGE_LETTER =>
                    "Podany login nie zawiera wymaganej jednej dużej litery",
                      My_Validators_CorrectValue::NOT_CONTENT_SMALL_LETTER =>
                    "Podany login nie zawiera wymaganej jednej małej litery"
                    ));



    

//////////////////////////////  KONTROLA E-MAIL


        $this->addElement(
         'text',
         'email',
                array(
                      'label'=>'E-mail użytkownika:',
                      'required'=>true,
                      'filters'=>array('StringTrim','StripNewlines'),
                       'validators'=>array(
                             array('NotEmpty',true),
                             array('EmailAddress',true),
                             array('StringLength',true, array('min'=>6,'max'=>128)),
                             array('Db_NoRecordExists',false,array('table'=>'user','field'=>'email')),
                             array('StringLength',true, array('min'=>6,'max'=>128)),
                        )));

        $this->email->getValidator('NotEmpty')->setMessages(array(
        Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));

        $this->email->getValidator('Db_NoRecordExists')->setMessages(array(
            Zend_Validate_Db_NoRecordExists::ERROR_RECORD_FOUND =>
            "Email już istnieje. Jeśli nie pamiętasz hasła skorzystajz przywracania hasła",
        ));

    $this->email->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość podanego loginu.",
            Zend_Validate_StringLength::TOO_SHORT => "Podany login jest zbyt krótki.
                Login musi zawierać od 6 do 128 znakow",
            Zend_Validate_StringLength::TOO_LONG => "Podany login  jest zbyt długi.
                Login musi zawierać od 6 do 128 znakow")
                );

    $this->email->getValidator('EmailAddress')->setMessages(array(
            Zend_Validate_EmailAddress::INVALID_FORMAT=>"Podany adres e-mail jest niepoprawny."
    ));
/////////////////////////// KONTROLKA HASŁO
        $this->addElement (
                'password',
                'first_password',
                array(
                    'label'=>'Hasło:',
                    'required'=>true,
                    'filters'=>array('StringTrim','StripNewlines'),
                    'validators'=>array(
                        array('NotEmpty',true),
                        array('StringLength',true, array('min'=>8,'max'=>128)))
                )
                );

            $this->first_password->getValidator('NotEmpty')->setMessages(array(
            Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));

            $this->first_password->getValidator('StringLength')->setMessages(array(
            Zend_Validate_StringLength::INVALID =>"Niepoprawna długość podanego hasła.",
            Zend_Validate_StringLength::TOO_SHORT => "Podane hasło jest zbyt krótkie.
                Hasło musi zawierać od 8 do 128 znaków",
            Zend_Validate_StringLength::TOO_LONG => "Podane hasło jest zbyt długie.
                Hasło musi zawierać od 8 do 128 znaków")
                );

///////////////////////////// SPRAWDZENIE POPRAWNOŚCI HASŁA
        $this->addElement (
                'password',
                'second_password',
                array(
                    'label'=>'Powtórz hasło:',
                    'required'=>true,
                    'filters'=>array('StringTrim','StripNewlines'),
                    'validators'=>array(
                        array('NotEmpty',true)
                )));

        $this->second_password->getValidator('NotEmpty')->setMessages(array(
        Zend_Validate_NotEmpty::IS_EMPTY=>"Pole obowiązkowe"));

        $confpassword= new My_Validators_PasswordConfirmation();
        $this->second_password->addValidator($confpassword,true, array('first_password'));



    }



}

