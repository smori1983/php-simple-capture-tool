<?php

namespace Momo\SimpleCaptureTool\CaptureUtil;

class CaptureItem
{
    protected $name = null;

    protected $url = null;

    public function __construct($name, $url)
    {
        $this->name = $name;
        $this->url = $url;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUrl()
    {
        return $this->url;
    }
}
