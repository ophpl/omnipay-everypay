<?php

namespace Omnipay\EveryPay\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getStatus() == 'settled';
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->getStatus() == 'initial';
    }

    /**
     * @return bool
     */
    public function isCancelled()
    {
        return $this->getStatus() == 'abandoned';
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->data['payment_state'] ?? null;
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->data['payment_reference'] ?? null;
    }

    /**
     * @return string
     */
    public function getTransactionReference()
    {
        return $this->data['payment_reference'] ?? null;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->getStatus();
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return isset($this->data['processing_error']) && isset($this->data['processing_error']['message']) ? $this->data['processing_error']['message'] : null;
    }

}
