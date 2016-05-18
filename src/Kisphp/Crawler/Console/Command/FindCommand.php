<?php

namespace Kisphp\Crawler\Console\Command;

use Kisphp\Crawler\Crawler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
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
            ->addArgument('url', InputArgument::REQUIRED, 'Public url to test')
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
        $url = $input->getArgument('url');

        $crawler = Crawler::parseUrl($url, $output);

        $output->writeln(' ');
        if (!$crawler->hasErrorUrls()) {
            $output->writeln('<info>Congrats! No error pages found</info>');
            $output->writeln(' ');

            return;
        }
        $output->writeln('<fg=red>Errors found</>');
        foreach ($crawler->getErrorUrls() as $url => $error) {
            $output->writeln($url . ' => ' . $error);
        }
        $output->writeln(' ');
    }
}
