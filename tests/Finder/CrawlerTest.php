<?php

namespace Finder;

use Finder\Fixtures\TestCrawlerFactory;
use Finder\Fixtures\Output;

class CrawlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \Kisphp\Crawler\Crawler
     */
    public function createCrawler()
    {
        $output = new Output();

        return TestCrawlerFactory::createCrawler($output);
    }

    public function test_initialize()
    {
        $crawler = $this->createCrawler();

        $this->assertInstanceOf(\Kisphp\Crawler\Crawler::class, $crawler);
    }

    public function test_example()
    {
        $crawler = $this->createCrawler();

        $crawler->parse('http://localhost/');

        $this->assertEquals(3, count($crawler->getUrls()));
        $this->assertFalse($crawler->hasErrorUrls());
    }
}
