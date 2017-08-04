<?php

namespace Kisphp\Crawler;

use GuzzleHttp\Client;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

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
        $pathToYamlFile = __DIR__ . '/../../../../../../.page-not-finder.yml';

        if (is_file($pathToYamlFile) === false) {
            return;
        }

        $config = self::parseYmlFile($pathToYamlFile);

        dump($config);die;

        //$crawler->skipPath('logout');
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

    protected static function parseYmlFile($pathToFile)
    {
        return Yaml::parse(file_get_contents($pathToFile));
    }
}
