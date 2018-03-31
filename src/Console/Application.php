<?php

namespace Momo\SimpleCaptureTool\Console;

use Momo\SimpleCaptureTool\Console\Command\CapturePageCommand;
use Symfony\Component\Console\Application as ConsoleApplication;

class Application extends ConsoleApplication
{
    /**
     * {@inheritdoc}
     */
    protected function getDefaultCommands()
    {
        $commands = array_merge(parent::getDefaultCommands(), [
            new CapturePageCommand(),
        ]);

        return $commands;
    }
}
