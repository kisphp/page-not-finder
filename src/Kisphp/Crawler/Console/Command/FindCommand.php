<?php

namespace Kisphp\Crawler\Console\Command;

use Kisphp\Crawler\Crawler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FindCommand extends Command
{
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
        $url = 'http://spryker.github.io/core/bundles/oms/state-machine';
//        $url = 'http://spryker.github.io/user-interface/twig/syntax/';

        $crawler = new Crawler();

        $crawler->parse($url);

        dump($crawler->getUrls());
    }
}
