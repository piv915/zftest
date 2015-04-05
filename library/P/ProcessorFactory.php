<?php

class P_ProcessorFactory
{
    public function __construct()
    {

    }

    /**
     * @param $controller
     * @return P_Processor
     * @throws Exception
     * @throws Zend_Db_Table_Exception
     */
    public function createProcessor(Zend_Controller_Action $controller)
    {
        $providerId = $controller->getParam('pp', 0);

        $model = new Application_Model_DbTable_PaymentProvider();
        $rowSet = $model->find($providerId);

        if (!count($rowSet)) {
            throw new Exception('Unknown payment provider');
        }

        $row = $rowSet->current();
        $class = 'P_' . ucfirst($row->prefix) . '_Processor';
        return new $class();
    }
}
