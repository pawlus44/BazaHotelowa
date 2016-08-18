<?php

class My_Decorated_AddTag extends Zend_Form_Decorator_Abstract {
    protected $_format = '<div class="zxb"><label for="%s">%s</label><input id="%s" name="%s" type="text" value="%s"/></div>';
    
    public function render($content)
    {
        $element = $this->getElement();
        $name    = htmlentities($element->getFullyQualifiedName());
        $label   = htmlentities($element->getLabel());
        $id      = htmlentities($element->getId());
        $value   = htmlentities($element->getValue());

        $markup  = sprintf($this->_format, $name, $label, $id, $name, $value);
        return $markup;
    }



}
?>
