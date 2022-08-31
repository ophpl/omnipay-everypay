<?php

namespace Omnipay\EveryPay\Tests\Message;

use Omnipay\EveryPay\Message\PurchaseRequest;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    private $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array(
            'username' => 'merchant',
            'secret' => 'secret',
            'accountNames' => array(
                'EUR' => 'euro-account-name'
            ),
            'amount'        => 15.34,
            'currency'      => 'EUR',
            'transactionId' => 'T12345',
            'description'   => 'Test',
            'returnUrl'     => 'https://www.example.com/return.html',
            'card' => array(
                'email' => 'test@test.com'
            )
        ));
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('euro-account-name', $data['account_name']);
        $this->assertSame('15.34', $data['amount']);
        $this->assertSame('https://www.example.com/return.html', $data['customer_url']);
        $this->assertSame('T12345', $data['order_reference']);
        $this->assertSame('test@test.com', $data['email']);
        $this->assertNotEmpty($data['nonce']);
        $this->assertNotEmpty($data['timestamp']);
    }

    public function testSendData()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $data = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertInstanceOf('Omnipay\EveryPay\Message\PurchaseResponse', $response);
    }
}
