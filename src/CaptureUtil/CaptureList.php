<?php

namespace Momo\SimpleCaptureTool\CaptureUtil;

class CaptureList
{
    /**
     * @var CaptureItem[]
     */
    protected $items = [];

    /**
     * @param CaptureItem $item
     */
    public function addItem(CaptureItem $item)
    {
        $this->items[] = $item;
    }

    /**
     * @return CaptureItem[]
     */
    public function getItems()
    {
        return $this->items;
    }
}
