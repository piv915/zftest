<?php

class K_Db_Table extends Zend_Db_Table_Abstract
{
    public function fetchFromSelect(Zend_Db_Table_Select $select)
    {
        $rs = $this->fetchAll($select);
        $rs = $rs->toArray();
        return $rs;
    }
}
