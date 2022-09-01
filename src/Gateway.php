<?php

namespace Omnipay\EveryPay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\EveryPay\Message\PurchaseRequest;
use Omnipay\EveryPay\Message\CompletePurchaseRequest;

/**
 * Class Gateway
 * https://support.every-pay.com/merchant-support/api/
 * https://support.every-pay.com/downloads/everypay_apiv4_integration_documentation.pdf
 * @package Omnipay\EveryPay
 */
class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'EveryPay';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'endpoint' => 'https://pay.every-pay.eu/api/v4',
            'username' => '',
            'secret'   => '',
            'accounts' => array(),
            'testMode' => false
        );
    }

    /**
     * Get API endpoint.
     *
     * @return string endpoint
     */
    public function getEndpoint()
    {
        return $this->getParameter('endpoint');
    }

    /**
     * Set API endpoint.
     *
     * @param string $value endpoint
     *
     * @return $this
     */
    public function setEndpoint($value)
    {
        return $this->setParameter('endpoint', $value);
    }

    /**
     * Get merchant username.
     *
     * @return string username
     */
    public function getUsername()
    {
        return $this->getParameter('username');
    }

    /**
     * Set merchant username.
     *
     * @param string $value username
     *
     * @return $this
     */
    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }

    /**
     * Get merchant secret.
     *
     * @return string secret
     */
    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    /**
     * Set merchant secret.
     *
     * @param string $value secret
     *
     * @return $this
     */
    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    /**
     * Get merchant accounts.
     *
     * @return array{name: string, currency: string} array of accounts
     */
    public function getAccounts()
    {
        return $this->getParameter('accounts');
    }

    /**
     * Set merchant accounts.
     *
     * @param array{name: string, currency: string} $value array of accounts
     *
     * @return $this
     */
    public function setAccounts($value)
    {
        return $this->setParameter('accounts', $value);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractRequest|PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\EveryPay\Message\PurchaseRequest', $parameters);
    }

}
