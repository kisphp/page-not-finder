<?php

namespace Kisphp\Crawler;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Http\Message\Response;
use Symfony\Component\Console\Output\OutputInterface;

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
     * @var OutputInterface
     */
    protected $output;

    /**
     * @param string $basicDomain
     */
    public function __construct($basicDomain, OutputInterface $output = null)
    {
        $this->client = new Client();
        $this->domain = $basicDomain;
        $this->output = $output;
    }

    /**
     * @param $urlToParse
     *
     * @return mixed
     */
    public static function parseUrl($urlToParse, OutputInterface $output)
    {
        $domainUrl = self::getDomainUrl($urlToParse);

        $crawler = new self($domainUrl, $output);

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
     * @return bool
     */
    public function hasErrorUrls()
    {
        return (bool) count($this->errorUrls);
    }

    /**
     * @param string $pageUrl
     *
     * @return $this
     */
    public function parse($pageUrl)
    {
        $pageUrl = $this->fixPageUrl($pageUrl);

        if (array_key_exists($pageUrl, $this->urls)) {
            return $this;
        }

        if (!$this->isValidUrl($pageUrl)) {
            return $this;
        }

        if (empty(trim($pageUrl))) {
            return $this;
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
     * @param string $pageUrl
     *
     * @return string
     */
    protected function fixPageUrl($pageUrl)
    {
        if (strpos($pageUrl, '/') === 0) {
            $pageUrl = $this->domain . $pageUrl;
        }

        return $pageUrl;
    }

    /**
     * @param string $url
     * @param int $statusCode
     */
    protected function setPageUrl($url, $statusCode, $isErrorUrl = false)
    {
        $pageUrl = $url;

        $this->showCrawledPage($pageUrl, $statusCode);

        $this->urls[$pageUrl] = $statusCode;
        if ($isErrorUrl) {
            $this->errorUrls[$pageUrl] = $statusCode;
        }
    }

    /**
     * @param string $pageUrl
     * @param int $statusCode
     */
    protected function showCrawledPage($pageUrl, $statusCode)
    {
        if ($this->output === null) {
            return;
        }

        if ($this->output->getVerbosity() > 32) {
            $message = $statusCode . ' --> ' . $pageUrl;
            if ($statusCode !== 200) {
                $message = '<error>' . $message . '</error>';
            }
            $this->output->writeln($message);
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
