<?php

class Application_Model_DbTable_Currency extends K_Db_Table
{

    protected $_name = 'currency';

    public function getPaymentMethodsForProvider($providerId)
    {
        $select = $this->select()->from($this->_name);
        $select
            ->where('active = ? ', 1)
            ->where('provider_id = ? ', $providerId);
        $data = $this->fetchFromSelect($select);
        return $data;
    }
}
