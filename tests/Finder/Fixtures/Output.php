<?php

namespace Finder\Fixtures;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Output implements OutputInterface
{
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
        // TODO: Implement setVerbosity() method.
    }

    public function getVerbosity()
    {
        return 32;
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