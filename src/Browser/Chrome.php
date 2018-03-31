<?php

namespace Momo\SimpleCaptureTool\Browser;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\WebDriverBrowserType;
use Momo\SimpleCaptureTool\BrowserTask\Screenshot\SelfScroll;

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
