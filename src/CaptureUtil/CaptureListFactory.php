<?php

namespace Momo\SimpleCaptureTool\CaptureUtil;

class CaptureListFactory
{
    protected $resolver = null;

    public function __construct()
    {
        $this->resolver = new ListReaderResolver();
    }

    /**
     * @param string $filePath
     *
     * @return Momo\SimpleCaptureTool\CaptureUtil\CaptureList
     */
    public function create($filePath)
    {
        $fileInfo = new \SplFileInfo($filePath);

        if (!$fileInfo->isFile()) {
            throw new \RuntimeException(sprintf(
                'File not found: %s',
                $filePath
            ));
        }

        $listReader = $this->resolver->resolve($fileInfo->getExtension());

        return $listReader->read($fileInfo->getPathname());
    }
}
