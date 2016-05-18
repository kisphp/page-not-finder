<?php

namespace Finder;

use Finder\Fixtures\Output;
use Kisphp\Crawler\CrawlerFactory;

class CrawlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \Kisphp\Crawler\Crawler
     */
    public function createCrawler()
    {
        $output = new Output();

        return CrawlerFactory::createCrawler($output);
    }

    public function test_initialize()
    {
        $crawler = $this->createCrawler();

        $this->assertInstanceOf(\Kisphp\Crawler\Crawler::class, $crawler);
    }
}
