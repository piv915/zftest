<?php
/**
 * Created by PhpStorm.
 * User: piv
 * Date: 15.03.15
 * Time: 1:04
 */

class B_Form_Element_DependentSelect extends Zend_Form_Element_Select
{
    private $_parent;
    private $_dataSource;

    public function isValid($value, $context = null)
    {
        $parentValue = $this->_parent->getValue();
        if(isset($this->_dataSource[$parentValue]))
            $this->setMultiOptions($this->_dataSource[$parentValue]);
        return parent::isValid($value, $context);
    }

    public function setParent($options)
    {
        $this->_parent = $options;
    }

    public function setDataSource($options)
    {
        $this->_dataSource = $options;
        if(is_array($options)) {
            reset($options);
            $this->setMultiOptions(current($options));
        }
    }

}
