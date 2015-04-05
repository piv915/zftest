<?php

class Application_Model_DbTable_PsRoboxCurrency extends Zend_Db_Table_Abstract
{

    protected $_name = 'ps_robox_currency';

    public function getMarks()
    {
        $select = $this->select()
            ->from($this->_name, ['id', 'mark']);
        return $this->fetchAll($select)->toArray();
    }
}
