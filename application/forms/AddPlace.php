<?php

class Application_Form_AddPlace extends B_Form
{
    const TITLE = 'title';
    const CATEGORY = 'category';
    const SUBCATEGORY = 'subcategory';
    const COUNTRY = 'country';
    const CITY = 'city';
    const PHONE = 'phone';
    const ATTRIBUTES = 'attributes';
    const IMAGE = 'image';
    const SUBMIT = 'submit';

    public function init()
    {
        $this->setMethod('post');
        $this->addElement(new Zend_Form_Element_Text(self::TITLE, array(

        )));

//        $categoryTwoLevel = [
//            'first' => [1 => 'Hello', 2 => 'Goodbye'],
//            'second' => [
//                1 => [ 5 => 'Freddi', 6 => 'Johnatan' ],
//                2 => [ 18 => 'Baby' ]
//            ]
//        ];
//        $this->addElement(new Zend_Form_Element_Select(self::CATEGORY, [
//            'multiOptions' => $categoryTwoLevel['first'],
//        ]));
//
//        $this->addElement(new B_Form_Element_DependentSelect(self::SUBCATEGORY, [
//            'parent' => $this->getElement(self::CATEGORY),
//            'dataSource'   => $categoryTwoLevel['second']
//        ]));

        $phoneGroup = new B_Form_Element_Group();

        $phoneGroup->addElement(new Zend_Form_Element_Text(self::PHONE, [
            'validators' => ['Digits'],
            'required'   => true,
        ]));
//        $phoneGroup->addElement('checkbox', 'chbx', [ 'multiOptions' => [ 'OK', 'NotOK' ]]);
//        $phoneGroup->addElement('multiCheckbox', 'mchbx', [ 'multiOptions' => [ 'OK', 'NotOK' ]]);

        $this->addCollection($phoneGroup, self::PHONE, [
            'dynamic' => true,
            'count' => 2,
            'create_template' => true
        ]);


        $attributes = new B_Form_Element_Attributes([
            'schema' => (new B_Shared_Attributes_SchemaProvider())->getSchema()
        ]);
        $this->addSubForm($attributes, self::ATTRIBUTES);
//        $this->addCollection($attributes, self::ATTRIBUTES, [
//
//        ]);
//        $this->addElement(new Zend_Form_Element_File(self::IMAGE, array(
//
//        )));
//
        $this->addElement(new Zend_Form_Element_Submit(self::SUBMIT,array(

        )));

    }


}

