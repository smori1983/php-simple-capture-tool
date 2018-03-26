<?php

namespace Momo\Selenium\Browser;

interface BrowserInterface
{
    /**
     * @param string $browserType
     *
     * @return bool
     */
    public function supports($browserType);

    /**
     * @return Facebook\WebDriver\Remote\DesiredCapabilities
     */
    public function getCapabilities();

    /**
     * @return Momo\Selenium\BrowserTask\ScreenshotInterface;
     */
    public function getScreenshotTask();
}
