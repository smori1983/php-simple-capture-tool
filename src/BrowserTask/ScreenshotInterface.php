<?php

namespace Momo\SimpleCaptureTool\BrowserTask;

use Facebook\WebDriver\WebDriver;

interface ScreenshotInterface
{
    /**
     * @param Facebook\WebDriver\WebDriver $webDriver
     * @param string                       $imagePath
     */
    public function execute(WebDriver $webDriver, $imagePath);
}
