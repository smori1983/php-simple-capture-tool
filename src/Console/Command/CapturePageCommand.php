<?php
namespace Momo\Selenium\Console\Command;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverDimension;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class CapturePageCommand extends Command
{
    protected $filesystem = null;

    protected function configure()
    {
        $this
            ->setName('capture:page')
            ->setDescription('')
            ->setDefinition([]);
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->filesystem = new Filesystem();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $seleniumConf = Yaml::parse(file_get_contents(
            $this->getApplication()->getConfigPath('config_selenium.yml')
        ));

        $urlList = Yaml::parse(file_get_contents(
            $this->getApplication()->getConfigPath('config_capture_list.yml')
        ));

        $capabilities = DesiredCapabilities::chrome();

        $chromeOptions = new ChromeOptions();
        $chromeOptions->addArguments(['--headless']);

        $capabilities->setCapability(ChromeOptions::CAPABILITY, $chromeOptions);

        $webDriver = RemoteWebDriver::create(
            $seleniumConf['url'],
            $capabilities,
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

        $tmpDirectory = sprintf('%s/_tmp', $seleniumConf['screenshot_save_directory']);

        $this->filesystem->remove($tmpDirectory);
        $this->filesystem->mkdir($tmpDirectory);

        try {
            foreach ($urlList['list'] as $item) {
                $webDriver->get($item['url']);

                $scrollHeight = $webDriver->executeScript('return document.documentElement.scrollHeight;');
                $innerWidth = $webDriver->executeScript('return window.innerWidth;');
                $innerHeight = $webDriver->executeScript('return window.innerHeight;');

                $i = 0;
                $scrollableHeight = $scrollHeight;

                $shots = [];

                while ($scrollableHeight > 0) {
                    $webDriver->executeScript(sprintf('window.scrollTo(0, %d);', $innerHeight * $i));

                    $png = sprintf(
                        '%s/_tmp/%s.%d.png',
                        $seleniumConf['screenshot_save_directory'],
                        $item['name'],
                        $i
                    );

                    $webDriver->takeScreenshot($png);

                    $shots[] = $png;

                    $scrollableHeight = $scrollableHeight - $innerHeight;

                    $i++;
                }

                $im = imagecreatetruecolor($innerWidth, $scrollHeight);

                for ($i = count($shots) - 1; $i >= 0; $i--) {
                    $part = imagecreatefrompng($shots[$i]);

                    if (($overrun = ($innerHeight * ($i + 1)) - $scrollHeight) > 0) {
                        $destY = $innerHeight * $i - $overrun;
                    } else {
                        $destY = $innerHeight * $i;
                    }

                    imagecopy($im, $part, 0, $destY, 0, 0, $innerWidth, $innerHeight);
                    imagedestroy($part);
                }

                imagepng($im, sprintf('%s/%s.png', $seleniumConf['screenshot_save_directory'], $item['name']));
                imagedestroy($im);
            }
        } finally {
            $webDriver->quit();
        }
    }
}
