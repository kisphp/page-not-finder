<?php

namespace Kisphp\Crawler;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\Console\Output\OutputInterface;

class Crawler
{
    const VERSION = '1.0.0';

    const DESCRIPTION = 'PHP Error Pages Detector';

    const COMMAND_DESCRIPTION = 'Find error pages in your web application';

    /**
     * @var
     */
    protected $domain;

    /**
     * @var array
     */
    protected $urls = [];

    /**
     * @var array
     */
    protected $errorUrls = [];

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @param ClientInterface $clientInterface
     * @param OutputInterface|null $output
     */
    public function __construct(ClientInterface $clientInterface, OutputInterface $output = null)
    {
        $this->client = $clientInterface;
        $this->output = $output;
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
        $this->domain = $this->getDomainUrl($pageUrl);

        return $this->parseUrl($pageUrl);
    }

    /**
     * @param string $pageUrl
     *
     * @return $this
     */
    protected function parseUrl($pageUrl)
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
            $resp = $this->client->request('GET', $pageUrl);
            $responseCode = $resp->getStatusCode();
            $this->setPageUrl($pageUrl, $responseCode);
            $this->getSubpages($resp);
        } catch (ClientException $e) {
            $responseCode = $e->getCode();
            $this->setPageUrl($pageUrl, $responseCode, true);
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

        if (preg_match('/(javascript:void|js:void)/', $url)) {
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
        preg_match_all('/href="(.*)"/U', $content->getBody(), $urlsFound);
        if (count($urlsFound) > 0) {
            foreach ($urlsFound[1] as $url) {
                if (empty($url)) {
                    continue;
                }
                $this->parseUrl($url);
            }
        }
    }
}
