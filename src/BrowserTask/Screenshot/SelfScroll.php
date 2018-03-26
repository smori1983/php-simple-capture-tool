<?php

namespace Momo\Selenium\BrowserTask\Screenshot;

use Facebook\WebDriver\WebDriver;
use Momo\Selenium\BrowserTask\ScreenshotInterface;
use Vfs\FileSystem;

class SelfScroll implements ScreenshotInterface
{
    public function execute(WebDriver $webDriver, $imagePath)
    {
        $protocol = sprintf('screenshot-%s', sha1(microtime()));

        $vfs = FileSystem::factory($protocol);
        $vfs->mount();

        $scrollHeight = $webDriver->executeScript('return document.documentElement.scrollHeight;');
        $innerWidth = $webDriver->executeScript('return window.innerWidth;');
        $innerHeight = $webDriver->executeScript('return window.innerHeight;');

        $i = 0;
        $scrollableHeight = $scrollHeight;

        $shots = [];

        while ($scrollableHeight > 0) {
            $webDriver->executeScript(sprintf('window.scrollTo(0, %d);', $innerHeight * $i));

            $png = sprintf('%s://%d.png', $protocol, $i);

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

        imagepng($im, $imagePath);
        imagedestroy($im);

        $vfs->unmount();
    }
}
