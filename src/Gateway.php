<?php

namespace Omnipay\Cardinity;

use Omnipay\Common\AbstractGateway;

/**
 * Cardinity Gateway
 *
 * @link https://developers.cardinity.com/api/v1/
 */
class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Cardinity';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'apiKey' => '',
            'apiSecret' => '',
        );
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function getApiSecret()
    {
        return $this->getParameter('apiSecret');
    }

    public function setApiSecret($value)
    {
        return $this->setParameter('apiSecret', $value);
    }

    /**
     * @param  array $parameters
     * @return \Omnipay\Cardinity\Message\FetchTransactionRequest
     */
    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cardinity\Message\FetchTransactionRequest', $parameters);
    }

    /**
     * @param  array $parameters
     * @return \Omnipay\Cardinity\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cardinity\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param  array $parameters
     * @return \Omnipay\Cardinity\Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cardinity\Message\CompletePurchaseRequest', $parameters);
    }

    /**
     * @param  array $parameters
     * @return \Omnipay\Cardinity\Message\RefundRequest
     */
    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Cardinity\Message\RefundRequest', $parameters);
    }
}
