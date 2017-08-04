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

        $config = self::parseYamlFile($pathToYamlFile);

        if (array_key_exists('skipPaths', $config)) {
            foreach ($config['skipPaths'] as $skipPath){
                $crawler->skipPath($skipPath);
            }
        }
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

    /**
     * @param string $pathToFile
     *
     * @return array
     */
    protected static function parseYamlFile($pathToFile)
    {
        return Yaml::parse(file_get_contents($pathToFile));
    }
}
