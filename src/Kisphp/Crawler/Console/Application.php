<?php

namespace Kisphp\Crawler\Console;

/*
 * This file is part of the PHP 404 Detector utility.
 *
 * (c) Marius-Bogdan Rizac <mariusbogdan83@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Kisphp\Crawler\Console\Command\FindCommand;
use Kisphp\Crawler\Crawler;
use Symfony\Component\Console\Application as BaseApplication;

/**
 * @author Marius-Bogdan Rizac <mariusbogdan83@gmail.com>
 */
class Application extends BaseApplication
{
    /**
     * Constructor
     */
    public function __construct()
    {
        error_reporting(-1);

        parent::__construct(Crawler::DESCRIPTION, Crawler::VERSION);

        $this->add(new FindCommand());
    }

    /**
     * @return string
     */
    public function getLongVersion()
    {
        return parent::getLongVersion() . ' by <comment>Marius-Bogdan Rizac</comment>';
    }
}
