<?php

namespace Momo\SimpleCaptureTool\CaptureUtil;

interface ListReaderInterface
{
    /**
     * @param string $format
     *
     * @return bool
     */
    public function supports($format);

    /**
     * @param \SplFileInfo $file
     *
     * @return \Momo\SimpleCaptureTool\CaptureUtil\CaptureList
     */
    public function read(\SplFileInfo $file);
}
