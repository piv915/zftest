<?php
/**
 * Created by PhpStorm.
 * User: piv
 * Date: 15.03.15
 * Time: 15:42
 */

class B_Shared_Attributes_SchemaProvider
{
    public function __construct()
    {

    }

    public function getSchema()
    {
        $attributesSchema = [
            1 => ['Radio', 'Catering', [ 'multiOptions' => [ 1 => 'v1', 2 => 'v2' ] ]],
            2 => ['Radio', 'Children',  [ 'multiOptions' => [ 1 => 'v1', 2 => 'v2' ] ]],
            3 => ['Text', 'Comment',  []],
            4 => ['Checkbox', 'Wifi',  []],
            5 => ['MultiCheckbox', 'Cuisine',  [ 'multiOptions' => [ 1 => 'v1', 2 => 'v2' ] ]],
            6 => ['Select', 'Parking',  [  'multiOptions' => [ 5 => 'v5', 7 => 'v7']  ]]

        ];
        return $attributesSchema;
    }
}
