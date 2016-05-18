<?php

namespace Finder\Fixtures;

use Guzzle\Http\Client;

class TestClient extends Client
{
    public function send($requests)
    {
        return new ResponseTest(200);
    }

}