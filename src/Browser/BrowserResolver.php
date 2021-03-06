<?php

namespace Momo\SimpleCaptureTool\Browser;

use RuntimeException;

class BrowserResolver
{
    protected $browsers = [];

    public function __construct()
    {
        $this->browsers[] = new Chrome();
        $this->browsers[] = new ChromeHeadless();
        $this->browsers[] = new Phantomjs();
    }

    /**
     * @param string $browserType
     *
     * @return BrowserInterface
     *
     * @throws RuntimeException
     */
    public function resolve($browserType)
    {
        foreach ($this->browsers as $browser) {
            if ($browser->supports($browserType)) {
                return $browser;
            }
        }

        throw new RuntimeException(sprintf(
            'Unsupported browser type: %s',
            $browserType
        ));
    }
}
