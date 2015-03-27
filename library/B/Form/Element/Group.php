<?php
/**
 * Created by PhpStorm.
 * User: piv
 * Date: 14.03.15
 * Time: 19:21
 */

class B_Form_Element_Group extends B_Form_SubForm
{
    /**
     * Set group name
     *
     * @param  string $name
     * @return B_Form
     * @throws Zend_Form_Exception
     */
    public function setName($name)
    {
        $name = $this->filterName($name, true);
        if ('' === (string)$name) {
            require_once 'Zend/Form/Exception.php';
            throw new Zend_Form_Exception('Invalid name provided; must contain only valid variable characters and be non-empty');
        }

        return $this->setAttrib('name', $name);
    }
}
