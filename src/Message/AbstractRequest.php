<?php

namespace Omnipay\EveryPay\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{

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
     * Get merchant account names.
     *
     * @return array account names
     */
    public function getAccountNames()
    {
        return $this->getParameter('accountNames');
    }

    /**
     * Set merchant account names.
     *
     * @param array $value account names
     *
     * @return $this
     */
    public function setAccountNames($value)
    {
        return $this->setParameter('accountNames', $value);
    }

    /**
     * Get merchant auth header.
     *
     * @return string
     */
    protected function getAuth()
    {
        return base64_encode( $this->getUsername().":".$this->getSecret());
    }

}
