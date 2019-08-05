<?php

namespace Momo\SimpleCaptureTool\CaptureUtil;

use SplFileInfo;
use RuntimeException;

class CaptureListFactory
{
    /**
     * @var ListReaderResolver
     */
    protected $resolver = null;

    public function __construct()
    {
        $this->resolver = new ListReaderResolver();
    }

    /**
     * @param string $filePath
     *
     * @return CaptureList
     */
    public function create($filePath)
    {
        $fileInfo = new SplFileInfo($filePath);

        if (!$fileInfo->isFile()) {
            throw new RuntimeException(sprintf(
                'File not found: %s',
                $filePath
            ));
        }

        $listReader = $this->resolver->resolve($fileInfo->getExtension());

        return $listReader->read($fileInfo);
    }
}
