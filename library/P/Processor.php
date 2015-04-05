<?php

abstract class P_Processor
{
    abstract public function handleSuccess();

    abstract public function handleError();

    abstract public function getPaymentMethods();

    abstract public function buildRedirectForm(Application_Model_Order $order, $currencyId);
}
