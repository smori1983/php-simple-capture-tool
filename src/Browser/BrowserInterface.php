<?php

namespace Momo\SimpleCaptureTool\Browser;

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
     * @return Momo\SimpleCaptureTool\BrowserTask\ScreenshotInterface;
     */
    public function getScreenshotTask();
}
