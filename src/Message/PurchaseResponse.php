<?php

namespace Omnipay\EveryPay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return !empty($this->data['payment_link']);
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->data['payment_link'];
    }

    /**
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * @return array
     */
    public function getRedirectData()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getSessionId()
    {
        return isset($this->data['sid']) ? $this->data['sid'] : null;
    }
}
