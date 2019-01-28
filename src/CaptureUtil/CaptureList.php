<?php

namespace Momo\SimpleCaptureTool\CaptureUtil;

class CaptureList
{
    /**
     * @var \Momo\SimpleCaptureTool\CaptureUtil\CaptureItem[]
     */
    protected $items = [];

    /**
     * @param \Momo\SimpleCaptureTool\CaptureUtil\CaptureItem $item
     */
    public function addItem(CaptureItem $item)
    {
        $this->items[] = $item;
    }

    /**
     * @return \Momo\SimpleCaptureTool\CaptureUtil\CaptureItem[]
     */
    public function getItems()
    {
        return $this->items;
    }
}
