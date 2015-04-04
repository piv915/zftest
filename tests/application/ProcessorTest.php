<?php

class P_Robox_ProcessorTest extends PHPUnit_Framework_TestCase
{
    /*
     * @var P_Robox_Processor
     */
    private $proc;

    public function setUp()
    {
        $this->proc = new P_Robox_Processor();
    }

    public function testUpdateCurrencies()
    {
        $this->proc->updateCurrencyList();
    }
}
