<?php

namespace Omnipay\Cardinity\Message;

class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    public function isSuccessful()
    {
        return !$this->isRedirect() && !isset($this->data['error']);
    }

    public function getMessage()
    {
        if (isset($this->data['errors']) && !empty($this->data['errors'])) {
            return reset($this->data['errors'])['message'];
        }
        return null;
    }

    public function getCode()
    {
        if (!$this->isSuccessful() && isset($this->data['errors']) && !empty($this->data['errors']) && isset($this->data['status'])) {
            return $this->data['status'];
        }

        return null;
    }

    public function getCard()
    {
        if (isset($this->data['payment_instrument'])) {
            return $this->data['payment_instrument'];
        }

        return null;
    }

    /**
     * Get the card data from the response of purchaseRequest.
     *
     * @return array|null
     */
    public function getSource()
    {
        if (isset($this->data['payment_instrument']) && $this->data['payment_method'] == 'card') {
            return $this->data['payment_instrument'];
        }

        return null;
    }
}
