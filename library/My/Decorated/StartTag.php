<?php

class My_Decorated_StartTag extends Zend_Form_Decorator_Abstract {
    protected $_format = '<div id="abc">';

    public function render($content)
    {
        $element = $this->getElement();
        $name    = htmlentities($element->getFullyQualifiedName());
        $id      = htmlentities($element->getId());
 
        $markup  = sprintf($this->_format);
        return $markup;
    }



}
?>
