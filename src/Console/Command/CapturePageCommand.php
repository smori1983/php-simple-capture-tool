<?php

namespace Momo\SimpleCaptureTool\Console\Command;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverDimension;
use Momo\SimpleCaptureTool\Browser\BrowserResolver;
use Momo\SimpleCaptureTool\CaptureUtil\CaptureListFactory;
use Momo\SimpleCaptureTool\CaptureUtil\ErrorReporter;
use Momo\SimpleCaptureTool\Console\Config\WebDriverConfigReader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CapturePageCommand extends Command
{
    /**
     * @var \Momo\SimpleCaptureTool\Console\Config\WebDriverConfigReader
     */
    protected $configReader = null;

    /**
     * @var \Momo\SimpleCaptureTool\CaptureUtil\CaptureListFactory
     */
    protected $captureListFactory = null;

    /**
     * @var \Momo\SimpleCaptureTool\Browser\BrowserResolver
     */
    protected $browserResolver = null;

    /**
     * @var \Momo\SimpleCaptureTool\CaptureUtil\ErrorReporter
     */
    protected $errorReporter = null;

    protected function configure()
    {
        $this
            ->setName('capture:page')
            ->setDescription('')
            ->setDefinition([
                new InputArgument('captureList', InputArgument::REQUIRED, 'URL list file'),
                new InputOption('config', 'c', InputOption::VALUE_REQUIRED, 'WebDriver config yaml file path', 'webdriver.yml'),
            ]);
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->configReader = new WebDriverConfigReader();
        $this->captureListFactory = new CaptureListFactory();
        $this->browserResolver = new BrowserResolver();
        $this->errorReporter = new ErrorReporter();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $config = $this->configReader->read($input->getOption('config'));
        } catch (\Exception $e) {
            $output->writeln('<error>Error in processing WebDriver config yaml.</error>');
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));

            return 1;
        }

        $captureList = $this->captureListFactory->create($input->getArgument('captureList'));

        $browser = $this->browserResolver->resolve($config['browser']['type']);

        $webDriver = RemoteWebDriver::create(
            $config['url'],
            $browser->getCapabilities(),
            $config['connection_timeout_ms'],
            $config['request_timeout_ms']
        );

        $webDriver
            ->manage()
            ->timeouts()
            ->pageLoadTimeout($config['page_load_timeout']);

        $webDriver
            ->manage()
            ->window()
            ->setSize(new WebDriverDimension(
                $config['browser']['width'],
                $config['browser']['height']
            ));

        foreach ($captureList->getItems() as $item) {
            try {
                $webDriver->get($item->getUrl());

                $imagePath = $this->createImagePath($config, $item->getName());

                $browser->getScreenshotTask()->execute($webDriver, $imagePath);
            } catch (\Exception $e) {
                $this->errorReporter->add($item, $e);
            }
        }

        $webDriver->quit();

        $this->errorReporter->report($output);
    }

    protected function createImagePath(array $config, $itemName)
    {
        $name = str_replace(DIRECTORY_SEPARATOR, '_', $itemName);
        $name = preg_replace('/\.{2,}/', '_', $name);

        return sprintf(
            '%s/%s.png',
            $config['screenshot_save_directory'],
            $name
        );
    }
}
