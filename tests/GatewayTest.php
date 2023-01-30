<?php

namespace Omnipay\EveryPay\Tests;

use Omnipay\EveryPay\Gateway;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var Gateway
     */
    public $gateway;

    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setUsername('merchant');
        $this->gateway->setSecret('secret');
        $this->gateway->setAccounts(array(
            array(
                'name' => 'euro-account-name',
                'currency' => 'EUR'
            )
        ));
        $this->gateway->setTestMode(true);
    }

    public function testGateway()
    {
        $this->assertSame('merchant', $this->gateway->getUsername());
        $this->assertSame('secret', $this->gateway->getSecret());
        $this->assertSame(array(
            array(
                'name' => 'euro-account-name',
                'currency' => 'EUR'
            )
        ), $this->gateway->getAccounts());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase();
        $this->assertInstanceOf('Omnipay\EveryPay\Message\PurchaseRequest', $request);
    }

    public function testCompletePurchase()
    {
        $request = $this->gateway->completePurchase();
        $this->assertInstanceOf('Omnipay\EveryPay\Message\CompletePurchaseRequest', $request);
    }
}
