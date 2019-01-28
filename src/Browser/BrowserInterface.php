<?php

namespace Momo\SimpleCaptureTool\Browser;

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
     * @return \Facebook\WebDriver\WebDriverCapabilities
     */
    public function getCapabilities();

    /**
     * @return \Momo\SimpleCaptureTool\BrowserTask\ScreenshotInterface;
     */
    public function getScreenshotTask();
}
