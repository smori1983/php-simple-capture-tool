<?php

namespace Momo\Selenium\Console\Command;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverDimension;
use Momo\Selenium\Browser\BrowserResolver;
use Momo\Selenium\CaptureUtil\CaptureListFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class CapturePageCommand extends Command
{
    protected $captureListFactory = null;

    protected $browserResolver = null;

    protected function configure()
    {
        $this
            ->setName('capture:page')
            ->setDescription('')
            ->setDefinition([
                new InputArgument('captureList', InputArgument::REQUIRED, 'URL list file'),
            ]);
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->captureListFactory = new CaptureListFactory();
        $this->browserResolver = new BrowserResolver();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $seleniumConf = Yaml::parse(file_get_contents(
            $this->getApplication()->getConfigPath('webdriver.yml')
        ));

        $captureList = $this->captureListFactory->create($input->getArgument('captureList'));

        $browser = $this->browserResolver->resolve($seleniumConf['browser']['type']);

        $webDriver = RemoteWebDriver::create(
            $seleniumConf['url'],
            $browser->getCapabilities(),
            $seleniumConf['connection_timeout_ms'],
            $seleniumConf['request_timeout_ms']
        );

        $webDriver
            ->manage()
            ->timeouts()
            ->pageLoadTimeout($seleniumConf['page_load_timeout']);

        $webDriver
            ->manage()
            ->window()
            ->setSize(new WebDriverDimension(
                $seleniumConf['browser']['width'],
                $seleniumConf['browser']['height']
            ));

        try {
            foreach ($captureList->getItems() as $item) {
                $webDriver->get($item->getUrl());

                $imagePath = sprintf(
                    '%s/%s.png',
                    $seleniumConf['screenshot_save_directory'],
                    $item->getName()
                );

                $browser->getScreenshotTask()->execute($webDriver, $imagePath);
            }
        } finally {
            $webDriver->quit();
        }
    }
}
