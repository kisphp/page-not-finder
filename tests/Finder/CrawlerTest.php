<?php

use Kisphp\Crawler\CrawlerFactory;

class CrawlerTest extends PHPUnit_Framework_TestCase
{
    public function test_static_initialize()
    {
//        $crawler = \Kisphp\Crawler\Crawler::parseUrl('http://www.example.com');
        $crawler = CrawlerFactory::createCrawler();

        $this->assertInstanceOf(\Kisphp\Crawler\Crawler::class, $crawler);
    }
}
