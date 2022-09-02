<?php

namespace Omnipay\EveryPay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * {@inheritDoc}
     */
    public function isSuccessful()
    {
        // Return false to indicate that more actions are needed to complete the transaction.
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function isRedirect()
    {
        return !empty($this->data['payment_link']);
    }

    /**
     * {@inheritDoc}
     */
    public function getRedirectUrl()
    {
        return $this->data['payment_link'];
    }

    /**
     * {@inheritDoc}
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * {@inheritDoc}
     */
    public function getTransactionReference()
    {
        return $this->data['payment_reference'];
    }
}
