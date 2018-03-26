<?php

namespace Momo\Selenium\CaptureUtil;

use Momo\Selenium\CaptureUtil\ListReader\CsvReader;
use Momo\Selenium\CaptureUtil\ListReader\YamlReader;

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
     * @return \Momo\Selenium\CaptureUtil\ListReaderInterface
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
