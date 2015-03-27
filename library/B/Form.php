<?php

/**
 * Created by PhpStorm.
 * User: piv
 * Date: 14.03.15
 * Time: 17:28
 */
class B_Form extends Zend_Form
{
    protected $_collections;

    /**
     * @param B_Form_Element_Group $subForm
     * @param $name string
     * @param array $options
     */
    public function addCollection(B_Form_Element_Group $subForm, $name, array $options=null)
    {
        $count = isset($options['count']) ? intval($options['count']) : 1;
        for($i=0; $i < $count; $i++) {
            $newName = $name.'['.$i.']';
            $group = clone $subForm;
            if (isset($options['dynamic']) && $options['dynamic'] && $i==0) {
                $group->addPrefixPath('B_Form', 'B/Form');
                $group->addDecorator('DynamicTemplate');
                //if(isset($options['create_template']))
            }
            $this->addSubForm($group, $newName);
        }
        if(!is_array($this->_collections))
            $this->_collections = [];
        $this->_collections[$name] = $options;
    }

    /**
     * @param $name string
     * @return null|array B_Form_Element_Group
     */
    public function getCollection($name)
    {
        $result = [];
        if(!array_key_exists($name, $this->_collections)) {
            return null;
        }
        foreach($this->_subForms as $name => $subForm) {
            $matchPosition = strpos($name, '[');
            if(!$matchPosition)
                continue;

            $collectionName = substr($name, 0, $matchPosition);
            if(!$collectionName == $name)
                continue;

            $result[] = $subForm;
        }
        return $result;
    }

    /**
     * @param array $data
     * @return bool
     * @throws Zend_Form_Exception
     */
    public function isValid($data)
    {
        $this->expandDynamicCollections($data);
        return parent::isValid($data);
    }

    /**
     * @param array $defaults
     * @return B_Form
     */
    public function setDefaults(array $defaults)
    {
        $this->expandDynamicCollections($defaults);
        return parent::setDefaults($defaults);
    }

    /**
     * @param $data
     */
    protected function expandDynamicCollections($data)
    {
        if(is_array($this->_collections))
        foreach ($this->_collections as $name => $collOptions)
            if (isset($collOptions['dynamic']) && $collOptions['dynamic']) {
                $collection = $this->getCollection($name);
                $lastIndex = array_pop(array_keys($collection));

                $lastDataIndex = 0;
                if(is_array($data) && isset($data[$name]))
                    $lastDataIndex = array_pop(array_keys($data[$name]));

                if ($lastDataIndex > $lastIndex) {
                    $subFormTemplate = $collection[0];
                    for ($i = $lastIndex + 1; $i <= $lastDataIndex; $i++) {
                        $newName = $name . '[' . $i . ']';
                        $this->addSubForm(clone $subFormTemplate, $newName);
                    }
                }
            }
    }
    /**
     * Load the default decorators
     *
     * @return Zend_Form
     */
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return $this;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('FormElements')
                ->addDecorator('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form'))
                ->addDecorator('Form');
        }

//        $this->addPrefixPath('B_Form', 'B/Form');
//        $this->addDecorator('DynamicTemplate');

        return $this;
    }
}
