<?php

namespace Kisphp\Crawler;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Http\Message\Response;

class Crawler
{
    const VERSION = '0.1.0';

    /**
     * @var
     */
    protected $domain;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $urls = [];

    /**
     * @param string $basicDomain
     */
    public function __construct($basicDomain)
    {
        $this->client = new Client();
        $this->domain = $basicDomain;
    }

    /**
     * @return array
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * @param string $pageUrl
     */
    public function parse($pageUrl)
    {
        if (array_key_exists($pageUrl, $this->urls)) {
            return;
        }

        if (!$this->isValidUrl($pageUrl)) {
            return;
        }

        if (strpos($pageUrl, '/') === 0) {
            $pageUrl = $this->domain . $pageUrl;
        }

        try {
            $resp = $this->client->get($pageUrl)->send();
            $this->urls[$pageUrl] = $resp->getStatusCode();
            $this->getSubpages($resp);
        } catch (ClientErrorResponseException $e) {
            $this->urls[$pageUrl] = $this->getError($e->getMessage());
        }
    }

    /**
     * @param string $url
     *
     * @return bool
     */
    protected function isValidUrl($url)
    {
        if (strpos($url, '#') === 0) {
            return false;
        }

        if (strpos($url, 'mailto') === 0) {
            return false;
        }

        if (strpos($url, $this->domain) === false && strpos($url, '/') !== 0) {
            return false;
        }

        return true;
    }

    /**
     * @param Response $content
     */
    protected function getSubpages(Response $content)
    {
        preg_match_all('/href="(.*)"/U', $content->getMessage(), $urlsFound);
        if (count($urlsFound) > 0) {
            foreach ($urlsFound[1] as $url) {
                $this->parse($url);
            }
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