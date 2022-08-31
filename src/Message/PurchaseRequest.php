<?php

namespace Omnipay\EveryPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $this->validate(
            'amount',
            'currency',
            'transactionId',
            'description',
            'returnUrl'
        );

        $request = new RequestArray();

        // Setup mandatory data
        $request->setString('account_name', $this->getAccountName($this->getCurrency()));

        $request->setDouble('amount', $this->getAmount());
        $request->setString('customer_url', $this->getReturnUrl());
        // token_agreement - this is optional in case of one-off payment
        $request->setString('order_reference', $this->getTransactionId());
        $request->setString('nonce', uniqid(true));
        $request->setTimestamp('timestamp', $this->getNow());

        // Setup Fraud Prevention data
        $request->setString('customer_ip', $this->getClientIp());

        if ($card = $this->getCard()) {
            $request->setString('email', $card->getEmail());

            $request->setString('billing_line1', $card->getBillingAddress1());
            $request->setString('billing_line2', $card->getBillingAddress2());
            $request->setString('billing_city', $card->getBillingCity());
            $request->setString('billing_postcode', $card->getBillingPostcode());
            $request->setString('billing_country', $card->getBillingCountry());

            $request->setString('shipping_line1', $card->getShippingAddress1());
            $request->setString('shipping_line2', $card->getShippingAddress2());
            $request->setString('shipping_city', $card->getShippingCity());
            $request->setString('shipping_postcode', $card->getShippingPostcode());
            $request->setString('shipping_country', $card->getShippingCountry());
        }

        return $request->getData();
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        try {
            // add api username to request data
            $data['api_username'] = $this->getUsername();

            $paymentResponse = $this->httpClient->request(
                'POST',
                sprintf("%s/payments/oneoff", $this->getEndpoint()),
                [
                    'Authorization' => 'Basic '. $this->getAuth(),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
                json_encode($data)
            );

            $response = json_decode($paymentResponse->getBody()->getContents(), true);

            if (empty($response)) {
                throw new \Exception('request failed');
            }

            if (!empty($response['error'])) {
                throw new \Exception($response['error']);
            }

            return $this->response = new PurchaseResponse($this, $response);
        } catch (\Throwable $e) {
            throw new InvalidRequestException('Failed to request purchase: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * @return \DateTime
     */
    protected function getNow()
    {
        $timestamp = new \DateTime();
        return $timestamp->setTimezone(new \DateTimeZone('Europe/Tallinn'));
    }

    /**
     * Get account name for provided currency.
     *
     * @param string $currency currency code
     * @return string
     */
    protected function getAccountName($currency)
    {
        foreach($this->getAccountNames() as $accountCurrency => $accountName) {
            if ($accountCurrency == $currency) {
                return $accountName;
            }
        }

        throw new \InvalidArgumentException("failed to find account name for currency ${currency}");
    }
}
