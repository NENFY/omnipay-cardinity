<?php
namespace Omnipay\Cardinity\Helpers;

class OAuthOneLegged
{

    static function prepareParameters($params)
    {
        uksort($params, 'strcmp');

        foreach ($params as $key => $value) {
            if ($value === null) {
                unset($params[$key]);
            }
        }

        return $params;
    }

    static function buildBaseString($url, $method, $params)
    {
        $query = http_build_query($params, '', '&', PHP_QUERY_RFC3986);

        return strtoupper($method)
            . '&' . rawurlencode($url)
            . '&' . rawurlencode($query);
    }

    static function buildAuthorizationHeader($params)
    {
        uksort($params, 'strcmp');

        foreach ($params as $key => $value) {
            $params[$key] = $key . '="' . rawurlencode($value) . '"';
        }

        $string = "OAuth " . implode(', ', $params);

        return $string;
    }

}
