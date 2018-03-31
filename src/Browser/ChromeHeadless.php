<?php

namespace Momo\SimpleCaptureTool\Browser;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Momo\SimpleCaptureTool\BrowserTask\Screenshot\SelfScroll;

class ChromeHeadless implements BrowserInterface
{
    public function supports($browserType)
    {
        return $browserType === 'chrome-headless';
    }

    public function getCapabilities()
    {
        $capabilities = DesiredCapabilities::chrome();

        $chromeOptions = new ChromeOptions();
        $chromeOptions->addArguments(['--headless']);

        $capabilities->setCapability(ChromeOptions::CAPABILITY, $chromeOptions);

        return $capabilities;
    }

    public function getScreenshotTask()
    {
        return new SelfScroll();
    }
}
