<?php

namespace Momo\Selenium\Browser;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\WebDriverBrowserType;
use Facebook\WebDriver\WebDriver;

class Phantomjs implements BrowserInterface
{
    public function supports($browserType)
    {
        return WebDriverBrowserType::PHANTOMJS === $browserType;
    }

    public function getCapabilities()
    {
        return DesiredCapabilities::phantomjs();
    }

    public function takeScreenshot(WebDriver $webDriver, $imagePath)
    {
        $webDriver->takeScreenshot($imagePath);
    }
}
