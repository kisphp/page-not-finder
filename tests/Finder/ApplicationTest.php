<?php

namespace Finder;

use Kisphp\Crawler\Console\Application;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function test_application()
    {
        $app = new Application();

        $this->assertContains('Marius', $app->getLongVersion());
    }
}