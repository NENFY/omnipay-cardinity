<?php

namespace Omnipay\Cardinity\Message;

use Guzzle\Common\Event;
use Omnipay\Cardinity\Helpers\OAuthOneLegged;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $endpoint = 'https://api.cardinity.com/v1';

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

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

    public function setTransactionId($value)
    {
        return $this->setParameter('transactionId', $value);
    }

    public function getTransactionId()
    {
        return $this->getParameter('transactionId');
    }

    protected function sendRequest($method, $endpoint, $data = null)
    {
        $this->httpClient->getEventDispatcher()->addListener('request.error', function (Event $event) {
            /**
             * @var \Guzzle\Http\Message\Response $response
             */
            $response = $event['response'];

            if ($response->isError()) {
                $event->stopPropagation();
            }
        });

        $url = $this->endpoint.$endpoint;
        $consumer_key = $this->getApiKey();
        $consumer_secret = $this->getApiSecret();
        $token_secret = "";
        $noonce = bin2hex(random_bytes(16)); // 32 chars
        $timestamp = time();

        $post_fields = json_encode($data);

        $oauth = ['oauth_consumer_key' => $consumer_key,
            'oauth_nonce' => $noonce,
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => $timestamp,
            'oauth_version' => '1.0'];

        $key = rawurlencode($consumer_secret) . '&' . rawurlencode($token_secret);

        $baseString = OAuthOneLegged::buildBaseString(
            $url,
            $method,
            OAuthOneLegged::prepareParameters($oauth)
        );

        $oauthSignature = base64_encode(
            hash_hmac(
                'sha1',
                $baseString,
                $key,
                true
            )
        );

        $oauth['oauth_signature'] = $oauthSignature;

        $OAuthHeader = OAuthOneLegged::buildAuthorizationHeader($oauth);

        $httpRequest = $this->httpClient->createRequest(
            $method,
            $this->endpoint . $endpoint,
            array(
                'Content-Type' => 'application/json',
                'Authorization' => $OAuthHeader,
            ),
            $post_fields
        );

        return $httpRequest->send();
    }
}
