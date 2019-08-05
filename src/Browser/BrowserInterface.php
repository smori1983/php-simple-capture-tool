<?php

namespace Momo\SimpleCaptureTool\Browser;

use Facebook\WebDriver\WebDriverCapabilities;
use Momo\SimpleCaptureTool\BrowserTask\ScreenshotInterface;

interface BrowserInterface
{
    /**
     * Returns whether the implementation is responsible with passed browser type.
     *
     * @param string $browserType
     *
     * @return bool
     */
    public function supports($browserType);

    /**
     * @return WebDriverCapabilities
     */
    public function getCapabilities();

    /**
     * @return ScreenshotInterface;
     */
    public function getScreenshotTask();
}
