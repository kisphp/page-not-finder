<?php

namespace Finder\Fixtures;

use GuzzleHttp\Tests\Psr7\ServerRequestTest;
use Kisphp\Crawler\CrawlerFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class TestCrawlerFactory extends CrawlerFactory
{
    /**
     * @return TestClient
     */
    protected static function createClient()
    {
        return new TestClient();
    }
}