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

        $this->addElement(new Zend_Form_Element_Select(self::CATEGORY, [
            'multiOptions' => [1 => 'Hello', 2 => 'Goodbye'],
            'validators'   => [ 'Alnum', 'Govnum' ]
        ]));
//        $phoneGroup = new B_Form_Element_Group();
//
//        $phoneGroup->addElement(new Zend_Form_Element_Text(self::PHONE, [
//            'validators' => ['Digits'],
//            'required'   => true,
//        ]));
//        $phoneGroup->addElement('checkbox', 'chbx', [ 'multiOptions' => [ 'OK', 'NotOK' ]]);
//        $phoneGroup->addElement('multiCheckbox', 'mchbx', [ 'multiOptions' => [ 'OK', 'NotOK' ]]);
//
//        $this->addCollection($phoneGroup, self::PHONE, [
//            'dynamic' => true,
//            'count' => 2,
//            'create_template' => true
//        ]);

//        $attributesSchema = [
//            1 => ['Radio', 'Catering', [ 'multiOptions' => [ 1 => 'v1', 2 => 'v2' ] ]],
//            2 => ['Radio', 'Children',  [ 'multiOptions' => [ 1 => 'v1', 2 => 'v2' ] ]],
//            3 => ['Text', 'Comment',  []],
//            4 => ['Checkbox', 'Wifi',  []],
//            5 => ['MultiCheckbox', 'Cuisine',  [ 'multiOptions' => [ 1 => 'v1', 2 => 'v2' ] ]],
//            6 => ['Select', 'Parking',  [  'multiOptions' => [ 5 => 'v5', 7 => 'v7']  ]]
//
//        ];
//        $attributes = new B_Form_Element_Attributes([
//            'schema' => $attributesSchema
//        ]);
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

