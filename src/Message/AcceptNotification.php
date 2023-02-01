<?php

namespace Omnipay\EveryPay\Message;

use Omnipay\Common\Exception\RuntimeException;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\ResponseInterface;

class AcceptNotification extends AbstractRequest implements NotificationInterface
{

    protected $data;

    /**
     * Initialize the object with parameters, and try to parse the notification payload.
     *
     * If any unknown parameters passed, they will be ignored.
     * If payload was parsed correctly and signature is valid, then response will contain the parsed payload data.
     *
     * @param array $parameters An associative array of parameters
     *
     * @return $this
     * @throws RuntimeException
     */
    public function initialize(array $parameters = array())
    {
        parent::initialize($parameters);

        $request = [
            'event_name' => $this->httpRequest->get('event_name'),
            'payment_reference' => $this->httpRequest->get('payment_reference'),
        ];

        if (!empty($request['payment_reference'])) {
            $paymentResponse = $this->httpClient->request(
                'GET',
                sprintf("%s/payments/%s", $this->getEndpoint(), $request['payment_reference']),
                [
                    'Authorization' => 'Basic ' . $this->getAuth(),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ]
            );

            $response = json_decode($paymentResponse->getBody()->getContents(), true);

            if (!empty($response) && empty($response['error'])) {
                $this->data = $response;
            }
        }

        return $this;
    }

    /**
     * Get the raw data array for this message.
     * The raw data is from the notification payload.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * There is nothing to send in order to response to this webhook.
     * The merchant site just needs to return a HTTP 200.
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionReference()
    {
        return $this->data['payment_reference'] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionStatus()
    {
        return match ($this->getCode()) {
            'initial', 'sent_for_processing', 'waiting_for_sca', 'waiting_for_3ds_response' => NotificationInterface::STATUS_PENDING,
            'settled' => NotificationInterface::STATUS_COMPLETED,
            'failed', 'abandoned', 'voided' => NotificationInterface::STATUS_FAILED,
            'refunded', 'chargebacked' => NotificationInterface::STATUS_FAILED,
            default => NotificationInterface::STATUS_FAILED,
        };
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    protected function getCode()
    {
        return $this->data['payment_state'] ?? null;
    }

}
