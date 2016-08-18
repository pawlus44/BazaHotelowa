<?php
class Application_Form_Edit_UserAddress extends Zend_Form
{
    public function init()
    {
         $form_user_adddress = new Application_Form_Subform_UserAddress();
         $this->addSubForm($form_user_adddress, 'form_user_address');

          
          /* $button_label = 'Zmień dane';
           $this->addElement(
                'button',
                'button_change_useraddress',
                array(
                    'label'=>$button_label,
                    'reguired'=>true,
                    'class'=>'text-5'
                )
           );
           *
           *
           * <button name="button_change_useraddress" id="button_change_useraddress" type="button" reguired="1" class="text-5">Zmień dane</button>
           */

    }
}
?>