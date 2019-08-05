<?php

namespace Momo\SimpleCaptureTool\CaptureUtil;

use SplFileInfo;

interface ListReaderInterface
{
    /**
     * @param string $format
     *
     * @return bool
     */
    public function supports($format);

    /**
     * @param SplFileInfo $file
     *
     * @return CaptureList
     */
    public function read(SplFileInfo $file);
}
