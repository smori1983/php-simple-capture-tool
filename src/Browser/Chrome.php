<?php

namespace Momo\Selenium\Browser;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\WebDriverBrowserType;
use Momo\Selenium\BrowserTask\Screenshot\SelfScroll;

class Chrome implements BrowserInterface
{
    public function supports($browserType)
    {
        return $browserType === WebDriverBrowserType::CHROME;
    }

    public function getCapabilities()
    {
        return DesiredCapabilities::chrome();
    }

    public function getScreenshotTask()
    {
        return new SelfScroll();
    }
}
