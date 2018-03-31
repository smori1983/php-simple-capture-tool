<?php

namespace Momo\SimpleCaptureTool\CaptureUtil;

use Momo\SimpleCaptureTool\CaptureUtil\ListReader\CsvReader;
use Momo\SimpleCaptureTool\CaptureUtil\ListReader\YamlReader;

class ListReaderResolver
{
    protected $readers = [];

    public function __construct()
    {
        $this->readers[] = new CsvReader();
        $this->readers[] = new YamlReader();
    }

    /**
     * @param string $format
     *
     * @return \Momo\SimpleCaptureTool\CaptureUtil\ListReaderInterface
     * @throw \RuntimeException
     */
    public function resolve($format)
    {
        foreach ($this->readers as $reader) {
            if ($reader->supports($format)) {
                return $reader;
            }
        }

        throw new \RuntimeException(sprintf(
            'Unsupported format: %s',
            $format
        ));
    }
}
