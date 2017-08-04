<?php

namespace Finder;

use Finder\Fixtures\TestCrawlerFactory;
use Finder\Fixtures\Output;
use Kisphp\Crawler\Crawler;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \Kisphp\Crawler\Crawler
     */
    public function createCrawler()
    {
        $output = new Output();
        $output->setVerbosity(OutputInterface::VERBOSITY_VERBOSE);

        return TestCrawlerFactory::createCrawler($output);
    }

    public function test_initialize()
    {
        $crawler = $this->createCrawler();

        $this->assertInstanceOf(Crawler::class, $crawler);
    }

    public function test_example()
    {
        $crawler = $this->createCrawler();

        $crawler->parse('http://localhost/');

        $this->assertEquals(5, count($crawler->getUrls()));
        $this->assertTrue($crawler->hasErrorUrls());

        $this->assertEquals(2, count($crawler->getErrorUrls()));
    }

    public function test_with_error_pages()
    {
        $crawler = $this->createCrawler();

        $crawler->parse('http://localhost:8000/');

        $this->assertEquals(5, count($crawler->getUrls()));
    }

    public function test_with_error_404_pages()
    {
        $crawler = $this->createCrawler();

        $crawler->parse('http://localhost/error-404');

        $this->assertEquals(1, count($crawler->getUrls()));
    }
}
