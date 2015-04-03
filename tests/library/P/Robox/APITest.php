<?php

class P_Robox_APITest extends PHPUnit_Framework_TestCase
{
    /*
     * @var P_Robox_API
     */
    private $o;

    public function setUp()
    {
        $this->o = new P_Robox_API();
    }

    public function testGetCurrencies()
    {
        $result = $this->o->getCurrencies();
        $this->assertArrayHasKey('EMoney', $result);
    }

    public function testGetPaymentMethods()
    {
        $result = $this->o->getPaymentMethods();
        $this->assertArrayHasKey('EMoney', $result);
    }

    public function testGetRatesAll()
    {
        $result = $this->o->getRates(100, null);
        $this->assertArrayHasKey('YandexMerchantOceanR', $result);
        $this->assertArrayHasKey('ElecsnetWalletR', $result);
    }

    public function testGetRatesOne()
    {
        $result = $this->o->getRates(100, 'YandexMerchantOceanR');
        $this->assertArrayHasKey('YandexMerchantOceanR', $result);
        $this->assertArrayNotHasKey('ElecsnetWalletR', $result);
    }

    public function testOpState()
    {
        $result = $this->o->opState(1);
        $this->assertArrayHasKey('code', $result);
        $this->assertArrayHasKey('request_date', $result);
        $this->assertArrayHasKey('state_date', $result);
        $this->assertArrayHasKey('in', $result);
        $this->assertArrayHasKey('out', $result);
    }

}
