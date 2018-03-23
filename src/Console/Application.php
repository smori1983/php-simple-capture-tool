<?php
namespace Momo\Selenium\Console;

use Momo\Selenium\Console\Command\CapturePageCommand;
use Symfony\Component\Console\Application as ConsoleApplication;

class Application extends ConsoleApplication
{
    protected $configDirectory = null;

    public function setConfigDirectory($path)
    {
        $this->configDirectory = $path;
    }

    public function getConfigPath($relativePath)
    {
        return sprintf(
            '%s/%s',
            rtrim($this->configDirectory, '/'),
            ltrim($relativePath, '/')
        );
    }

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
