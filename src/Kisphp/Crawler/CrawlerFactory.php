<?php

namespace Kisphp\Crawler;

use Guzzle\Http\Client;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlerFactory
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
     * @return ClientInterface
     */
    protected static function createClient()
    {
        return new Client();
    }
}