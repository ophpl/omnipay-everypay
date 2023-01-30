<?php

namespace Omnipay\EveryPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class CompletePurchaseRequest extends AbstractRequest
{
    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $data = $this->httpRequest->query->all();

        if (!isset($data['payment_reference'])) {
            throw new InvalidRequestException('missing payment reference');
        }

        return array(
            'payment_reference' => $data['payment_reference'],
        );
    }

    /**
     * @param array $data
     *
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        try {
            $params = array(
                'api_username' => $this->getUsername(),
            );

            $paymentResponse = $this->httpClient->request(
                'GET',
                sprintf("%s/payments/%s?%s", $this->getEndpoint(), $data['payment_reference'], http_build_query($params)),
                [
                    'Authorization' => 'Basic '. $this->getAuth(),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ]
            );

            $response = json_decode($paymentResponse->getBody()->getContents(), true);

            if (empty($response)) {
                throw new \Exception('empty response');
            }

            if (!empty($response['error'])) {
                throw new \Exception($response['error']);
            }

            return $this->response = new CompletePurchaseResponse($this, $response);
        } catch (\Throwable $e) {
            throw new InvalidRequestException('payments request failed', $e->getCode(), $e);
        }
    }
}
