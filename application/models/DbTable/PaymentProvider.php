<?php

class Application_Model_DbTable_PaymentProvider extends Zend_Db_Table_Abstract
{

    protected $_name = 'payment_provider';


    public function getPrefixById($id)
    {
        $rs = $this->find($id);
        if(!count($rs))
            return null;
        return $rs->current()->prefix;
    }
}

