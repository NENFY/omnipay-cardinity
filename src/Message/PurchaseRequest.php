<?php
namespace Omnipay\Cardinity\Message;

/**
 * Cardinity Purchase Request
 *
 * @method \Omnipay\Cardinity\Message\PurchaseResponse send()
 */
class PurchaseRequest extends AbstractRequest
{

    public function getData()
    {
        $this->validate('apiKey', 'amount');

        $data = [
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'country' => $this->getCard()->getBillingCountry(),
            'payment_method' => 'card',
            'payment_instrument' => [
                'pan' => $this->getCard()->getNumber(),
                'exp_year' => $this->getCard()->getExpiryYear(),
                'exp_month' => $this->getCard()->getExpiryMonth(),
                'cvc' => $this->getCard()->getCvv(),
                'holder' => $this->getCard()->getName(),
            ],
        ];

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->sendRequest('POST', '/payments', $data);

        return $this->response = new PurchaseResponse($this, $httpResponse->json());
    }
}
