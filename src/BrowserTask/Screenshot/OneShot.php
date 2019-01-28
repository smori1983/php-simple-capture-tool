<?php

namespace Momo\SimpleCaptureTool\BrowserTask\Screenshot;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Momo\SimpleCaptureTool\BrowserTask\ScreenshotInterface;

class OneShot implements ScreenshotInterface
{
    public function execute(RemoteWebDriver $webDriver, $imagePath)
    {
        $webDriver->takeScreenshot($imagePath);
    }
}
