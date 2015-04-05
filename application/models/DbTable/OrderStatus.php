<?php

class Application_Model_DbTable_OrderStatus extends Zend_Db_Table_Abstract
{

    const NEW_ORDER = 'NEW';
    const DONE = 'DONE';

    protected $_name = 'order_status';

    public function getIdBySysName($sysName)
    {
        return $this->fetchRow($this->select()->where('sysid = ?', $sysName))->id;
    }
}
