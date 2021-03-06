<?php

namespace Finder\Fixtures;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

class TestClient extends Client
{
    public function request($method, $uri = null, array $options = [])
    {
        $responseCode = 200;

        if (preg_match('/error/', $uri)) {
            $responseCode = preg_replace('/([^0-9]+)/', '', $uri);
            $request = new Request($method, $uri);
            $response = new Response($responseCode);

            throw new ClientException('error ' . $responseCode, $request, $response);
        }

        return new TestResponse($responseCode);
    }
}