<?php

namespace Finder\Fixtures;

use Kisphp\Crawler\CrawlerFactory;

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