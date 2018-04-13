<?php

namespace Omnipay\Cardinity\Message;

class PurchaseResponse extends FetchTransactionResponse
{

    public function isSuccessful()
    {
        return ($this->getStatus() == 'approved' ? true : false);
    }
}
