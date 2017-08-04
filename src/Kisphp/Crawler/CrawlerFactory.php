<?php

namespace Kisphp\Crawler;

use GuzzleHttp\Client;
use Symfony\Component\Console\Output\OutputInterface;

abstract class CrawlerFactory
{
    /**
     * @return Crawler
     */
    public static function createCrawler(OutputInterface $outputInterface)
    {
        $client = static::createClient();

        $crawler = new Crawler($client, $outputInterface);

        static::addSkipPaths($crawler);

        return $crawler;
    }

    /**
     * @param Crawler $crawler
     */
    protected static function addSkipPaths(Crawler $crawler)
    {
        $crawler->skipPath('logout');
        $crawler->skipPath('password-reset');
        $crawler->skipPath('check-bundle');
        $crawler->skipPath('dependency');
    }

    /**
     * @return Client
     */
    protected static function createClient()
    {
        return new Client([
            'verify' => false,
        ]);
    }
}
