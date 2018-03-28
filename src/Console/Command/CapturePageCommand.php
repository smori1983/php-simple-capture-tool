<?php

namespace Momo\Selenium\Console\Command;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverDimension;
use Momo\Selenium\Browser\BrowserResolver;
use Momo\Selenium\CaptureUtil\CaptureListFactory;
use Momo\Selenium\Console\Config\WebDriverConfiguration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class CapturePageCommand extends Command
{
    /**
     * @var Symfony\Component\Config\Definition\Processor
     */
    protected $processor = null;

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
        $this->processor = new Processor();
        $this->captureListFactory = new CaptureListFactory();
        $this->browserResolver = new BrowserResolver();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $yml = Yaml::parse(file_get_contents(
            $this->getApplication()->getConfigPath('webdriver.yml')
        ));

        try {
            $webDriverConf = $this->processor->processConfiguration(
                new WebDriverConfiguration(),
                [$yml]
            );
        } catch (InvalidConfigurationException $e) {
            $output->writeln('<error>Error in webdriver.yml</error>');

            return 1;
        }

        $captureList = $this->captureListFactory->create($input->getArgument('captureList'));

        $browser = $this->browserResolver->resolve($webDriverConf['browser']['type']);

        $webDriver = RemoteWebDriver::create(
            $webDriverConf['url'],
            $browser->getCapabilities(),
            $webDriverConf['connection_timeout_ms'],
            $webDriverConf['request_timeout_ms']
        );

        $webDriver
            ->manage()
            ->timeouts()
            ->pageLoadTimeout($webDriverConf['page_load_timeout']);

        $webDriver
            ->manage()
            ->window()
            ->setSize(new WebDriverDimension(
                $webDriverConf['browser']['width'],
                $webDriverConf['browser']['height']
            ));

        try {
            foreach ($captureList->getItems() as $item) {
                $webDriver->get($item->getUrl());

                $imagePath = sprintf(
                    '%s/%s.png',
                    $webDriverConf['screenshot_save_directory'],
                    $item->getName()
                );

                $browser->getScreenshotTask()->execute($webDriver, $imagePath);
            }
        } finally {
            $webDriver->quit();
        }
    }
}
