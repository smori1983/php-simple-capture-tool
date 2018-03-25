<?php

namespace Momo\Selenium\Browser;

use Facebook\WebDriver\WebDriver;

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
     * @param Facebook\WebDriver\WebDriver $webDriver
     * @param string                       $imagePath
     */
    public function takeScreenshot(WebDriver $webDriver, $imagePath);
}
