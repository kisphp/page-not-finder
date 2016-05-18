<?php

namespace Finder\Fixtures;

use Guzzle\Http\Client;

class TestClient extends Client
{
    public function send($requests)
    {
        $responseCode = 200;
        $url = $requests->getPath();

        if (strpos($url, 'error') === 0) {
            $responseCode = preg_replace('', '', $url);
        }

        return new ResponseTest($responseCode);
    }

}