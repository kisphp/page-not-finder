<?php


class CrawlerTest extends PHPUnit_Framework_TestCase
{
    public function test_static_initialize()
    {
        $crawler = \Kisphp\Crawler\Crawler::parseUrl('http://www.example.com');

        $this->assertInstanceOf(\Kisphp\Crawler\Crawler::class, $crawler);
    }
}
