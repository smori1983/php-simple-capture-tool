<?php

namespace Momo\Selenium\CaptureUtil;

class CaptureList
{
    protected $items = [];

    public function addItem(CaptureItem $item)
    {
        $this->items[] = $item;
    }

    public function getItems()
    {
        return $this->items;
    }
}