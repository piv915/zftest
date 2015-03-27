<?php
/**
 * Created by PhpStorm.
 * User: piv
 * Date: 14.03.15
 * Time: 20:14
 */

class B_Form_SubForm extends B_Form
{
    /**
     * Whether or not form elements are members of an array
     * @var bool
     */
    protected $_isArray = true;

    protected $_isDynamic = false;

    /**
     * Load the default decorators
     *
     * @return B_Form_SubForm
     */
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return $this;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('FormElements')
//                ->addDecorator('HtmlTag', array('tag' => 'dl'))
//                ->addDecorator('Fieldset')
//                ->addDecorator('DtDdWrapper');
            ;
        }
//        $this->addPrefixPath('B_Form', 'B/Form');
//        $this->addDecorator('DynamicTemplate');
        return $this;
    }

    /**
     * @return boolean
     */
    public function isDynamic()
    {
        return $this->_isDynamic;
    }

    /**
     * @param boolean $isDynamic
     */
    public function setIsDynamic($isDynamic)
    {
        $this->_isDynamic = $isDynamic;
    }

}
