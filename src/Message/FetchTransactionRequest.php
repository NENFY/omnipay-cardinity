<?php

namespace Omnipay\Cardinity\Message;

/**
 * Cardinity Fetch Transaction Request
 *
 * @method \Omnipay\Cardinity\Message\FetchTransactionResponse send()
 */
class FetchTransactionRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('apiKey', 'transactionReference');

        $data = array();
        $data['id'] = $this->getTransactionReference();

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('GET', '/payments/' . $data['id']);

        return $this->response = new FetchTransactionResponse($this, $httpResponse->json());
    }
}
