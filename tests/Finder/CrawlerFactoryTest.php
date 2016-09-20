<?php

namespace Finder;

use Finder\Fixtures\Output;
use Kisphp\Crawler\Crawler;
use Kisphp\Crawler\CrawlerFactory;

class CrawlerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function test_Client()
    {
        $output = new Output();
        $crawler = CrawlerFactory::createCrawler($output);

        $this->assertInstanceOf(Crawler::class, $crawler);
    }
}
