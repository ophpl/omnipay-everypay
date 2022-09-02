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
     * Get merchant accounts.
     *
     * @return array{name: string, currency: string} accounts
     */
    public function getAccounts()
    {
        return $this->getParameter('accounts');
    }

    /**
     * Set merchant accounts.
     *
     * @param array{name: string, currency: string} $value accounts
     *
     * @return $this
     */
    public function setAccounts($value)
    {
        return $this->setParameter('accounts', $value);
    }

    /**
     * Get locale.
     *
     * @return string locale
     */
    public function getLocale()
    {
        return $this->getParameter('locale');
    }

    /**
     * Set locale.
     *
     * @param string $value locale
     *
     * @return $this
     */
    public function setLocale($value)
    {
        return $this->setParameter('locale', $value);
    }

    /**
     * Get language, if not set fallback to locale.
     *
     * @return string language
     */
    public function getLanguage()
    {
        $language = $this->getParameter('language');

        if (empty($language)) {
            $locale = $this->getLocale();

            if (empty($locale)) {
                return "";
            }

            // convert to IETF locale tag if other style is provided and then get first part, primary language
            $language = strtok(str_replace('_', '-', $locale), '-');
        }

        return strtolower($language);
    }

    /**
     * Set language.
     *
     * @param string $value language
     *
     * @return $this
     */
    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    /**
     * Get merchant auth header.
     *
     * @return string
     */
    protected function getAuth()
    {
        return base64_encode($this->getUsername().":".$this->getSecret());
    }
}
