<?php

namespace Momo\SimpleCaptureTool\CaptureUtil\ListReader;

use League\Csv\Reader;
use Momo\SimpleCaptureTool\CaptureUtil\CaptureItem;
use Momo\SimpleCaptureTool\CaptureUtil\CaptureList;
use Momo\SimpleCaptureTool\CaptureUtil\ListReaderInterface;

class CsvReader implements ListReaderInterface
{
    /**
     * @var array
     */
    protected $encodings = [
        'ASCII',
        'UTF-8',
        'SJIS-win',
    ];

    public function supports($format)
    {
        return $format === 'csv';
    }

    public function read($filePath)
    {
        $content = $this->prepareCsvContent($filePath);

        $reader = Reader::createFromString($content);

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

    /**
     * @param string $filePath
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    private function prepareCsvContent($filePath)
    {
        $content = file_get_contents($filePath);

        $contentEncoding = mb_detect_encoding($content, $this->acceptableEncodings());

        if ($contentEncoding === false) {
            throw new \RuntimeException(sprintf(
                'Unknown encoding of file: %s',
                $filePath
            ));
        }

        return mb_convert_encoding($content, 'UTF-8', $contentEncoding);
    }

    /**
     * @return string[]
     */
    private function acceptableEncodings()
    {
        return $this->encodings;
    }
}
