<?php

namespace Momo\Selenium\BrowserTask;

use Facebook\WebDriver\WebDriver;

interface ScreenshotInterface
{
    /**
     * @param Facebook\WebDriver\WebDriver $webDriver
     * @param string                       $imagePath
     */
    public function execute(WebDriver $webDriver, $imagePath);
}
