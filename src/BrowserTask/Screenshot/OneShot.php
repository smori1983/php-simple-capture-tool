<?php

namespace Momo\SimpleCaptureTool\BrowserTask\Screenshot;

use Facebook\WebDriver\WebDriver;
use Momo\SimpleCaptureTool\BrowserTask\ScreenshotInterface;

class OneShot implements ScreenshotInterface
{
    public function execute(WebDriver $webDriver, $imagePath)
    {
        $webDriver->takeScreenshot($imagePath);
    }
}
