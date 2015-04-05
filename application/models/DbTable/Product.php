<?php

class Application_Model_DbTable_Product extends Zend_Db_Table_Abstract
{

    protected $_name = 'product';

    public function getAllonSale()
    {
        $result = [];

        $select = $this->getAdapter()->select();
        $select->from($this->_name, 'id')
            ->where('onsale >= ?', 1);

        $rows = $this->getAdapter()->fetchAll($select);
        foreach ($rows as $row) {
            $product = new Application_Model_Product($row['id']);
            $result[] = $product;
        }
        return $result;
    }
}
