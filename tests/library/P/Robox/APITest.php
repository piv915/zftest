<?php

class P_Robox_APITest extends PHPUnit_Framework_TestCase
{
    /*
     * @var P_Robox_API
     */
    private $api;

    public function setUp()
    {
        $this->api = new P_Robox_API();
    }

    public function testGetCurrencies()
    {
        $result = $this->api->getCurrencies();
        $this->assertArrayHasKey('EMoney', $result);
    }

    public function testGetPaymentMethods()
    {
        $result = $this->api->getPaymentMethods();
        $this->assertArrayHasKey('EMoney', $result);
    }

    public function testGetRatesAll()
    {
        $result = $this->api->getRates(100, null);
        $this->assertArrayHasKey('YandexMerchantOceanR', $result);
        $this->assertArrayHasKey('ElecsnetWalletR', $result);
    }

    public function testGetRatesOne()
    {
        $result = $this->api->getRates(100, 'YandexMerchantOceanR');
        $this->assertArrayHasKey('YandexMerchantOceanR', $result);
        $this->assertArrayNotHasKey('ElecsnetWalletR', $result);
    }

    public function testOpState()
    {
        $operationId = 1;
        $result = $this->api->opState($operationId);
        $this->assertArrayHasKey('code', $result);
        $this->assertArrayHasKey('request_date', $result);
        $this->assertArrayHasKey('state_date', $result);
        $this->assertArrayHasKey('in', $result);
        $this->assertArrayHasKey('out', $result);
    }
}
