<?php
/**
 * Created by PhpStorm.
 * User: piv
 * Date: 14.03.15
 * Time: 23:23
 */

class B_Form_Element_Attributes extends B_Form_Element_Group
{
    private $_elementSchema;

    private $_template;

    public function init()
    {
        $this->_template = new B_Form_Element_Group();

        $selectOptions = [];
        foreach ($this->_elementSchema as $attributeId => $def) {
            $class = 'Zend_Form_Element_'.$def[0];
            $opt = array_merge($def[2], [ 'label' => $def[1] ]);
            $element = new $class('attribute'.$attributeId, $opt);
            $element->removeDecorator('Label');
            $element->removeDecorator('Description');
            $this->_template->addElement($element);
            $selectOptions[$attributeId] = $def[1];
        }
        $selector = new B_Form_Element_AttributeSelector('selector', [
            'multiOptions' => $selectOptions
        ]);
        $selector->removeDecorator('Label');
        $selector->removeDecorator('Description');

        $this->_template->addElement($selector);

        $this->createEmptyRow();

        // add one row
//        $selector = clone $selector;
////           $selector->setValue(3);
//        $row = $this->createRow($selector);
//        $this->addCollection($row, 'data');
        //$selector->setName('zzz');
//        $selector->
        //$this->addElement($selector);
        $this->addDataRow(3);
        $this->addDataRow(5);
    }

    public function setSchema($data)
    {
        $this->_elementSchema = $data;
    }

    protected function getDependentItem($selector)
    {
        $attributeId = $this->getSelectValue($selector);

        $e = $this->_template->getElement('attribute'.$attributeId);

        return clone $e;
    }

    /**
     * @param $selectorValue
     */
    protected function addDataRow($selectorValue)
    {
        $selector = clone $this->_template->getElement('selector');
        $selector->setValue($selectorValue);
        $options  = $selector->getMultiOptions();

        $collection = $this->getCollection('data');

        $excludeIds = [];
        foreach ($collection as $elementGroup) {
            $groupSelector = $elementGroup->getElement('selector');
            $val = $this->getSelectValue($groupSelector);

            $excludeIds[] = $val;
        }

        if(in_array($selectorValue, $excludeIds)) {
            // TODO: throw
            null;
        }

        $newOptions = [];
        foreach ($options as $id => $name) {
            if(!in_array($id, $excludeIds))
                $newOptions[$id] = $name;
        }

        $selector->setMultiOptions($newOptions);
        $selector->setValue($selectorValue);
        $input = $this->getDependentItem($selector);

        $items = count($collection);
        $newName = 'data['.$items.']';
//        $group = clone $subForm;
        $row = $this->createRow($selector);
        $this->addSubForm($row, $newName);
    }

    /**
     * @param $selector
     * @return mixed
     */
    protected function getSelectValue($selector)
    {
        $attributeId = $selector->getValue();
        if (is_null($attributeId)) {
            $o = $selector->getMultiOptions();
            $attributeId = array_keys($o)[0];
            return $attributeId;
        }
        return $attributeId;
    }

    /**
     * @param $selector
     * @return B_Form_Element_Group
     * @throws Zend_Form_Exception
     */
    protected function createRow($selector)
    {
        $row = new B_Form_Element_Group();

        $row->addElement($selector);
        $inputElement = $this->getDependentItem($selector);
        $row->addElement($inputElement);
        //$row->remo
        //var_dump($selector->getDecorators());
//        $row->setElementDecorators(['ViewHelper', 'Errors', array('HtmlTag', array('tag' => 'dd'))]);

        return $row;
    }

    public function isValid($data)
    {
        $this->rebuildDataCollection($data);
        parent::isValid($data);
    }

    protected function rebuildDataCollection($data)
    {
        $this->cleanRows();

        if(is_array($data['attributes']['data']))
        {
            foreach ($data['attributes']['data'] as $item) {
                $selectorValue = isset($item['selector']) ? (int)$item['selector'] : 0;
                if($selectorValue && array_key_exists('attribute'.$selectorValue, $item))
                {
                    echo 'kva-kva2';
                    $this->addDataRow($selectorValue);
                }
            }
        }

        $rowsCount = $this->getRowsCount();
        if(!$rowsCount) {
            echo 'kva-kva3';
            $this->createEmptyRow();
        }
    }

    protected function createEmptyRow()
    {
        $selector = clone $this->_template->getElement('selector');
        $row = $this->createRow($selector);
        $this->addCollection($row, 'data');
    }

    /**
     *
     *
     */
    protected function cleanRows()
    {
        $rows = $this->getSubForms();
        foreach ($rows as $row) {
            $rowName = $row->getName();
            if (preg_match('/^data/', $rowName))
                $this->removeSubForm($rowName);
        }
    }

    /**
     * @return integer
     */
    protected function getRowsCount()
    {
        $rowsCount = 0;
        $rows = $this->getSubForms();
        foreach ($rows as $row) {
            $name = $row->getName;
            if(preg_match('/^data/', $name))
                ++$rowsCount;
        }

        return $rowsCount;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        $template = clone $this->_template;
        $template->addDecorator(new B_Form_Decorator_DynamicTemplate());
        $template->setName($this->getName());
        return $template;
    }

}
