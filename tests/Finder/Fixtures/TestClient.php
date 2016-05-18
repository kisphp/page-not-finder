<?php

namespace Finder\Fixtures;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;

class TestClient extends Client
{
    /**
     * @param array|\Guzzle\Http\Message\RequestInterface $requests
     * @return ResponseTest
     */
    public function send($requests)
    {
        $responseCode = 200;
        $url = $requests->getPath();

        if (strpos($url, 'error') === 0) {
            $responseCode = preg_replace('', '', $url);
            throw new ClientErrorResponseException('error ' . $responseCode, $responseCode);
        }

        return new ResponseTest($responseCode);
    }
}