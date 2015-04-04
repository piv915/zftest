<?php

class Application_Model_DbTable_CurrencyClass extends Zend_Db_Table_Abstract
{
    const INTERNAL = 1;
    const REAL = 2;
    const ELECTRONIC = 3;

    protected $_name = 'currency_class';


}

