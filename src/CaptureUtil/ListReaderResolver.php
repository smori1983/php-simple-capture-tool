<?php

namespace Momo\SimpleCaptureTool\CaptureUtil;

use Momo\SimpleCaptureTool\CaptureUtil\ListReader\CsvReader;
use Momo\SimpleCaptureTool\CaptureUtil\ListReader\YamlReader;
use RuntimeException;

class ListReaderResolver
{
    /**
     * @var ListReaderInterface[]
     */
    protected $readers = [];

    public function __construct()
    {
        $this->readers[] = new CsvReader();
        $this->readers[] = new YamlReader();
    }

    /**
     * @param string $format
     *
     * @return ListReaderInterface
     *
     * @throws RuntimeException
     */
    public function resolve($format)
    {
        foreach ($this->readers as $reader) {
            if ($reader->supports($format)) {
                return $reader;
            }
        }

        throw new RuntimeException(sprintf(
            'Unsupported format: %s',
            $format
        ));
    }
}
