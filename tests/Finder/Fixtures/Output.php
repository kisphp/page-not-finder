<?php

namespace Finder\Fixtures;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Output implements OutputInterface
{
    /**
     * @var int
     */
    protected $verbosity = 32;

    public function write($messages, $newline = false, $options = 0)
    {
        // TODO: Implement write() method.
    }

    public function writeln($messages, $options = 0)
    {
        // TODO: Implement writeln() method.
    }

    public function setVerbosity($level)
    {
        $this->verbosity = $level;
    }

    public function getVerbosity()
    {
        return $this->verbosity;
    }

    public function isQuiet()
    {
        return true;
    }

    public function isVerbose()
    {
        return false;
    }

    public function isVeryVerbose()
    {
        return false;
    }

    public function isDebug()
    {
        return false;
    }

    public function setDecorated($decorated)
    {
        // TODO: Implement setDecorated() method.
    }

    public function isDecorated()
    {
        return false;
    }

    public function setFormatter(OutputFormatterInterface $formatter)
    {
        // TODO: Implement setFormatter() method.
    }

    public function getFormatter()
    {
        // TODO: Implement getFormatter() method.
    }

}