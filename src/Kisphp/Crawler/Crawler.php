<?php

namespace Kisphp\Crawler;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;

class Crawler
{
    const VERSION = '0.1.0';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $urls = [];

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @return array
     */
    public function getUrls()
    {
        return $this->urls;
    }

    public function parse($pageUrl)
    {
        if (array_key_exists($pageUrl, $this->urls)) {
            return;
        }

        try {
            $resp = $this->client->get($pageUrl)->send();
            $this->urls[$pageUrl] = $resp->getStatusCode();
        } catch (ClientErrorResponseException $e) {
            $this->urls[$pageUrl] = $this->getError($e->getMessage());
        }
    }

    /**
     * @param string $content
     * @return int
     */
    protected function getError($content)
    {
        $lines = explode("\n", $content);

        return (int) preg_replace('/([^0-9]+)/', '', $lines[1]);
    }
}