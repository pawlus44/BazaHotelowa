<?php
class My_Controller_Default extends Zend_Controller_Action
{
   
    public $isLogin;
    public $whoIsLogin;
    public $infoToolbar;
    public $whichDisplayPanel;
    public $komunikat;
    public $loginName;

    public $mainPath;
    public $idUser;

     public function  preDispatch() {

        $auth = Zend_Auth::getInstance();

                if($auth->hasIdentity())
                {
                    $this->isLogin = 1;
                    $this->whoIsLogin = My_Function_GetInfoUser::getTypeOfUser($auth->getIdentity()) ;
                    $this ->idUser = My_Function_GetInfoUser::getIdUserLogin($auth->getIdentity());
                    $this->infoToolbar = 1;
                    $this->whichDisplayPanel=0;
                    $this->komunikat = "Jestem zalogowany jako: ".$auth->getIdentity();

                    $this -> loginName = $auth->getIdentity();
                }
                else
                {
                    $this->isLogin = 0;
                    $this->whoIsLogin = 0;
                    $this->infoToolbar = 1;
                    $this->whichDisplayPanel=0;
                    $this ->idUser = 0;
                    $this->komunikat = "Nie jestem zalogowany";
                }

    }



}
?>
