<?php

namespace Kisphp\Crawler\Console\Command;

use Kisphp\Crawler\Crawler;
use Kisphp\Crawler\CrawlerFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FindCommand extends Command
{
    const COMMAND_NAME = 'find';

    const ARGUMENT_URL = 'url';

    /**
     * Configure command
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription(Crawler::COMMAND_DESCRIPTION)
            ->addArgument(self::ARGUMENT_URL, InputArgument::REQUIRED, 'Public url to test')
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
        $url = $input->getArgument(self::ARGUMENT_URL);

        $crawler = CrawlerFactory::createCrawler($output);
        $crawler->parse($url);

        $output->writeln(' ');
        if (!$crawler->hasErrorUrls()) {
            $output->writeln('<info>Congrats! No error pages found</info>');
            $output->writeln(' ');

            return;
        }

        $errorsFound = $crawler->getErrorUrls();

        $output->writeln('<fg=red>' . count($errorsFound) . ' Errors found</>');
        foreach ($errorsFound as $url => $error) {
            $output->writeln($url . ' => ' . $error);
        }
        $output->writeln(' ');
    }
}
