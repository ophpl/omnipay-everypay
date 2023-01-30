<?php

namespace Omnipay\EveryPay\Tests\Message;

use Omnipay\EveryPay\Message\CompletePurchaseRequest;
use Omnipay\EveryPay\Message\PurchaseRequest;
use Omnipay\Tests\TestCase;

class CompletePurchaseRequestTest extends TestCase
{
    /**
     * @var CompletePurchaseRequest
     */
    private $request;

    public function setUp(): void
    {
        parent::setUp();
        $httpRequest = $this->getHttpRequest();
        $httpRequest->initialize(array(
            'payment_reference' => '1fe1dbfc5710f3ce3b11e80f4559fd31095c6c06bd79b799bf5b92c93f1d70c4'
        ));
        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('1fe1dbfc5710f3ce3b11e80f4559fd31095c6c06bd79b799bf5b92c93f1d70c4', $data['payment_reference']);
    }

    public function testSendData()
    {
        $this->setMockHttpResponse('CompletePurchaseSuccess.txt');
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertInstanceOf('Omnipay\EveryPay\Message\CompletePurchaseResponse', $response);
        $this->assertSame(true, $response->isSuccessful());
    }
}
