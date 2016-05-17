<?php

namespace Kisphp\Crawler\Console\Command;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FindCommand extends Command
{
    /**
     * @var array
     */
    protected $urls = [];

    /**
     * @var Client
     */
    protected $client;

    /**
     * Configure
     */
    protected function configure()
    {
        $this->setName('find')
            ->setDescription('Find 404 pages')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->client = new Client();
        $url = 'http://spryker.github.io/core/bundles/oms/state-machine';
        $url = 'http://spryker.github.io/user-interface/twig/syntax/';
//        $a = $client->createRequest('GET', $url)->send();

        $this->getPageContent($url, $output);

        dump($this->urls);
    }

    protected function parseUrl($url)
    {

    }

    protected function getPageContent($pageUrl, OutputInterface $output)
    {
        if (array_key_exists($pageUrl, $this->urls)) {
            return;
        }

        try {
            $resp = $this->client->get($pageUrl)->send();
            $this->urls[$pageUrl] = $resp->getStatusCode();
        } catch (ClientErrorResponseException $e) {
            dump($e->getMessage());
        }
    }

}
