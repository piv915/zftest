<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $factory = new P_ProcessorFactory();
        $processor = $factory->createProcessor($this);

        $paymentMethods = $processor->getPaymentMethods(1);
    }

    protected function updateCurrencyList()
    {
        $factory = new P_ProcessorFactory();
        $processor = $factory->createProcessor($this);
        $processor->updateCurrencyList();
    }

    public function convertAction()
    {

    }
}

