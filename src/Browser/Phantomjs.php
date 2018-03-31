<?php

namespace Momo\SimpleCaptureTool\Browser;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\WebDriverBrowserType;
use Momo\SimpleCaptureTool\BrowserTask\Screenshot\OneShot;

class Phantomjs implements BrowserInterface
{
    public function supports($browserType)
    {
        return $browserType === WebDriverBrowserType::PHANTOMJS;
    }

    public function getCapabilities()
    {
        return DesiredCapabilities::phantomjs();
    }

    public function getScreenshotTask()
    {
        return new OneShot();
    }
}
