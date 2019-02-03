<?php

namespace Momo\SimpleCaptureTool\CaptureUtil\ListReader;

use League\Csv\Reader;
use Momo\SimpleCaptureTool\CaptureUtil\CaptureItem;
use Momo\SimpleCaptureTool\CaptureUtil\CaptureList;
use Momo\SimpleCaptureTool\CaptureUtil\ListReaderInterface;

class CsvReader implements ListReaderInterface
{
    /**
     * @var string[]
     */
    protected $acceptableEncodings = [
        'ASCII',
        'UTF-8',
        'SJIS-win',
    ];

    public function supports($format)
    {
        return $format === 'csv';
    }

    public function read(\SplFileInfo $file)
    {
        $captureList = new CaptureList();

        /** @var \League\Csv\Reader $reader */
        $reader = Reader::createFromString($this->prepareCsvContent($file));

        foreach ($reader->setOffset(1)->fetchAssoc(['name', 'url']) as $item) {
            $captureList->addItem(new CaptureItem($item['name'], $item['url']));
        }

        return $captureList;
    }

    /**
     * @param \SplFileInfo $file
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    private function prepareCsvContent(\SplFileInfo $file)
    {
        $content = file_get_contents($file->getPathname());

        $contentEncoding = mb_detect_encoding($content, $this->acceptableEncodings);

        if ($contentEncoding === false) {
            throw new \RuntimeException(sprintf(
                'Unknown encoding of file: %s',
                $file->getPathname()
            ));
        }

        return mb_convert_encoding($content, 'UTF-8', $contentEncoding);
    }
}
