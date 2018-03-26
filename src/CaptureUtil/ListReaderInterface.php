<?php

namespace Momo\Selenium\CaptureUtil;

interface ListReaderInterface
{
    /**
     * @param string $format
     *
     * @return bool
     */
    public function supports($format);

    /**
     * @param string $filePath
     *
     * @return Momo\Selenium\CaptureUtil\CaptureList
     */
    public function read($filePath);
}
