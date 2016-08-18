<?php
class My_Controller_Bookmark extends Zend_Controller_Action
{
   
    public $isLogin;
    public $whoIsLogin;
    public $infoToolbar;
    public $whichDisplayPanel;
    public $komunikat;
    public $loginName;
    

    public $mainPath;
    public $whichBookmark;

    public $idUser;
    public $idHotel;

     public function  preDispatch() {

        $auth = Zend_Auth::getInstance();

                if($auth->hasIdentity())
                {
                    $this->isLogin = 1;
                    $this->whoIsLogin = My_Function_GetInfoUser::getTypeOfUser($auth->getIdentity()) ;
                    
                    $this->infoToolbar = 1;
                    $this->whichDisplayPanel=0;
                    $this->whichBookmark=1;


                    $this -> loginName = $auth->getIdentity();
                    $this->idUser = My_Function_GetInfoUser::getIdUserLogin($auth->getIdentity());
                    
                    if($this->idUser != 0){
                        $this->idHotel = My_Function_GetInfoHotel::getIdHotel($this->idUser);

                    } else {
                        $this->idHotel = 0;
                    }
                }
                else
                {
                    $this->isLogin = 0;
                    $this->whoIsLogin = 0;
                    $this->infoToolbar = 1;
                    $this->whichDisplayPanel=0;
                    $this->komunikat = "Nie jestem zalogowany";

                    return $this->_helper->redirector('login-form', 'auth-user','default');

                }

                

    }



}
?>
