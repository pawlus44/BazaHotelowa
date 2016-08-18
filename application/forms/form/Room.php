<?php

class Application_Form_Form_Room extends Zend_Form
{
 
    public function init()
    {
        $this->setOptions(array('id'=>'room_details'));

        $this->setMethod('post');
    }

    public function addMyElementForm($id_hotel){
       $this->addElement(
             'text',
             'name_room',
                  array(
                        'label'=>'Oznaczenie pokoju:',
                        'required'=>true,
                        'filters'=>array('StringTrim','StripNewlines'),
                        'validators'=>array(
                             array('StringLength',true, array('min'=>1,'max'=>60)),
                        )));

        $roomConfiguration = new Application_Model_DbTable_ConfigurationRoom();
        $sql = $roomConfiguration
                ->select()
                ->from('configuration_rooms',array('id','name_configuration'))
                ->where('id_hotel = ?',$id_hotel);
        $list_room_conf['test']= 'wybierz';

        foreach ($roomConfiguration->fetchAll($sql) as $row) {
           $list_room_conf[$row->id]=$row->name_configuration;
        }
      
        $this->addElement(
            'select',
            'id_configuration',
             array('label' =>'Typ konfiguracji',
                    'required'=>true,
                    'multiOptions' => $list_room_conf,
                    'validators'=>array(
                             array('Digits', true)
                    ))
          );

        $this->addElement(
             'text',
             'price_per_person',
                  array(
                        'label'=>'Cena za os.:',
                        'required'=>true,
                        'filters'=>array('StringTrim','StripNewlines'),
                        'validators'=>array(
                             array('NotEmpty',true),
                             array('Digits', true)
                        )));

        $this->addElement(
             'text',
             'price_per_room',
                  array(
                        'label'=>'Cena za pokój:',
                        'required'=>true,
                        'filters'=>array('StringTrim','StripNewlines'),
                        'validators'=>array(
                             array('NotEmpty',true),
                             array('Digits', true)
                        )));


        $this->addElement(
             'textarea',
             'description_room',
                  array(
                        'label'=>'Opis pokoju:',
                        'required'=>false,
                        'filters'=>array('StringTrim','StripNewlines'),
                        'validators'=>array(
                             array('StringLength',true, array('min'=>0,'max'=>1000)),
                        )));
        $this->getElement('description_room')->setAttribs(array('rows'=>5));

         $this->addElement(
             'text',
             'number_bad',
                  array(
                        'label'=>'Ilość łóżek:',
                        'required'=>true,
                        'filters'=>array('StringTrim','StripNewlines'),
                        'validators'=>array(
                             array('NotEmpty',true),
                             array('Digits', true)
                        )));

    }
}

