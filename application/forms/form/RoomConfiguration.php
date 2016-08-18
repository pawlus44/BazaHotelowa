<?php

class Application_Form_Form_RoomConfiguration extends Zend_Form
{
    public function init()
    {
        $this->setOptions(array('id'=>'configuration_room'));

        $this->setMethod('post');

        $this->addElement(
             'text',
             'name_configuration',
                  array(
                        'label'=>'Nazwa konfiguracji pokoju:',
                        'required'=>true,
                        'filters'=>array('StringTrim','StripNewlines'),
                        'validators'=>array(
                             array('StringLength',true, array('min'=>5,'max'=>255)),
                        )));

        // Tylko liczba!!!
        
        // select albo radio button - bardziej select
        $this->addElement(
             'radio',
             'bathroom_in_room',
                  array(
                        'label'=>'Dostępność łazienki:',
                        'required'=>true,
                        'validators'=>array(
                            array('NotEmpty',true)
                            ),
                        'multiOptions' =>  array(
                            'yes' =>  'Tak',
                            'no'  =>  'Nie'
                            )
                        ));
        
        
        $db = new Application_Model_DbTable_EquipmentRoom();
        $sql = $db->select();
        $available_equipment = $db->fetchAll($sql);
        
        //$available_equipment = My_Function_Db::madeParis($available_equipment,'id','name');

        $this->addElement(
            'multicheckbox',
            'equipment_room',
            array(
                'label' =>  'Wyposażenie pokoju:',
                'multiOptions' => My_Function_Db::madeParis($available_equipment,'id','name')
            )

        ); 


    }
}

