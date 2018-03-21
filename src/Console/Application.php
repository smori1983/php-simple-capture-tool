<?php
namespace Momo\Selenium\Console;

use Momo\Selenium\Console\Command\PageCaptureCommand;
use Symfony\Component\Console\Application as ConsoleApplication;

class Application extends ConsoleApplication
{
    /**
     * {@inheritdoc}
     */
    protected function getDefaultCommands()
    {
        $commands = array_merge(parent::getDefaultCommands(), [
            new PageCaptureCommand(),
        ]);

        return $commands;
    }
}
