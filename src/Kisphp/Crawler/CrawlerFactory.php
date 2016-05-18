<?php

namespace Kisphp\Crawler;

use Guzzle\Http\Client;

class CrawlerFactory
{
    /**
     * @return Crawler
     */
    public static function createCrawler()
    {
        $client = self::createClient();

        return new Crawler($client);
    }

    /**
     * @return Client
     */
    protected static function createClient()
    {
        return new Client();
    }
}