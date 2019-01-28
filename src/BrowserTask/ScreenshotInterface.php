<?php

namespace Momo\SimpleCaptureTool\BrowserTask;

use Facebook\WebDriver\Remote\RemoteWebDriver;

interface ScreenshotInterface
{
    /**
     * @param \Facebook\WebDriver\Remote\RemoteWebDriver $webDriver
     * @param string                                     $imagePath
     */
    public function execute(RemoteWebDriver $webDriver, $imagePath);
}
