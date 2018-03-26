<?php

namespace Momo\Selenium\BrowserTask\Screenshot;

use Facebook\WebDriver\WebDriver;
use Momo\Selenium\BrowserTask\ScreenshotInterface;

class OneShot implements ScreenshotInterface
{
    public function execute(WebDriver $webDriver, $imagePath)
    {
        $webDriver->takeScreenshot($imagePath);
    }
}
