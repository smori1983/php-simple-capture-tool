<?php
namespace Momo\Selenium\Console\Command;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\DriverCommand;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverDimension;
use Facebook\WebDriver\WebDriverKeys;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class PageCaptureCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('page:capture')
            ->setDescription('')
            ->setDefinition([]);
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $seleniumConf = Yaml::parse(file_get_contents(
            $this->getApplication()->getConfigPath('config_selenium.yml')
        ));

        $urlList = Yaml::parse(file_get_contents(
            $this->getApplication()->getConfigPath('config_capture_list.yml')
        ));

        $webDriver = RemoteWebDriver::create(
            $seleniumConf['url'],
            DesiredCapabilities::chrome()
        );

        $webDriver
            ->manage()
            ->window()
            ->setSize(new WebDriverDimension(
                $seleniumConf['browser']['width'],
                $seleniumConf['browser']['height']
            ));

        foreach ($urlList['list'] as $item) {
            $webDriver->get($item['url']);
            $webDriver->takeScreenshot(sprintf(
                '%s/name.png',
                $seleniumConf['screenshot_save_directory'],
                $item['name']
            ));
        }

        $webDriver->close();
    }
}
