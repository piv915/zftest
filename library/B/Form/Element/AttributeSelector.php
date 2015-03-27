<?php
/**
 * Created by PhpStorm.
 * User: piv
 * Date: 15.03.15
 * Time: 15:39
 */

class B_Form_Element_AttributeSelector extends Zend_Form_Element_Select
{
    public function isValid($value, $context = null)
    {
        if($value < 1)
            return false;
        if(!array_key_exists('attribute'.$value, $context))
            return false;

//        $schema = (new B_Shared_Attributes_SchemaProvider())->getSchema();

        return parent::isValid($value, $context);
    }
}
