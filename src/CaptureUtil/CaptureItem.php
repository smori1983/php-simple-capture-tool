<?php

namespace Momo\SimpleCaptureTool\CaptureUtil;

class CaptureItem
{
    /**
     * @var string
     */
    protected $name = null;

    /**
     * @var string
     */
    protected $url = null;

    /**
     * @param string $name
     * @param string $url
     */
    public function __construct($name, $url)
    {
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
