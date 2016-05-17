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
     * @var array
     */
    protected $errorUrls = [];

    /**
     * @param string $basicDomain
     */
    public function __construct($basicDomain)
    {
        $this->client = new Client();
        $this->domain = $basicDomain;
    }

    /**
     * @param $urlToParse
     *
     * @return mixed
     */
    public static function parseUrl($urlToParse)
    {
        $domainUrl = self::getDomainUrl($urlToParse);

        $crawler = new self($domainUrl);

        return $crawler->parse($urlToParse);
    }

    /**
     * @param string $urlToParse
     *
     * @return string
     */
    public static function getDomainUrl($urlToParse)
    {
        $data = parse_url($urlToParse);

        $url = $data['scheme'] . '://' . $data['host'];

        if (isset($data['port'])) {
            $url .= ':' . $data['port'];
        }

        return $url;
    }

    /**
     * @return array
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * @return array
     */
    public function getErrorUrls()
    {
        return $this->errorUrls;
    }

    /**
     * @param string $pageUrl
     *
     * @return $this
     */
    public function parse($pageUrl)
    {
        if (array_key_exists($pageUrl, $this->urls)) {
            return $this;
        }

        if (!$this->isValidUrl($pageUrl)) {
            return $this;
        }

        if (strpos($pageUrl, '/') === 0) {
            $pageUrl = $this->domain . $pageUrl;
        }

        try {
            $resp = $this->client->get($pageUrl)->send();
            $this->setPageUrl($pageUrl, $resp->getStatusCode());
            $this->getSubpages($resp);
        } catch (ClientErrorResponseException $e) {
            $this->setPageUrl($pageUrl, $this->getError($e->getMessage()), true);
        }

        return $this;
    }

    /**
     * @param string $url
     * @param int $statusCode
     */
    protected function setPageUrl($url, $statusCode, $isErrorUrl = false)
    {
        $pageUrl = str_replace($this->domain, '', $url);

        $this->urls[$pageUrl] = $statusCode;
        if ($isErrorUrl === true) {
            $this->errorUrls[$pageUrl] = $statusCode;
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
     *
     * @return int
     */
    protected function getError($content)
    {
        $lines = explode("\n", $content);

        return (int) preg_replace('/([^0-9]+)/', '', $lines[1]);
    }
}
