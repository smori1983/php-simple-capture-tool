<?php
namespace Momo\Selenium\Console\Command;

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

        // $capabilities = DesiredCapabilities::phantomjs();
        $capabilities = DesiredCapabilities::chrome();

        $webDriver = RemoteWebDriver::create(
            $seleniumConf['url'],
            $capabilities
        );

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

        foreach ($urlList['list'] as $item) {
            $webDriver->get($item['url']);

            $imageHeight = $scrollHeight = $webDriver->executeScript('return document.documentElement.scrollHeight;');
            $innerWidth = $webDriver->executeScript('return window.innerWidth;');
            $innerHeight = $webDriver->executeScript('return window.innerHeight;');

            $i = 0;

            $shots = [];

            while ($scrollHeight > $innerHeight) {
                $png = sprintf(
                    '%s/_tmp/%s.%d.png',
                    $seleniumConf['screenshot_save_directory'],
                    $item['name'],
                    $i
                );

                $shots[] = $png;

                $webDriver->takeScreenshot($png);

                $scrollHeight = $scrollHeight - $innerHeight;

                $i++;

                $webDriver->executeScript(sprintf('window.scrollTo(0, %d);', $innerHeight * $i));
            }

            $im = imagecreatetruecolor($innerWidth, $imageHeight);
            imagefill($im, 0, 0, $white = imagecolorallocate($im, 0xFF, 0xFF, 0xFF));

            for ($i = count($shots) - 1; $i >= 0; $i--) {
                $part = imagecreatefrompng($shots[$i]);
                imagecopy($im, $part, 0, $innerHeight * $i, 0, 0, $innerWidth, $innerHeight);
                imagedestroy($part);
            }

            imagepng($im, sprintf('%s/%s.png', $seleniumConf['screenshot_save_directory'], $item['name']));
            imagedestroy($im);
        }

        $webDriver->quit();
    }
}
