<?php

namespace Momo\SimpleCaptureTool\CaptureUtil\ListReader;

use League\Csv\Reader;
use Momo\SimpleCaptureTool\CaptureUtil\CaptureItem;
use Momo\SimpleCaptureTool\CaptureUtil\CaptureList;
use Momo\SimpleCaptureTool\CaptureUtil\ListReaderInterface;

class CsvReader implements ListReaderInterface
{
    protected $acceptableEncodings = [
        'SJIS-WIN',
        'UTF-8',
    ];

    public function supports($format)
    {
        return $format === 'csv';
    }

    public function read($filePath)
    {
        $originalDetectOrder = mb_detect_order();

        mb_detect_order($this->acceptableEncodings);

        $content = file_get_contents($filePath);

        $contentEncoding = mb_detect_encoding($content);

        if ($contentEncoding === false) {
            throw new \RuntimeException(sprintf(
                'Unknown encoding of file: %s, only %s acceptable',
                $filePath,
                implode(',', $this->acceptableEncodings)
            ));
        }

        $converted = mb_convert_encoding($content, 'UTF-8', $contentEncoding);

        $reader = Reader::createFromString($converted);

        $captureList = new CaptureList();

        foreach ($reader->setOffset(1)->fetchAssoc(['name', 'url']) as $item) {
            $captureList->addItem(new CaptureItem(
                $item['name'],
                $item['url']
            ));
        }

        mb_detect_order($originalDetectOrder);

        return $captureList;
    }
}
