<?php

namespace Omnipay\EveryPay\Tests\Message;

use Omnipay\EveryPay\Message\PurchaseRequest;
use Omnipay\EveryPay\Message\PurchaseResponse;
use Omnipay\Tests\TestCase;

class PurchaseResponseTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    protected $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testRedirect()
    {
        $response = new PurchaseResponse(
            $this->request,
            array(
                'payment_link' => 'https://payment-link.com/smth',
                'payment_reference' => 'payment-ref-hash',
            )
        );

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isCancelled());
        $this->assertFalse($response->isPending());
        $this->assertTrue($response->isRedirect());
        $this->assertNull($response->getCode());
        $this->assertNull($response->getMessage());
        $this->assertNull($response->getTransactionId());
        $this->assertSame('payment-ref-hash', $response->getTransactionReference());
        $this->assertSame('https://payment-link.com/smth', $response->getRedirectUrl());
        $this->assertSame('GET', $response->getRedirectMethod());
        $this->assertEmpty($response->getRedirectData());
    }
}
