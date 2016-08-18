<?php
class Application_Form_Edit_UserContact extends Zend_Form
{

    public function init()
    {
         $form_user_contact = new Application_Form_Subform_UserContact();
         $this->addSubForm($form_user_contact, 'form_user_contact');
    }
}
?>
