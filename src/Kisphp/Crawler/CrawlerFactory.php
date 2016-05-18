<?php

namespace Kisphp\Crawler;

use Guzzle\Http\Client;
use Symfony\Component\Console\Output\OutputInterface;

abstract class CrawlerFactory
{
    /**
     * @return Crawler
     */
    public static function createCrawler(OutputInterface $outputInterface)
    {
        $client = self::createClient();

        return new Crawler($client, $outputInterface);
    }

    /**
     * @return Client
     */
    protected static function createClient()
    {
        return new Client();
    }
}